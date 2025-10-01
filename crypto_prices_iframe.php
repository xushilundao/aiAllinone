<?php
$symbols = [
    'bitcoin' => 'Bitcoin (BTC)',
    'ethereum' => 'Ethereum (ETH)',
    'tether' => 'Tether (USDT)',
    'binancecoin' => 'BNB (BNB)',
    'xrp' => 'XRP (XRP)',
    'cardano' => 'Cardano (ADA)',
    'solana' => 'Solana (SOL)',
    'dogecoin' => 'Dogecoin (DOGE)',
    'polkadot' => 'Polkadot (DOT)',
    'avalanche-2' => 'Avalanche (AVAX)',
    'shiba-inu' => 'Shiba Inu (SHIB)',
    'tron' => 'TRON (TRX)',
    'litecoin' => 'Litecoin (LTC)',
    'chainlink' => 'Chainlink (LINK)',
    'near' => 'NEAR (NEAR)',
    'internet-computer' => 'Internet Computer (ICP)',
    'uniswap' => 'Uniswap (UNI)',
    'hedera-hashgraph' => 'Hedera (HBAR)',
    'aptos' => 'Aptos (APT)',
    'the-graph' => 'The Graph (GRT)'
];

function fetchCryptoPrices(array $symbols, string $currency = 'usd'): array
{
    if (!$symbols) {
        return [];
    }

    $ids = implode(',', array_keys($symbols));
    $apiUrl = sprintf(
        'https://api.coingecko.com/api/v3/simple/price?ids=%s&vs_currencies=%s',
        urlencode($ids),
        urlencode($currency)
    );

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $apiUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_SSL_VERIFYPEER => true,
    ]);

    $response = curl_exec($curl);
    $statusCode = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
    $curlErr = curl_error($curl);
    curl_close($curl);

    if ($statusCode !== 200 || $response === false) {
        error_log('fetchCryptoPrices error: ' . ($curlErr ?: 'status ' . $statusCode));
        return [];
    }

    $decoded = json_decode($response, true);
    return is_array($decoded) ? $decoded : [];
}

$priceData = fetchCryptoPrices($symbols);
$lastUpdated = date('Y-m-d H:i:s');
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8" />
    <title>主流加密货币价格</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="refresh" content="60">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #0f111a;
            color: #f0f8ff;
        }
        .wrapper {
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #111728;
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 12px 10px;
            text-align: left;
        }
        th {
            background-color: #151d33;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        tr:nth-child(even) {
            background-color: #10162a;
        }
        tr:hover {
            background-color: #1a2239;
        }
        .price {
            font-variant-numeric: tabular-nums;
        }
        .timestamp {
            margin-top: 12px;
            font-size: 12px;
            color: #a8b3cf;
            text-align: right;
        }
        .error {
            color: #ef5350;
            padding: 10px;
            background-color: rgba(239, 83, 80, 0.1);
            border-radius: 6px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <table>
            <thead>
                <tr>
                    <th>币种</th>
                    <th>代码</th>
                    <th>价格 (USD)</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!$priceData): ?>
                <tr>
                    <td colspan="3" class="error">暂时无法获取价格，请稍后刷新。</td>
                </tr>
            <?php else: ?>
                <?php foreach ($symbols as $id => $label): ?>
                    <?php
                        $parts = explode(' ', trim($label));
                        $ticker = end($parts);
                        $price = $priceData[$id]['usd'] ?? null;
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($ticker, ENT_QUOTES, 'UTF-8') ?></td>
                        <td class="price">
                            <?= $price ? '$' . number_format((float) $price, 2) : '—' ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
        <div class="timestamp">最后更新：<?= htmlspecialchars($lastUpdated, ENT_QUOTES, 'UTF-8') ?>（每60秒自动刷新）</div>
    </div>
</body>
</html>
