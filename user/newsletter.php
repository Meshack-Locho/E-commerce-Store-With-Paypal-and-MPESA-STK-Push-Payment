<?php


session_start();
include "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_SESSION["id"];
    $email = $_SESSION["email"];
    $subscription_type = $_POST["subscription_type"];

    $stmt = $conn2->prepare("INSERT INTO subscriptions (subscription_type, email, user_id) VALUES (?,?,?)");
    $stmt->bind_param("ssi", $subscription_type, $email, $user_id);
    if ($stmt->execute()) {
        echo "<div class='subscription-response'>
                <h4>Your have successfully subscribed to our $subscription_type Subscription.</h4>
                <button onclick='history.back()'>Back</button>
              </div>";
    }else{
        echo "<div class='subscription-response'>
                <h4>An error occurred processing the request, please try again.</h4>
                <button onclick='history.back()'>Back</button>
              </div>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Subscription Status</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Josefin Sans">
    <style>
        body{
            width: 100%;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            font-family: Josefin sans;
        }
        .subscription-response{
            width: fit-content;
            height: auto;
            display: flex;
            flex-direction: column;
            gap: 20px;
            align-items: center;
            justify-content: center;
            background-color: rgb(165, 167, 253);
            border-radius: 20px;
            padding: 50px 10px;
            margin-top: 50px;
        }
        .subscription-response button{
            width: 200px;
            padding: 15px;
            cursor: pointer;
            border: 1px solid black;
            border-radius: 5px;
            background-color: transparent;
            color: black;
        }
    </style>
</head>
<body>
    
</body>
</html>