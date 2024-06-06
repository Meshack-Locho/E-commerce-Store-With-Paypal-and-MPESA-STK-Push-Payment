<?php

include("access-token.php");

date_default_timezone_set("Africa/Nairobi");

$requestUrl = "https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest";
$callBackUrl = "https://meshacklocho.co.ke/daraja/callback.php";
$passKey="bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
$BusinessShortCode = "174379";
$timeStamp = date("YmdHis");
$password = base64_encode($BusinessShortCode . $passKey . $timeStamp);
$phone = "254714352684";
$cash = "1";
$partyA = $phone;
$partyB = "254708374149";
$accoundRef = "Meshack Locho";
$transactionDesc = "STK PUSH TEST";
$amount = $cash;
$stkPushHeader = ["Content-Type: application/json", "Authorization: Bearer " . $access_token];

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $requestUrl);
curl_setopt($curl, CURLOPT_HTTPHEADER, $stkPushHeader);

$curl_post_data = array(
    "BusinessShortCode"=> 174379,
    "Password"=> $password,
    "Timestamp"=> $timeStamp,
    "TransactionType"=> "CustomerPayBillOnline",
    "Amount"=> $cash,
    "PartyA"=> $phone,
    "PartyB"=> 174379,
    "PhoneNumber"=> $phone,
    "CallBackURL"=> "https://meshacklocho.co.ke/daraja/callback.php",
    "AccountReference"=> "Meshack Locho Web Services",
    "TransactionDesc"=> "Payment of X"
);

$data_to_string = json_encode($curl_post_data);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data_to_string);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$curl_res = curl_exec($curl);

curl_close($curl);

echo $curl_res;


?>