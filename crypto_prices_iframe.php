<?php
header('Content-Type: text/html; charset=UTF-8');
// 行情 iframe：10 分钟自动刷新，使用免费公开数据源（CoinGecko + 新浪）。
$cryptos = [
    'bitcoin'            => ['label' => 'Bitcoin',           'ticker' => 'BTC'],
    'ethereum'           => ['label' => 'Ethereum',          'ticker' => 'ETH'],
    'binancecoin'        => ['label' => 'BNB',               'ticker' => 'BNB'],
    'solana'             => ['label' => 'Solana',            'ticker' => 'SOL'],
    'ripple'             => ['label' => 'XRP',               'ticker' => 'XRP'],
    'cardano'            => ['label' => 'Cardano',           'ticker' => 'ADA'],
    'dogecoin'           => ['label' => 'Dogecoin',          'ticker' => 'DOGE'],
    'toncoin'            => ['label' => 'Toncoin',           'ticker' => 'TON'],
    'tron'               => ['label' => 'TRON',              'ticker' => 'TRX'],
    'avalanche-2'        => ['label' => 'Avalanche',         'ticker' => 'AVAX'],
    'chainlink'          => ['label' => 'Chainlink',         'ticker' => 'LINK'],
    'litecoin'           => ['label' => 'Litecoin',          'ticker' => 'LTC']
];

$cnMetalStocks = [
    'sh601899' => '紫金矿业',
    'sh600489' => '中金黄金',
    'sh600547' => '山东黄金',
    'sz002237' => '恒邦股份',
    'sz000975' => '银泰黄金',
    'sh601069' => '西部黄金',
    'sh600988' => '赤峰黄金',
    'sz000603' => '盛达资源',
    'sh601212' => '白银有色',
    'sz002155' => '湖南黄金'
];

function fetchCoinGeckoPrices(array $cryptos, string $currency = 'usd'): array
{
    if (!$cryptos) {
        return [];
    }

    $ids = implode(',', array_keys($cryptos));
    $url = sprintf(
        'https://api.coingecko.com/api/v3/simple/price?ids=%s&vs_currencies=%s',
        urlencode($ids),
        urlencode($currency)
    );

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 12,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_USERAGENT => 'aiAllinone/1.0'
    ]);

    $response = curl_exec($ch);
    $status   = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    $err      = curl_error($ch);
    curl_close($ch);

    if ($status !== 200 || $response === false) {
        error_log('fetchCoinGeckoPrices error: ' . ($err ?: 'status ' . $status));
        return [];
    }

    $decoded = json_decode($response, true);
    return is_array($decoded) ? $decoded : [];
}

function fetchSinaCnQuotes(array $codes): array
{
    $quotes = [];
    foreach ($codes as $code => $label) {
        $url = "https://hq.sinajs.cn/list={$code}";

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 8,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => ['Referer: https://finance.sina.com.cn/'],
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122 Safari/537.36'
        ]);

        $resp  = curl_exec($ch);
        $state = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        curl_close($ch);

        if ($state !== 200 || !$resp) {
            continue;
        }

        if (preg_match('/="([^"]*)"/', $resp, $m)) {
            $raw   = iconv('GBK', 'UTF-8//IGNORE', $m[1]);
            $parts = explode(',', $raw);
            // 0:名称, 3:最新价, 30:日期, 31:时间
            if (count($parts) > 4 && is_numeric($parts[3])) {
                $quotes[$code] = [
                    'name'  => $parts[0] ?: $label,
                    'price' => (float) $parts[3],
                    'date'  => $parts[30] ?? '',
                    'time'  => $parts[31] ?? ''
                ];
            }
        }
    }
    return $quotes;
}

$cryptoPrices = fetchCoinGeckoPrices($cryptos);
$stockPrices  = fetchSinaCnQuotes($cnMetalStocks);
$lastUpdated  = date('Y-m-d H:i:s');
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8" />
    <title>行情看板</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="refresh" content="600">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #0f111a;
            color: #f0f8ff;
        }
        .wrapper { padding: 20px; }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #111728;
            border-radius: 8px;
            overflow: hidden;
        }
        th, td { padding: 12px 10px; text-align: left; }
        th { background-color: #151d33; font-weight: 600; letter-spacing: 0.5px; }
        tr:nth-child(even) { background-color: #10162a; }
        tr:hover { background-color: #1a2239; }
        .price { font-variant-numeric: tabular-nums; }
        .timestamp { margin-top: 12px; font-size: 12px; color: #a8b3cf; text-align: right; }
        h2 { margin: 16px 0 10px; color: #f0f8ff; }
        .section { margin-bottom: 28px; }
        .error { color: #ef5350; padding: 10px; background-color: rgba(239, 83, 80, 0.1); border-radius: 6px; margin-top: 10px; }
        .tv-wrap { height: 520px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="section">
            <h2>主流加密货币（USD）</h2>
            <table>
                <thead>
                    <tr>
                        <th>币种</th>
                        <th>代码</th>
                        <th>价格 (USD)</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!$cryptoPrices): ?>
                    <tr><td colspan="3" class="error">暂时无法获取加密货币价格，请稍后刷新。</td></tr>
                <?php else: ?>
                    <?php foreach ($cryptos as $id => $meta): ?>
                        <?php $price = $cryptoPrices[$id]['usd'] ?? null; ?>
                        <tr>
                            <td><?= htmlspecialchars($meta['label'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($meta['ticker'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td class="price"><?= $price ? '$' . number_format((float) $price, 4) : '—' ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
            <div class="tv-wrap">
                <div class="tradingview-widget-container">
                    <div class="tradingview-widget-container__widget"></div>
                    <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-market-overview.js" async>
{
    "colorTheme": "dark",
    "dateRange": "1M",
    "showChart": true,
    "locale": "zh_CN",
    "width": "100%",
    "height": "500",
    "isTransparent": false,
    "showSymbolLogo": true,
    "showIntervalTabs": true,
    "timeframe": "1D",
    "chartType": "candlesticks",
    "tabs": [
        {
            "title": "加密日K/分时",
            "symbols": [
                {"s": "BINANCE:BTCUSDT", "d": "BTC"},
                {"s": "BINANCE:ETHUSDT", "d": "ETH"},
                {"s": "BINANCE:BNBUSDT", "d": "BNB"},
                {"s": "BINANCE:SOLUSDT", "d": "SOL"},
                {"s": "BINANCE:XRPUSDT", "d": "XRP"},
                {"s": "BINANCE:ADAUSDT", "d": "ADA"},
                {"s": "BINANCE:DOGEUSDT", "d": "DOGE"}
            ]
        }
    ]
}
                    </script>
                </div>
            </div>
        </div>

        <div class="section">
            <h2>A股黄金/白银矿产股</h2>
            <table>
                <thead>
                    <tr>
                        <th>股票</th>
                        <th>代码</th>
                        <th>价格 (CNY)</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!$stockPrices): ?>
                    <tr><td colspan="3" class="error">暂时无法获取A股行情，请稍后刷新。</td></tr>
                <?php else: ?>
                    <?php foreach ($cnMetalStocks as $code => $label): ?>
                        <?php $row = $stockPrices[$code] ?? null; ?>
                        <tr>
                            <td><?= htmlspecialchars($row['name'] ?? $label, ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($code, ENT_QUOTES, 'UTF-8') ?></td>
                            <td class="price"><?= $row ? number_format($row['price'], 2) : '—' ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
            <div class="tv-wrap">
                <div class="tradingview-widget-container">
                    <div class="tradingview-widget-container__widget"></div>
                    <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-market-overview.js" async>
{
    "colorTheme": "dark",
    "dateRange": "1M",
    "showChart": true,
    "locale": "zh_CN",
    "width": "100%",
    "height": "500",
    "isTransparent": false,
    "showSymbolLogo": true,
    "showIntervalTabs": true,
    "timeframe": "1D",
    "chartType": "candlesticks",
    "tabs": [
        {
            "title": "A股黄金/白银",
            "symbols": [
                {"s": "SSE:601899", "d": "紫金矿业"},
                {"s": "SSE:600489", "d": "中金黄金"},
                {"s": "SSE:600547", "d": "山东黄金"},
                {"s": "SZSE:002237", "d": "恒邦股份"},
                {"s": "SZSE:000975", "d": "银泰黄金"},
                {"s": "SSE:601069", "d": "西部黄金"},
                {"s": "SSE:600988", "d": "赤峰黄金"},
                {"s": "SZSE:000603", "d": "盛达资源"},
                {"s": "SSE:601212", "d": "白银有色"},
                {"s": "SZSE:002155", "d": "湖南黄金"}
            ]
        }
    ]
}
                    </script>
                </div>
            </div>
        </div>

        <div class="timestamp">最后更新：<?= htmlspecialchars($lastUpdated, ENT_QUOTES, 'UTF-8') ?>（每10分钟自动刷新）</div>
    </div>
</body>
</html>
