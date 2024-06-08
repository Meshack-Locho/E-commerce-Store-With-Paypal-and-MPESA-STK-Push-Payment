<?php

//SETTING SESSION CART
session_start();
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
    
}
$cartItems = $_SESSION["cart"];
include("access-token.php");

//CART TOTAL
$total = $_SESSION["total"];

//FORM SUBMISSION

if ($_SERVER["REQUEST_METHOD"] === "POST") {

date_default_timezone_set("Africa/Nairobi");

$user_phone = $_POST["phone"];
$email = $_POST["email"];
$firstName = $_POST["first-name"];
$secondName = $_POST["second-name"];
$address = $_POST["address"];
$location = $_POST['location'];
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

    echo "<div class='checkout-status'>
        <h2>$enc->CustomerMessage</h2>
        <h2>$curl_res</h2>
      </div>";

      $headers = "From: meshacklocho@meshacklocho.co.ke\r\n";
      $headers .= "MIME-Version: 1.0\r\n";
      $headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
      
      $message = "
      New Order: <br><br>
      Name: $firstName $secondName <br>
      Email: $email <br>
      Type of delivery: $typeofDelivery <br>
      Payment Method: $paymentType <br>
      Address: $address <br>
      Phone Number: $user_phone <br><br>
      Cart items: <br><br> \n";
      foreach ($cartItems as $item){
          $message .= "Name: " . $item["name"] . "<br>Price: KSH" . $item["price"] . "<br><br>" . "\n";
      }
      mail("meshacklocho5@gmail.com", "ORDERED ITEMS", $message, $headers);

      sleep(5);

      header("Location: query.php");

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