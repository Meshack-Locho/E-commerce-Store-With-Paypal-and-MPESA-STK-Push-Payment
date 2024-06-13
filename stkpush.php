<?php

//SETTING SESSION CART
session_start();
include("access-token.php");
include "db.php";
if (!isset($_SESSION["id"])) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
        
    }
    $cartItems = $_SESSION["cart"];
    
    
    //CART TOTAL
    $total = $_SESSION["total"];
}else{
        $user_id = $_SESSION["id"];
        $stmt = $conn2->prepare("SELECT cart FROM users WHERE id=?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        $dec = json_decode($row['cart']);
      
        
        $total = 0;

        foreach ($dec as $value) {
            $total += $value->price;
        }
}

//FORM SUBMISSION

if ($_SERVER["REQUEST_METHOD"] === "POST") {

date_default_timezone_set("Africa/Nairobi");

$user_phone = $_POST["phone"];
$email = $_POST["email"];
$firstName = $_POST["first-name"];
$secondName = $_POST["second-name"];
$address = $_POST["address"];
$location = $_POST['city'];
$typeofDelivery = $_POST["Order-type"];
$paymentType = $_POST["payment-type"];


//REQUEST URL FROM SAF SANDBOX
$requestUrl = "https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest";

//CALLBACK URL TO RECEIVE TRANSACTION STATUS
$callBackUrl = "https://2be3-2c0f-fe38-2402-148-5db0-bdd3-cca1-fabd.ngrok-free.app/mysite/ec-website/callback.php";

//DETAILS FOR THE TRANSACTION LOGIC
$passKey="bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
$BusinessShortCode = "174379";
$timeStamp = date("YmdHis");

//ENCODING PASSWORD
$password = base64_encode($BusinessShortCode . $passKey . $timeStamp);
$phone = $user_phone;
$cash = $total;
$partyA = $phone;
$partyB = "254708374149";
$accoundRef = "Meshack Locho";
$transactionDesc = "STK PUSH TEST";

//HEADER FOR THE CONTENT TYPE WHICH IS JSON
$stkPushHeader = ["Content-Type: application/json", "Authorization: Bearer " . $access_token];

//INITIATING THE API WITH CURL
$curl = curl_init(); //INITIATING API
curl_setopt($curl, CURLOPT_URL, $requestUrl); //SETTING THE URL FOR THE API
curl_setopt($curl, CURLOPT_HTTPHEADER, $stkPushHeader); //SETTING THE HEADER FOR THE CONTENT 

//ARRAY CARRYING THE TRANSACTION INFO 
$curl_post_data = array(
    "BusinessShortCode"=> 174379,
    "Password"=> $password,
    "Timestamp"=> $timeStamp,
    "TransactionType"=> "CustomerPayBillOnline",
    "Amount"=> (int)$cash,
    "PartyA"=> $phone,
    "PartyB"=> 174379,
    "PhoneNumber"=> $phone,
    "CallBackURL"=> "https://2be3-2c0f-fe38-2402-148-5db0-bdd3-cca1-fabd.ngrok-free.app/mysite/ec-website/callback.php",
    "AccountReference"=> "Meshack Locho Web Services",
    "TransactionDesc"=> "Payment of X"
);

//CONVERTING THE ARRAY INTO JSON FORMAT TO SEND TO THE SAF API IN JSON FORMAT
$data_to_string = json_encode($curl_post_data);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data_to_string); //THE FIELDS FOR THE DETAILS REQUIRED FOR THE TRANSACTION LINKED TO OUR ARRAY
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$curl_res = curl_exec($curl); // CURL EXECUTION
$enc = json_decode($curl_res); // CONERTING DATA DROM JSON FORMAT

//RESPONSE CODE 0 MEANS TRANSACTION IS SUCCESSFUL
if ($enc->ResponseCode === "0") {
    $CheckoutRequestID = $enc->CheckoutRequestID;
    
    $_SESSION['formData'] = $_POST;

    echo "<div class='checkout-status'>
        <h2>$enc->CustomerMessage</h2>
        <h2>You will receive a prompt on your phone, Enter your Mpesa Pin to validate the transaction and click Continue</h2>
        <a href='query.php'>Continue</a>
      </div>";

      $_SESSION["reqId"] = $CheckoutRequestID;
}else{
    echo "<div class='checkout-status'>
            <h2>Transaction failed please try again</h2>
        </div>";
}

curl_close($curl);



}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Status</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Josefin Sans">

    <style>
        body{
            height: 100vh;
        }
    </style>
</head>
<body>
    
</body>
</html>