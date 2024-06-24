<?php

session_start();
include "db.php";



if (isset($_POST["submit"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $conn2->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows>0) {
        $user_data = $result->fetch_assoc();

        if (password_verify($password, $user_data["password"])) {
            $_SESSION["fname"] = $user_data["first_name"];
            $_SESSION["sname"] = $user_data["second_name"];
            $_SESSION["email"] = $user_data["email"];
            $_SESSION["id"] = $user_data["id"];
            $_SESSION["phone"] = $user_data["phone"];
            $_SESSION["county"] = $user_data["city"];
            $_SESSION["address"] = $user_data["address"];
            if (isset($_SESSION['redirect_to'])) {
                    $redirect_to = $_SESSION['redirect_to'];
                    unset($_SESSION['redirect_to']);
                    header("Location: $redirect_to");
                    exit();
            }else{
                header("Location: index.php");
                exit();
            }
        }else{
            echo "<h4 class='errors'>Password is Inorrect</h4>";
        }
    }else{
        echo "<h4 class='errors'>No user found</h4>";
    }
}

// echo $prevUrl;
// 

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Mellow Watches</title>
    <link rel="stylesheet" href="css/forms.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Josefin Sans">
</head>
<body>
    <div class="wrapper">
        <h1>Login to Mellow Watches</h1>

        <form action="" method="post">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required placeholder="Enter your email, eg; johndoe@example.com">

            <label for="password">Password</label>
            <input type="password" name="password" id="password" required placeholder="Enter a Secure Password">

            <input type="submit" value="Login" name="submit">
        </form>

        <p>You don't have account? <a href="signup.php">Register</a> an account.</p>

        <div class="decorator">
            <img src="images/hero/deco-img.jpg" alt="">
            <h3>Mellow Watches</h3>
        </div>
    </div>
</body>
</html>