<?php
session_start();
include "access-token.php";
include "db.php";
date_default_timezone_set("Africa/Nairobi");

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
$formData = $_SESSION['formData'];

$firstName = $formData["first-name"];
$secondName = $formData["second-name"];
$email = $formData["email"];
$address = $formData["address"];
$user_phone = $formData["phone"];
$paymentType = $formData["payment-type"];
$country = $formData["country"];
$city = $formData["city"];
$postal_code = $formData["postal-code"];
if (isset($formData["Order-type"])) {
    $typeofDelivery = $formData["Order-type"];
}else{
    $typeofDelivery = "";
}




$query_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpushquery/v1/query';

$businessShortCode = "174379";
$timeStamp = date("YmdHis");
$passKey="bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
$password = base64_encode($businessShortCode . $passKey . $timeStamp);
$checkOutReqId = $_SESSION["reqId"];

$query_header = ['Content-Type: application/json', 'Authorization: Bearer ' . $access_token];
$curl_data = array(
    "BusinessShortCode" => $businessShortCode,
    "Password" => $password,
    "Timestamp" => $timeStamp,
    "CheckoutRequestID" => $checkOutReqId
);

$data_string = json_encode($curl_data);

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $query_url);
curl_setopt($curl, CURLOPT_HTTPHEADER, $query_header);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$curl_res = curl_exec($curl);
$data_to = json_decode($curl_res);

// echo $curl_res . "<br><br>";
// var_dump($data_to);
// var_dump($data_to->errorCode);

if (isset($data_to->ResultCode)) {
    $resultCode = $data_to->ResultCode;
    if($resultCode === "1037"){
        $orderStatus = "Unsuccessful";
        echo "<div class='checkout-status'>
                <h3>Dear Customer, There was a Timeout in completing transaction. Please try agiain after a few minutes.</h3>
                <a href='checkout.php'>Return to Checkout <i class='fa-solid fa-credit-card'></i></a>
              </div>";
    }elseif($resultCode === "1032"){
        $orderStatus = "Unsuccessful";
        echo "<div class='checkout-status'>
                <h3>Dear Customer, You Cancelled the Transaction.</h3>
                <a href='index.php'>Return to Shop <i class='fa-solid fa-bag-shopping'></i></a>
              </div>";
    }elseif($resultCode === "1"){
        $orderStatus = "Unsuccessful";
        echo "<div class='checkout-status'>
                <h3>Dear Customer, You Balance is insufficient for the transaction.</h3>  
                <a href='cart.php'>Return to Cart <i class='fa-solid fa-cart-shopping'></i></a>
              </div>";
    }elseif($resultCode === "0"){
        
        $headers = "From: meshacklocho@meshacklocho.co.ke\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
      
        $message = "
            <h2>New Order:</h2> <br><br>
            Name: $firstName $secondName <br>
            Email: $email <br>
            Type of delivery: $typeofDelivery <br>
            Payment Method: $paymentType <br>
            Address: $address <br>
            City: $city <br>
            Postal-code: $postal_code <br>
            Phone Number: $user_phone <br><br>
            Total: $total <br><br>
            Cart items: <br><br> \n";
        if (!isset($_SESSION["id"])) {
                foreach ($cartItems as $item){
                $message .= "Name: " . $item["name"] . "<br>Price: KSH" . $item["price"] . "<br><br>" . "\n";
            }
        }else{
            foreach ($dec as $item){
                $message .= "Name: " . $item->name . "<br>Price: KSH" . $item->price . "<br><br>" . "\n";
            }
        }
        
        mail("meshacklocho5@gmail.com", "ORDERED ITEMS", $message, $headers);
        echo "<div class='checkout-status'>
                <h3>Dear Customer, the Transaction was successful.</h3>
                <a href='index.php'>Return to Shop <i class='fa-solid fa-bag-shopping'></i></a>
              </div>";
        
        $orderStatus = "Successful";
        
    }
              
        if (isset($_SESSION["id"])) {
                $allItems = get_object_vars($dec);
                $numberofItems = count($allItems);
                $stmt = $conn2->prepare("INSERT INTO user_orders (user_id, delivery_type, total, status, payment_method, no_of_items) VALUES (?,?,?,?,?,?)");
                $stmt->bind_param('isssss', $user_id, $typeofDelivery, $total, $orderStatus, $paymentType, $numberofItems);
                $stmt->execute();
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