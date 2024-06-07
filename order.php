<?php

session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
    
}

$total = $_SESSION["total"];
$cartItems = $_SESSION["cart"];

if(isset($_POST["submit"])){

    $user_phone = $_POST["phone"];
    $email = $_POST["email"];
    $firstName = $_POST["first-name"];
    $secondName = $_POST["second-name"];
    $address = $_POST["address"];
    $location = $_POST['location'];
    $typeofDelivery = $_POST["Order-type"];
    $paymentType = $_POST["payment-type"];
    
      $headers = "From: meshacklocho@meshacklocho.co.ke\r\n";
      $headers .= "MIME-Version: 1.0\r\n";
      $headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
      
      $message = "
      New Order: <br><br>
      Name: $firstName $secondName <br>
      Email: $email <br>
      Type of Delivery: $typeofDelivery <br>
      Payment Method:  $paymentType <br>
      Address: $address <br>
      Phone Number: $user_phone <br><br>
      Total Amount: KSH <b>$total</b> <br><br>
      Cart items: <br><br> \n";
      foreach ($cartItems as $item){
          $message .= "Name: " . $item["name"] . "<br>Price: KSH" . $item["price"] . "<br><br>" . "\n";
      }
      

      if (mail("meshacklocho5@gmail.com", "NEW ORDERED ITEMS", $message, $headers)) {
         echo "Order Sent successfully. A confirmation email has been sent to $email";
      }else{
        echo "Order not sent. Please try again";
      }
}


?>