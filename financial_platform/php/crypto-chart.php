<?php
$cryptoId = isset($_GET['cryptoId']) ? $_GET['cryptoId'] : 'bitcoin'; // Default je Bitcoin

$url = "https://api.coingecko.com/api/v3/coins/$cryptoId/market_chart?vs_currency=usd&days=7";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$response = curl_exec($ch);
curl_close($ch);

echo $response;
?>
