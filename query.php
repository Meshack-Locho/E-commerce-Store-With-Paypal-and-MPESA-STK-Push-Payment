<?php
session_start();
include "access-token.php";
date_default_timezone_set("Africa/Nairobi");

$query_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpushquery/v1/query';

$businessShortCode = "174379";
$timeStamp = date("YmdHis");
$passKey="bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
$password = base64_encode($businessShortCode . $passKey . $timeStamp);
$checkOutReqId = $_SESSION["reqId"];

$query_header = ['Content-Type: application/json', 'Authorization: Bearer ' . $access_token];

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $query_url);
curl_setopt($curl, CURLOPT_HTTPHEADER, $query_header);

$curl_data = array(
    "BusinessShortCode" => $businessShortCode,
    "Password" => $password,
    "Timestamp" => $timeStamp,
    "CheckoutRequestID" => $checkOutReqId
);

$data_string = json_encode($curl_data);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$curl_res = curl_exec($curl);
$data_to = json_decode($curl_res);

// echo $curl_res;

if (isset($data_to->ResultCode)) {
    $resultCode = $data_to->ResultCode;
    if($resultCode === "1037"){
        echo "<div class='checkout-status'>
                <h3>Dear Customer, There was a Timeout in completing transaction. Please try agiain after a few minutes.</h3>
                <a href='checkout.php'>Return to Checkout <i class='fa-solid fa-credit-card'></i></a>
              </div>";
    }elseif($resultCode === "1032"){
        echo "<div class='checkout-status'>
                <h3>Dear Customer, You Cancelled the Transaction.</h3>
                <a href='index.php'>Return to Shop <i class='fa-solid fa-bag-shopping'></i></a>
              </div>";
    }elseif($resultCode === "1"){
        echo "<div class='checkout-status'>
                <h3>Dear Customer, You Balance is insufficient for the transaction.</h3>  
                <a href='cart.php'>Return to Cart <i class='fa-solid fa-cart-shopping'></i></a>
              </div>";
    }elseif($resultCode === "0"){
        echo "<div class='checkout-status'>
                <h3>Dear Customer, the Transaction was successful.</h3>
                <a href='index.php'>Return to Shop <i class='fa-solid fa-bag-shopping'></i></a>
              </div>";
    }
}
curl_close($curl);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Status</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Josefin Sans">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body{
            height: 100vh;
        }
    </style>
</head>
<body>
    
</body>
</html>