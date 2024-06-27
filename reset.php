<?php

session_start();
include "db.php";


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $token = $_GET["token"];
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);

    $stmt = $conn2->prepare("SELECT email FROM reset WHERE token=?");
    $stmt->bind_param("i", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_email = $row["email"];

        $stmt = $conn2->prepare("UPDATE users SET password=? WHERE email=?");
        $stmt->bind_param("ss", $password, $user_email);
        if ($stmt->execute()) {
            echo "<div class='confirmation'>
                    <h3>Your Password has been Reset Successfully!!</h3>
                    <a href='login.php'>To Login</a>
                  </div>";
        }else{
            echo "<div class='errros'>
                    <h3>Password Reset Failed, please try again</h3>
                  </div>";
        }


    }else{
        echo "<div class='errors'>
                <h3>Invalid Token or Email</h3>;
              </div>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Code</title>
    <link rel="stylesheet" href="css/forms.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Josefin Sans">
</head>
<body>
<div class="wrapper">   
        <h3>Last Step!!</h3>

        <form method="post">
            <label for="email">Enter new password</label>
            <input type="password" name="password" id="password" required placeholder="Enter new password">
            <input type="submit" value="Reset Password" name="submit">
        </form>

        <div class="decorator">
            <img src="images/hero/deco-img.jpg" alt="">
            <h3>Mellow Watches</h3>
        </div>
    </div>
</body>
</html>