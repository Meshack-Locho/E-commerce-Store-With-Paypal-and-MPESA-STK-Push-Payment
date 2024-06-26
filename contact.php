<?php

session_start();
include "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $to = "meshacklocho5@gmail.com";
    $name = htmlspecialchars($_POST["name"], ENT_QUOTES, 'UTF-8');
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars($_POST["subject"], ENT_QUOTES, 'UTF-8');
    $text = htmlspecialchars($_POST["message"], ENT_QUOTES, 'UTF-8');

    $headers = "From: $email \r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

    if (mail($to, $subject, $text, $headers)) {
        echo "<div class='confirmation'>
                <h4>Your message has been sent</h4>
                <i class='fa-solid fa-circle-check'></i>
              </div>";
    }else{
        echo "<h3 class='errors'>Message not sent please try again!!</h3>";
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact us</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="css/forms.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Josefin Sans">
          <style>
            #user-name{
            color: white;
            }
            .header-text-big-search div{
                padding-top: 50px;
            }
            .wrapper{
                padding: 0px;
                height: auto;
            }
            .confirmation{
                position: fixed;
                bottom: 20%;
                right: 2%;
                width: 200px;
                padding: 20px 10px;
                border-radius: 10px;
                background-color: rgb(162, 163, 251);
                z-index: 3;
                display: flex;
                flex-direction: column;
                gap: 10px;
                align-items: center;
                justify-content: center;
                text-align: center;
            }
            .fa-circle-check{
                color:green;
                font-size: 20px;
            }
            form{
                margin-bottom: 10px;
            }
          </style>
</head>
<body>
<div class="search-header">
    <div class="navigation">
            <a href="index.php" class="logo">
                <img src="images/hero/hero-4.png" alt="">
                <h2>Mellow Watches</h2>
            </a>

            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <?php
                    
                        if (isset($_SESSION["id"])) { ?>
                            <li id="user-name"><?= $_SESSION["fname"]?> <i class="fa-solid fa-angle-down"></i>
                            
                            <div class="user-options">
                                <a href="user/dashboard.php">Dashboard</a>
                                <a href="logout.php">Logout</a>
                            </div>
                            </li>
                       <?php }else{ ?>
                            <li><a href="login.php" id="login-link">Login</a></li>
                            <li><a href="signup.php" id="signup-link">Sign Up</a></li>
                       <?php }
                    
                    ?>
                </ul>
            </nav>

            <a href="cart.php" class="cart-toggle cart-icon">
                <i class="fa-solid fa-cart-shopping"></i>
                <span id="items-count">0</span>
            </a>

            <i class="fa-solid fa-bars menu-toggle"></i>
        </div>

        <div class="mobile-menu">
            <i class="fa-solid fa-xmark menu-toggle"></i>
        <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    
                    <?php
                    
                        if (isset($_SESSION["id"])) { ?>
                            <li id="user-name">
                                <a href="user/dashboard.php"><?= $_SESSION["fname"]?></a>
                                <div class="mob-options">
                                    <a href="user/dashboard.php">Dashboard</a>
                                    <a href="logout.php">Logout</a>
                                </div>
                            </li>
                            
                       <?php }else{ ?>
                            <li><a href="login.php" id="login-link">Login</a></li>
                            <li><a href="signup.php" id="signup-link">Sign Up</a></li>
                       <?php }
                    
                    ?>
                </ul>
            </nav>

        </div>

        <div class="header-text-big-search" style="justify-content: space-evenly;">
            <h1 style="text-align: center;">Mellow</h1>
            <div>
                <h2>Contact</h2>
            </div>
        </div>

    </div>

    <main>

        <div class="wrapper">
        <h1>Contact Mellow Watches</h1>

        <form action="" method="post">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" required placeholder="John Doe" value="<?php if(isset($_SESSION["id"])){echo $_SESSION["fname"] . " " .$_SESSION['sname'];}else{echo "";}?>">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required placeholder="Enter your email, eg; johndoe@example.com" value="<?php if(isset($_SESSION["id"])){echo $_SESSION["email"];}else{echo "";}?>">
            <label for="subject">Subject</label>
            <input type="text" name="subject" id="subject" required placeholder="Enter message subject">
            <label for="message">Message</label>
            <textarea name="message" id="message" required placeholder="type your message"></textarea>

            <input type="submit" value="Send" name="submit">
        </form>
    </div>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="js/index.js"></script>
</body>
</html>