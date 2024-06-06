<?php
include "access-token.php";
date_default_timezone_set("Africa/Nairobi");

$query_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpushquery/v1/query';

$businessShortCode = "174379";
$timeStamp = date("YmdHis");
$passKey="bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
$password = base64_encode($businessShortCode . $passKey . $timeStamp);
$checkOutReqId = 'ws_CO_06062024120536792714352684';

$query_header = ['Content-Type: application/json', 'Authorization: Bearer ' . $access_token];

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $query_url);
curl_setopt($curl, CURLOPT_HTTPHEADER, $query_header);

$curl_data = array(
    "BusinessShortCode" => $businessShortCode,
    "Password" => $password,
    "Timestamp" => $timeStamp,
    "CheckoutRequestID" => 'ws_CO_06062024120536792714352684'
);

$data_string = json_encode($curl_data);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$curl_res = curl_exec($curl);
$data_to = json_decode($curl_res);

echo $curl_res;

if (isset($data_to->ResultCode)) {
    $resultCode = $data_to->ResultCode;
    if($resultCode === "1037"){
        echo "Timeout in completing transaction";
    }elseif($resultCode === "1032"){
        echo "Transaction cancelled by user";
    }elseif($resultCode === "1"){
        echo "Balance is insufficient for the transaction";
    }elseif($resultCode === "0"){
        echo "Transaction Succesfull";
    }
}
curl_close($curl);

?>