<?php

session_start();
include "db.php";


if (isset($_POST["submit"])) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
    $firstName = $_POST["first-name"];
    $secondName = $_POST["second-name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $city = $_POST["city"];
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
    $cart = json_encode($_SESSION["cart"]);

    $stmt = $conn2->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows>0) {
        echo "<h3 class='errors'>Email is Already in use</h3>";
    }else{
        $stmt = $conn2->prepare("INSERT INTO users (first_name, second_name, email, address, city, password, phone, cart) VALUES (?,?,?,?,?,?,?,?)");
        $stmt->bind_param("ssssssss", $firstName, $secondName, $email, $address, $city, $password, $phone, $cart);
        $stmt->execute();

        header("Location: login.php");
        exit();
    }
    
    $stmt->close();
    $conn2->close();
}

// echo $prevUrl;
// if (isset($_SESSION['redirect_to'])) {
//     $redirect_to = $_SESSION['redirect_to'];
//     unset($_SESSION['redirect_to']);
//     header("Location: $redirect_to");
//     exit();
// }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up - Mellow Watches</title>
    <link rel="stylesheet" href="css/forms.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Josefin Sans">
</head>
<body>
    <div class="wrapper">
        <div class="scrollable">
        <h1>Sign up to Mellow Watches</h1>
        <form action="" method="post">
            <label for="first-name">First Name</label>
            <input type="text" name="first-name" id="first-name" required placeholder="Enter your first name">
            <label for="second-name">Second Name</label>
            <input type="text" name="second-name" id="second-name" required placeholder="Enter your Second name">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required placeholder="Enter your email, eg; johndoe@example.com">
            <label for="phone">Phone Number</label>
            <input type="tel" name="phone" id="phone" required placeholder="Enter your Phone Number">
            <label for="city">County</label>
            <input type="text" name="city" id="city" placeholder="Enter Name of Your City" required>
            <label for="address">Address</label>
            <input type="text" name="address" id="address" placeholder="Enter you Address" required>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required placeholder="Enter a Secure Password">
            <input type="submit" value="Sign up" name="submit">
        </form>

        <p>Are you already registered? <a href="login.php">Login</a> to your account.</p>
        </div>

        <div class="decorator">
            <img src="images/hero/deco-img.jpg" alt="">
            <h3>Mellow Watches</h3>
        </div>

        

    </div>
</body>
</html>