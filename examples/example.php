#!/usr/bin/php
<?php
include('../src/SEP6Client.class.php');

$client = new SEP6Client(
    'sep6.coinqvest.com',
    '/tmp/coinqvest.log' // an optional log file location
);

$response = $client->get('/info');

echo "HTTP Status Code: " . $response->httpStatusCode . "\n\n";
echo "Response Body: " . $response->responseBody . "\n\n";

//$response = $client->get('/deposit', array(
//    'asset_code' => 'BTC',
//    'account' => 'GDONUHZKLSYLDOZWR2TDW25GFXOBWCCKTPK34DLUVSOMFHLGURX6FNU6',
//    'memo' => 'Sent via SEP-6',
//    'memo_type' => 'text'
//));
//
//echo "HTTP Status Code: " . $response->httpStatusCode . "\n\n";
//echo "Response Body: " . $response->responseBody . "\n\n";

//$response = $client->get('/withdraw', array(
//    'asset_code' => 'BTC',
//    'dest' => 'bc1qj633nx575jm28smgcp3mx6n3gh0zg6ndr0ew23'
//));
//
//echo "HTTP Status Code: " . $response->httpStatusCode . "\n\n";
//echo "Response Body: " . $response->responseBody . "\n\n";


# view response object structure:
# print_r($response);