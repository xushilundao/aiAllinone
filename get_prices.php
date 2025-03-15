<?php
// 获取最新加密货币价格的函数
function getCryptoPrice($symbol) {
    $apiUrl = "https://api.coingecko.com/api/v3/simple/price?ids=$symbol&vs_currencies=usd";
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $apiUrl);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($curl);
    curl_close($curl);
    $data = json_decode($result, true);
    return $data[$symbol]['usd'];
}

$symbols = array('bitcoin', 'ethereum', 'tether', 'bnb', 'xrp', 'cardano', 'solana', 'dogecoin', 'polkadot', 'avalanche',
    'shiba-inu', 'polygon', 'dai', 'tron', 'litecoin', 'cronos', 'uniswap', 'wrapped-bitcoin', 'chainlink', 'near',
    'ftx-token', 'monero', 'stellar', 'ethereum-classic', 'algorand', 'cosmos', 'vechain', 'flow', 'internet-computer',
    'decentraland', 'apecoin', 'the-sandbox', 'matic-network', 'axie-infinity', 'theta-network', 'elrond-erd-2', 'hedera-hashgraph',
    'helium', 'chiliz', 'filecoin', 'bitcoin-cash', 'theta-fuel', 'klay-token', 'the-graph', 'ecash', 'bittorrent-old');
$prices = array();

foreach ($symbols as $symbol) {
    $price = getCryptoPrice($symbol);
    $prices[$symbol] = $price;
}

$output = '';
foreach ($prices as $symbol => $price) {
    $output .= ucfirst($symbol) . ": $" . number_format($price, 2) . "<br>";
}

echo $output;
