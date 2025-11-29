<?php
$apiKey = '6d274e5a-fe5a-4652-b7ad-6af832fbac6c'; 
$url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest';

$options = [
    "http" => [
        "header" => "X-CMC_PRO_API_KEY: $apiKey\r\n" .
                    "Accept: application/json\r\n"
    ]
];
$context = stream_context_create($options);

$response = file_get_contents($url, false, $context);

header('Content-Type: application/json');
echo $response;
?>