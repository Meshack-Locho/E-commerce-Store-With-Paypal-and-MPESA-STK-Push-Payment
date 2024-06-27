<?php

session_start();
include "db.php";

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $token = md5(uniqid(rand(), true));

    $stmt = $conn2->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row["first_name"];
        $stmt=$conn2->prepare("INSERT INTO reset (email, token) VALUES (?,?)");
        $stmt->bind_param("si", $email, $token);
        if ($stmt->execute()) {
            $reset_link = "http://localhost:8080/mysite/ec-website/reset.php?token=$token";

            $to = $email;
            $subject = "PASSWORD RESET REQUEST";
            $headers = "From: meshacklocho5@gmail.com\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
            $message = "
                <html>
                <head></head>
                <body style='height: auto;padding:20px 0;'>
                    <h2>Hey there $name, here's your Password Reset Link, stay safe.</h2>
                    <p style='margin: 20px 0;'>Please click the link Below to reset your password</p>
                    <a href='$reset_link' style='padding:15px 40px;background-color: black;color:white;text-decoration:none;margin: top 15px;'>Reset Password</a>
                </body>
                </html>
            ";
            if (mail($to, $subject, $message, $headers)) {
                echo "<div class='confirmation'>
                        <h3>An email with the password reset link has been sent to $email. If you don't see it, check your span/junk folder.</h3>   
                     </div>";
            }else{
                echo "<div class='errors'>
                        <h3>There was a problem sending the reset email, please try again!!</h3>
                      </div>";
            }
        }
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Password Reset</title>
    <link rel="stylesheet" href="css/forms.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Josefin Sans">
</head>
<body>
    
    <div class="wrapper">   
        <h3>So you've forgot your password huh? <br> Don't Sweat, Enter your email below</h3>

        <form method="post">
            <label for="email">Your Email</label>
            <input type="email" name="email" id="email" required placeholder="Enter your email">
            <input type="submit" value="Send Code" name="submit">
        </form>

        <div class="decorator">
            <img src="images/hero/deco-img.jpg" alt="">
            <h3>Mellow Watches</h3>
        </div>
    </div>
    
</body>
</html>