import sqlite3
import requests
import pandas as pd
import numpy as np
from datetime import datetime
from time import sleep

# ================== 配置层 ==================
class Config:
    API_URL = "https://api.coingecko.com/api/v3/coins/markets"
    DB_PATH = "crypto_data.db"
    FETCH_INTERVAL = 180  # 3分钟
    REQUEST_TIMEOUT = 10
    RETRY_COUNT = 3

# ================== 数据存储层 ==================
class Database:
    def __init__(self, db_path):
        self.conn = sqlite3.connect(db_path)
        self._init_tables()

    def _init_tables(self):
        """初始化数据库表结构"""
        self.conn.execute("""
            CREATE TABLE IF NOT EXISTS history (
                timestamp INTEGER,
                symbol TEXT,
                price REAL,
                speed REAL,
                PRIMARY KEY (timestamp, symbol)
            )
        """)
        
        self.conn.execute("""
            CREATE TABLE IF NOT EXISTS metrics (
                timestamp INTEGER,
                symbol TEXT,
                acceleration REAL,
                PRIMARY KEY (timestamp, symbol)
            )
        """)

    def save_history(self, df):
        """保存历史数据（价格+速度）"""
        if df.empty:
            print("没有数据可保存到历史表")
            return
        
        current_timestamp = int(datetime.now().timestamp())
        print(f"将 {len(df)} 条历史记录插入数据库")
        
        # Prepare the data with current timestamp
        data_to_insert = df.copy()
        data_to_insert["timestamp"] = current_timestamp
        
        # Use executemany with INSERT OR REPLACE for better performance
        insert_sql = """
            INSERT OR REPLACE INTO history (timestamp, symbol, price, speed)
            VALUES (?, ?, ?, ?)
        """
        
        values = data_to_insert[["timestamp", "symbol", "price", "speed"]].values.tolist()
        
        try:
            self.conn.executemany(insert_sql, values)
            self.conn.commit()
            print(f"历史数据已成功保存，{len(df)} 条记录")
        except sqlite3.Error as e:
            print(f"保存历史数据时发生错误: {e}")
            self.conn.rollback()

    def save_metrics(self, df):
        """保存指标数据（加速度）"""
        if df.empty:
            print("没有数据可保存到指标表")
            return
        
        current_timestamp = int(datetime.now().timestamp())
        print(f"将 {len(df)} 条指标记录插入数据库")
        
        # Prepare the data with current timestamp
        data_to_insert = df.copy()
        data_to_insert["timestamp"] = current_timestamp
        
        # Use executemany with INSERT OR REPLACE for better performance
        insert_sql = """
            INSERT OR REPLACE INTO metrics (timestamp, symbol, acceleration)
            VALUES (?, ?, ?)
        """
        
        values = data_to_insert[["timestamp", "symbol", "acceleration"]].values.tolist()
        
        try:
            self.conn.executemany(insert_sql, values)
            self.conn.commit()
            print(f"指标数据已成功保存，{len(df)} 条记录")
        except sqlite3.Error as e:
            print(f"保存指标数据时发生错误: {e}")
            self.conn.rollback()

# ================== 数据采集层 ==================
class CoinGeckoAPI:
    @staticmethod
    def fetch_top_coins(top_n=100, retry=Config.RETRY_COUNT):
        """同步获取前N名加密货币数据（带重试机制）"""
        params = {
            "vs_currency": "usd",
            "order": "market_cap_desc",
            "per_page": top_n,
            "page": 1,
            "sparkline": False
        }

        for attempt in range(retry):
            try:
                response = requests.get(
                    Config.API_URL, 
                    params=params,
                    timeout=Config.REQUEST_TIMEOUT
                )
                response.raise_for_status()
                data = response.json()
                
                # 关键数据检验：检查返回的数据
                print(f"成功获取到 {len(data)} 条数据")  
                if len(data) == 0:
                    print("警告：API返回数据为空")
                
                return pd.DataFrame([{
                    "symbol": coin["symbol"].upper(),
                    "price": coin["current_price"],
                    "name": coin["name"]
                } for coin in data])
            except Exception as e:
                if attempt == retry - 1:
                    raise
                sleep(2 ** attempt)
        return pd.DataFrame()

# ================== 计算层 ==================
class MetricsCalculator:
    def __init__(self, db):
        self.db = db

    def calculate(self):
        """计算涨速和加速度（向量化计算）"""
        # 获取最新两批历史数据
        query = """
            SELECT * FROM history 
            WHERE timestamp IN (
                SELECT DISTINCT timestamp 
                FROM history 
                ORDER BY timestamp DESC 
                LIMIT 2
            )
        """
        history = pd.read_sql(query, self.db.conn)
        
        # 关键数据检验：检查历史数据
        print(f"获取到历史数据：{len(history)} 条记录")  # 打印查询到的历史数据数量

        if history.empty or len(history.timestamp.unique()) < 2:
            print("首次运行或数据不足")
            return pd.DataFrame()

        # 向量化计算
        pivoted = history.pivot(index="symbol", columns="timestamp", values=["price", "speed"])
        latest_ts = pivoted.columns.get_level_values(1).max()
        prev_ts = pivoted.columns.get_level_values(1).min()

        # 计算涨速
        price_diff = pivoted["price"][latest_ts] - pivoted["price"][prev_ts]
        pivoted["speed"] = price_diff / (pivoted["price"][prev_ts] + 1e-10)

        # 计算加速度
        speed_diff = pivoted["speed"] - pivoted["speed"][prev_ts]
        pivoted["acceleration"] = speed_diff / (abs(pivoted["speed"][prev_ts]) + 1e-10)

        # 清理数据
        result = pivoted[["speed", "acceleration"]].copy()
        result = result.replace([np.inf, -np.inf], np.nan).fillna(0)
        result = result.reset_index()

        # 关键数据检验：检查计算后的加速度数据
        print(f"计算出的加速度数据：{result.head()}")  # 打印计算结果前5行
        
        return result

# ================== 主程序 ==================
class CryptoMonitor:
    def __init__(self):
        self.db = Database(Config.DB_PATH)
        self.api = CoinGeckoAPI()
        self.calculator = MetricsCalculator(self.db)

    def job(self):
        """定时任务主逻辑"""
        print(f"[{datetime.now()}] 开始数据采集...")
        
        # 获取数据
        raw_data = self.api.fetch_top_coins(100)
        
        # 关键数据检验：检查获取到的原始数据
        print(f"原始数据：{raw_data.head()}")  # 打印数据的前5条
        
        if raw_data.empty:
            print("数据获取失败")
            return

        # 获取上次速度数据
        last_speed = pd.read_sql(
            "SELECT symbol, speed FROM history ORDER BY timestamp DESC LIMIT 1", 
            self.db.conn
        )

        # 关键数据检验：检查上次的速度数据
        print(f"上次速度数据：{last_speed.head()}")  # 打印上次速度数据

        # 合并新旧速度
        merged = pd.merge(raw_data, last_speed, on="symbol", how="left", suffixes=("", "_prev"))
        merged["speed"] = 0.0  # 初始化

        # 关键数据检验：检查合并后的数据
        print(f"合并后的数据：{merged.head()}")  # 打印合并后的数据

        # 保存本次历史数据
        self.db.save_history(merged)
        
        # 计算指标
        metrics = self.calculator.calculate()
        if not metrics.empty:
            self.db.save_metrics(metrics)
            print(f"最新加速度Top 5:\n{metrics.nlargest(5, 'acceleration')}")

    def run(self):
        """启动监控"""
        while True:
            self.job()  # 执行一次数据采集任务
            print(f"等待 {Config.FETCH_INTERVAL} 秒后重新执行任务...")
            sleep(Config.FETCH_INTERVAL)  # 等待180秒（3分钟）

if __name__ == "__main__":
    monitor = CryptoMonitor()
    monitor.run()

