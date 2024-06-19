<?php

session_start();
//HERE IS INCLUDING THE ACCESSTOKEN WHICH IS IN PAYPAL_ACCESS_TOKEN.PHP
include("paypal_access_token.php");
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

$usdtotal = $total/128;
$formatedTotal = number_format($usdtotal, 2);
$user_phone = $_POST["phone"];
$email = $_POST["email"];
$firstName = $_POST["first-name"];
$secondName = $_POST["second-name"];
$address = $_POST["address"];
if ($_POST["Order-type"]) {
  $typeofDelivery = $_POST["Order-type"];
}else{
  $typeofDelivery = "Not Choosen";
}
$paymentType = $_POST["payment-type"];
$country = $_POST["country"];
$city = $_POST["city"];
$postal_code = $_POST["postal-code"];

// $countryCodes = array(
//   "Kenya" => "KE",
//   "Tanzania" => "TZ",
//   "Uganda" => "UG",
//   "Ethiopia" => "ET"
// );

// if (isset($countryCodes[$country])) {
//   $countryCodes = $countryCodes[$country];
// }


//GETTING ACCESS TO THE PAYMENT API URL
$apiUrl = "https://api-m.sandbox.paypal.com/v2/checkout/orders";
$access_token = $access_token;


//PAYMENT HEADERS DEFINING THE CONTENT TYPE, REQUEST ID AND AUTHORIZATION WHICH IS ACCEPTED THROUGH THE ACCESS TOKEN
$payment_headers = array(
    "Content-Type: application/json",
    "PayPal-Request-Id: 7b92603e-77ed-4896-8e78-5dea2050476a",
    "Authorization: Bearer " . $access_token
);

//THIS IS THE DATA IN THE BODY, WHICH I HAVE WRITTEN IN ARRAY FORMAT FIRST. THE INTEND IS TO CAPTURE PAYMENT

$data = array(
    "intent" => "CAPTURE",
    "purchase_units" => array(
      array(
        "reference_id" => "d9f80740-38f0-11e8-b467-0ed5f89f718b",
        "shipping" => array( //SHIPPING ARRAY MUST BE PROVIDED OR ELSE **ERRORS
                "address" => array(
                    "line1" => "$address",
                    "city" => "$city",
                    "admin_area_2" => "$city", 
                    "country_code" => "KE",
                    "postal_code" => "$postal_code"
            )),
        "amount" => array(
          "currency_code" => "USD",
          "value" => "$formatedTotal"
        )
      )
    ),
    "payment_source" => array(
      "paypal" => array(
        "name" => array(
          "given_name" => "$firstName",
          "surname" => "$secondName",
        ),
        "experience_context" => array(
          "payment_method_preference" => "IMMEDIATE_PAYMENT_REQUIRED",
          "brand_name" => "EXAMPLE INC",
          "locale" => "en-US",
          "landing_page" => "LOGIN",
          "shipping_preference" => "SET_PROVIDED_ADDRESS",
          "user_action" => "PAY_NOW",
          "return_url" => "http://localhost:8080/mysite/ec-website/checkout.php",
          "cancel_url" => "http://localhost:8080/mysite/ec-website/checkout.php"
        )
      )
    )
  );


  //CONVERTING THE DATA VARIABLE INTO JSON FORMAT

  $json_data = json_encode($data);



  //FETCHING API

  //INITIATING CURL 
  $curl = curl_init();

  //CURL SETOPT

  curl_setopt($curl, CURLOPT_URL, $apiUrl); //GETS URL
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); //When set to true, it tells cURL to return the response body from the HTTP request as a string instead of outputting it directly.
  curl_setopt($curl, CURLOPT_POST, true); //used to specify that the request should be sent using the HTTP POST method.
  curl_setopt($curl, CURLOPT_POSTFIELDS, $json_data); //Sends the data in the body of the request
  curl_setopt($curl, CURLOPT_HTTPHEADER, $payment_headers); //to specify an array of custom HTTP headers to include in the request.


  //executing the curl request and getting the response

  $response = curl_exec($curl);


  //shows if an error occurs
  if(curl_error($ch)){
    echo 'Curl error: ' . curl_error($ch);
    }

  //make sure to close curl to AVOID errors
  curl_close($curl);



  //response in json format
  // echo $response . '<br><br>';

  //response decoded - Not a JSON Format anymore, rather, it's an object. It can also be converted into an array
  $decode = json_decode($response);

  // var_dump($decode); '<br><br>';

  //Getting the links for user action from the decoded code
  $links = $decode->links;

  //accessing each link indiidually
  foreach ($links as $link) {
    $href = $link->href;
    $rel = $link->rel;
    $method = $link->method;
  }

    //getting buyer's name

  $names = $decode->payment_source->paypal->name;

  foreach ($names as $name) {
    $first_name = $names->given_name;
    $surname = $names->surname;
  }

  $status = $decode->status;

  if ($status !== "PAYER_ACTION_REQUIRED") {
    echo "Payment Failed, Please try again";
    $orderStatus = "Unsuccesful";
  }else{
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
                $message .= "Name: " . $item["name"] . "<br>Price: KSH " . $item["price"] . "<br><br>" . "\n";
            }
        }else{
            foreach ($dec as $item){
                $message .= "Name: " . $item->name . "<br>Price: KSH " . $item->price . "<br><br>" . "\n";
            }
        }
        if (mail("meshacklocho5@gmail.com", "ORDERED ITEMS", $message, $headers)) {
          echo "<div class='checkout-status'>
                  <h3>Thank you $first_name, Your Order has been Sent Successfully!!</h3>
                  <a href='$href' target='_blank'>Proceed to Paypal</a>
                </div>";
        }else{
          echo "<div class='checkout-status'>
                  <h3>Order Not Sent Please Try Again. If the Problem Persists, Call us now at: <a href='tel:+25472345678'>+25472345678</a></h3>
                  <a href='$href'>Proceed to Paypal</a>
                </div>";
        }
        $orderStatus = "Successful";
        // var_dump($dec). "<br><br>";

        $allItems = get_object_vars($dec);
        $numberofItems = count($allItems);

        // echo "NO: ". $numberofItems;

        if (isset($_SESSION["id"])) {
          $stmt = $conn2->prepare("INSERT INTO user_orders (user_id, delivery_type, total, status, payment_method, no_of_items) VALUES (?,?,?,?,?,?)");
          $stmt->bind_param('isssss', $user_id, $typeofDelivery, $total, $orderStatus, $paymentType, $numberofItems);
          $stmt->execute();
        }

  }



  

  
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Paypal Order Status</title>
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