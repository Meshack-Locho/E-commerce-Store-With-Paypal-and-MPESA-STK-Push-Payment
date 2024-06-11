<?php

$CLIENT_ID = "AdEQ-NrylGGg-SxyEkJ1cXhyQWe6os1_HLtlvzONtyqOlxHr27IR5Ev2FDiwYB5IoEVcOeG_tjCdofMn";
$CLIENT_SECRET = "EMKzKNmYFHCCZgXcj4epF761gTPyoVMvQr0slaRO4cbchm5rJmDsjvZt3nDCyrlpfroo0KfxV8TjVnq1";

$url = "https://api-m.sandbox.paypal.com/v1/oauth2/token";
$headers = array(
    'Content-Type: application/x-www-form-urlencoded'
);
$data = "grant_type=client_credentials";
$password = base64_encode("$CLIENT_ID:$CLIENT_SECRET");

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_USERPWD, "$CLIENT_ID:$CLIENT_SECRET");
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$res = curl_exec($ch);

if(curl_errno($ch)){
    echo 'Curl error: ' . curl_error($ch);
}


curl_close($ch);


$dec = json_decode($res);
$access_token = $dec->access_token;
$token_type = $dec->token_type;
$appId = $dec->app_id;


?>