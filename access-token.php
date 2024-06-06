<?php
//MPESA API KEYS
$consumerKey = "al1uf8M9kz7FpR0WG23yGSGGVvmNbFYHFiJyEqOwYNdI3tZB";
$consumerSecret = "YccFlvYRoXMhqmXl3LCyqbVo8USTvihL1UM2zjtutezEujd8MySuqeUzQ2S1Ne9G";


//ACCESS TOKEN URL

$tokenUrl = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";

$headers = ["Content-Type: application/json; charset=utf-8"];

$ch = curl_init($tokenUrl);

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_USERPWD, $consumerKey. ":" . $consumerSecret);

$response = curl_exec($ch);
$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

$response = json_decode($response);
$access_token = $response->access_token;

curl_close($ch);
?>