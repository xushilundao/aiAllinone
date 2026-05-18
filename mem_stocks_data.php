<?php
header('Content-Type: text/html; charset=UTF-8');

/**
 * AI Memory Stocks Fetcher with 2-hour Caching
 * Source: Yahoo Finance Quote API
 */

$cache_file = 'mem_stocks_cache.json';
$cache_time = 7200; // 2 hours

$stocks = [
    '000660.KS' => ['desc' => 'SK海力士 (韩)'],
    '005930.KS' => ['desc' => '三星电子 (韩)'],
    '2408.TW'   => ['desc' => '南亚科 (台)'],
    '2337.TW'   => ['desc' => '旺宏 (台)'],
    '2344.TW'   => ['desc' => '华邦电 (台)'],
    'MU'        => ['desc' => '美光 (美)'],
    'WDC'       => ['desc' => '西部数据 (美)'],
    'STX'       => ['desc' => '希捷 (美)']
];

function fetch_stock_prices($stocks) {
    $results = [];
    $tickers = array_keys($stocks);
    
    // Yahoo Quote API is better for multiple symbols and provides ready-to-use changes
    $url = "https://query1.finance.yahoo.com/v7/finance/quote?symbols=" . implode(',', $tickers);
    
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 15,
        CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
    ]);
    
    $resp = curl_exec($ch);
    curl_close($ch);
    
    if ($resp) {
        $data = json_decode($resp, true);
        $quotes = $data['quoteResponse']['result'] ?? [];
        
        foreach ($tickers as $ticker) {
            $q = null;
            foreach ($quotes as $item) {
                if ($item['symbol'] == $ticker) {
                    $q = $item;
                    break;
                }
            }

            if ($q) {
                $raw_price = $q['regularMarketPrice'] ?? 0;
                $raw_change = $q['regularMarketChangePercent'] ?? 0;
                
                // Format price based on value (Korean Won are large)
                $formatted_price = ($raw_price > 1000) ? number_format($raw_price, 0) : number_format($raw_price, 2);
                
                $results[$ticker] = [
                    'price' => $formatted_price,
                    'change' => number_format($raw_change, 2) . '%',
                    'color' => ($raw_change >= 0) ? '#26a69a' : '#ef5350',
                    'desc' => $stocks[$ticker]['desc']
                ];
            } else {
                $results[$ticker] = [
                    'price' => 'N/A',
                    'change' => '0.00%',
                    'color' => '#fff',
                    'desc' => $stocks[$ticker]['desc']
                ];
            }
        }
    }
    return $results;
}

// Cache Logic
$data_to_show = [];
$cache_exists = file_exists($cache_file);

if ($cache_exists && (time() - filemtime($cache_file) < $cache_time)) {
    $data_to_show = json_decode(file_get_contents($cache_file), true);
} 

if (empty($data_to_show)) {
    $data_to_show = fetch_stock_prices($stocks);
    if (!empty($data_to_show)) {
        file_put_contents($cache_file, json_encode($data_to_show));
    }
}

$last_update = $cache_exists ? date('Y-m-d H:i:s', filemtime($cache_file)) : date('Y-m-d H:i:s');
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        body { margin: 0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; background-color: #0f111a; color: #f0f8ff; overflow: hidden; }
        .container { padding: 10px; }
        table { width: 100%; border-collapse: collapse; background-color: #111728; border-radius: 8px; overflow: hidden; font-size: 13px; table-layout: fixed; }
        th, td { padding: 10px 8px; text-align: left; border-bottom: 1px solid #1a2239; word-wrap: break-word; }
        th { background-color: #151d33; color: #a8b3cf; font-weight: 600; }
        .price { font-family: "Roboto Mono", monospace; font-weight: bold; text-align: right; }
        .change { font-weight: bold; text-align: right; }
        .footer { margin-top: 8px; font-size: 10px; color: #5d667a; text-align: right; }
        small { display: block; color: #5d667a; font-size: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th style="width: 40%">股票名称</th>
                    <th style="width: 30%; text-align: right;">最新价</th>
                    <th style="width: 30%; text-align: right;">涨跌幅</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data_to_show as $ticker => $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['desc']) ?><small><?= $ticker ?></small></td>
                    <td class="price"><?= $row['price'] ?></td>
                    <td class="change" style="color: <?= $row['color'] ?>"><?= $row['change'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="footer">更新于: <?= $last_update ?> (2h Cache)</div>
    </div>
</body>
</html>
