<?php
$apiKey = '6d274e5a-fe5a-4652-b7ad-6af832fbac6c';

$url = "https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest?limit=10"; // Ovde možeš dodati parametre za broj kriptovaluta koje prikazuješ

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'X-CMC_PRO_API_KEY: ' . $apiKey,
    'Accept: application/json'
));

$response = curl_exec($ch);
curl_close($ch);

echo $response;
?>
