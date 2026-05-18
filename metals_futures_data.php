<?php
header('Content-Type: text/html; charset=UTF-8');

/**
 * Global Metals Futures Fetcher - Version 1
 * Caching: 2 hours
 */

$cache_file = 'metals_futures_cache.json';
$cache_time = 7200; // 2 hours

$metals = [
    'GC=F' => ['desc' => '黄金期货 (COMEX)'],
    'SI=F' => ['desc' => '白银期货 (COMEX)'],
    'HG=F' => ['desc' => '精铜期货 (COMEX)'],
    'PL=F' => ['desc' => '铂金期货 (NYMEX)'],
    'PA=F' => ['desc' => '钯金期货 (NYMEX)'],
    'JPY=X' => ['desc' => '日元/美元 (参考)']
];

function fetch_metal_prices($metals) {
    $results = [];
    
    foreach ($metals as $ticker => $info) {
        $url = "https://query1.finance.yahoo.com/v8/finance/chart/{$ticker}?interval=1d&range=1mo";
        
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_USERAGENT => 'Mozilla/5.0'
        ]);
        
        $resp = curl_exec($ch);
        curl_close($ch);
        
        $data_row = [
            'price' => 'N/A',
            'daily_change' => '0.00%',
            'daily_color' => '#fff',
            'monthly_change' => '0.00%',
            'monthly_color' => '#fff',
            'desc' => $info['desc']
        ];

        if ($resp) {
            $json = json_decode($resp, true);
            $res = $json['chart']['result'][0] ?? null;
            if ($res) {
                $meta = $res['meta'];
                $prices = $res['indicators']['quote'][0]['close'] ?? [];
                $prices = array_values(array_filter($prices, function($v) { return !is_null($v); }));

                if (count($prices) >= 1) {
                    $current = $meta['regularMarketPrice'] ?? end($prices);
                    $data_row['price'] = number_format($current, 2);
                    
                    if (count($prices) >= 2) {
                        $yesterday = $prices[count($prices) - 2];
                        $d_diff = $current - $yesterday;
                        $d_pct = ($yesterday > 0) ? ($d_diff / $yesterday) * 100 : 0;
                        $data_row['daily_change'] = number_format($d_pct, 2) . '%';
                        $data_row['daily_color'] = ($d_diff >= 0) ? '#26a69a' : '#ef5350';
                    }

                    $start_month = $prices[0];
                    $m_diff = $current - $start_month;
                    $m_pct = ($start_month > 0) ? ($m_diff / $start_month) * 100 : 0;
                    $data_row['monthly_change'] = number_format($m_pct, 2) . '%';
                    $data_row['monthly_color'] = ($m_diff >= 0) ? '#26a69a' : '#ef5350';
                }
            }
        }
        $results[$ticker] = $data_row;
    }
    return $results;
}

$data_to_show = [];
if (file_exists($cache_file) && (time() - filemtime($cache_file) < $cache_time)) {
    $data_to_show = json_decode(file_get_contents($cache_file), true);
} 

if (empty($data_to_show)) {
    $data_to_show = fetch_metal_prices($metals);
    if (!empty($data_to_show)) {
        file_put_contents($cache_file, json_encode($data_to_show));
    }
}

$last_update = file_exists($cache_file) ? date('Y-m-d H:i:s', filemtime($cache_file)) : date('Y-m-d H:i:s');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { margin: 0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; background-color: #0f111a; color: #f0f8ff; overflow: hidden; }
        .container { padding: 10px; }
        table { width: 100%; border-collapse: collapse; background-color: #111728; border-radius: 8px; overflow: hidden; font-size: 13px; table-layout: fixed; }
        th, td { padding: 10px 8px; text-align: right; border-bottom: 1px solid #1a2239; word-wrap: break-word; }
        th:first-child, td:first-child { text-align: left; width: 40%; }
        th { background-color: #151d33; color: #a8b3cf; font-weight: 600; }
        .price { font-family: "Roboto Mono", monospace; font-weight: bold; }
        .change { font-weight: bold; }
        .footer { margin-top: 8px; font-size: 10px; color: #5d667a; text-align: right; }
        small { display: block; color: #5d667a; font-size: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>期货名称</th>
                    <th>价格</th>
                    <th>今日</th>
                    <th>本月</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data_to_show as $ticker => $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['desc']) ?><small><?= $ticker ?></small></td>
                    <td class="price"><?= $row['price'] ?></td>
                    <td class="change" style="color: <?= $row['daily_color'] ?>"><?= $row['daily_change'] ?></td>
                    <td class="change" style="color: <?= $row['monthly_color'] ?>"><?= $row['monthly_change'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="footer">更新于: <?= $last_update ?> (2h Cache)</div>
    </div>
</body>
</html>
