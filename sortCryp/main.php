<?php
// 数据库文件路径
$db_path = '/opt/lampp/htdocs/sortCryp/bin/crypto_data.db';

// 连接到 SQLite 数据库
try {
    $db = new PDO('sqlite:' . $db_path);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("数据库连接失败: " . $e->getMessage());
}

// 查询每个 symbol 的最新数据
$query = "
    SELECT h.symbol, h.price, h.speed,  h.timestamp
    FROM history h
    ORDER BY h.price desc
";

try {
    $stmt = $db->prepare($query);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("查询失败: " . $e->getMessage());
}

// HTML 页面头部
echo "<!DOCTYPE html>";
echo "<html lang='zh-CN'>";
echo "<head><meta charset='UTF-8'><title>加密货币数据</title></head>";
echo "<body>";

// 展示数据为表格
echo "<table border='1'>";
echo "<tr>";
echo "<th>名称</th>";
echo "<th>价格</th>";
echo "<th>速度</th>";
echo "<th>加速度</th>";
echo "<th>时间</th>";
echo "</tr>";

foreach ($results as $row) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['symbol']) . "</td>";
    echo "<td>" . htmlspecialchars($row['price']) . "</td>";
    echo "<td>" . htmlspecialchars($row['speed']) . "</td>";
    echo "<td>" . htmlspecialchars($row['acceleration']) . "</td>";
    echo "<td>" . htmlspecialchars(date('Y-m-d H:i:s', $row['timestamp'])) . "</td>";
    echo "</tr>";
}

echo "</table>";
echo "</body>";
echo "</html>";

// 关闭数据库连接
$db = null;
?>
