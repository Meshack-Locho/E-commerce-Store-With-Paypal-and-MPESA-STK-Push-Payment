<?php

session_start();
include "db.php";

if (!isset($_SESSION["id"])) {
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    header("Location: http://localhost:8080/mysite/ec-website/login.php");
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>
    <link rel="stylesheet" href="http://localhost:8080/mysite/ec-website/css/users.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Josefin Sans">
</head>
<body>

    <header>

<!--Navigation-->


    <div class="navigation">
            <i class="fa-solid fa-bars submenu-toggle"></i>
            <a href="" class="logo">
                <img src="http://localhost:8080/mysite/ec-website/images/hero/hero-4.png" alt="">
                <h2>Mellow Watches</h2>
            </a>
            <!--SEARCH-->

            <div class="search-panel">
                <form action="http://localhost:8080/mysite/ec-website/search.php" method="get">
                    <input type="search" name="search" id="search" placeholder="Search for watches">
                    <input type="submit" value="Search">
                </form>
            </div>

            <nav>
                <ul>
                    <!--DISPLAYING USER NAME-->


                    <li id="user-name">Hello <?= $_SESSION["fname"]?> <i class="fa-solid fa-angle-down"></i>
                            
                    <div class="user-options">
                        <a href="http://localhost:8080/mysite/ec-website/index.php">Home</a>
                        <a href="http://localhost:8080/mysite/ec-website/checkout.php">Checkout</a>
                        <a href="http://localhost:8080/mysite/ec-website/logout.php">Logout</a>
                    </div>
                    </li>
                </ul>
            </nav>

            <!--CART ICON DISPLAYING NUMBER OF ITEMS IN THE CART-->
            <a href="http://localhost:8080/mysite/ec-website/cart.php" class="cart-toggle cart-icon">
                <i class="fa-solid fa-cart-shopping"></i>
                <span id="items-count" class="items-count">0</span>
            </a>

            <i class="fa-solid fa-user menu-toggle"></i>
        </div>

        <!--NAVIGATION FOR MOBILE-->


        <div class="mobile-menu">
            <i class="fa-solid fa-xmark menu-toggle"></i>    
            <nav>
            
                <ul>
                        <li><a href="http://localhost:8080/mysite/ec-website/index.php">Home</a></li>
                        <li><a href="http://localhost:8080/mysite/ec-website/checkout.php">Checkout</a></li>
                        <li><a href="http://localhost:8080/mysite/ec-website/logout.php">Logout</a></li>
                        <li>
                            <a href="http://localhost:8080/mysite/ec-website/cart.php" class="cart-toggle cart-icon">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <span id="items-count" class="items-count">0</span>
                            </a>
                        </li>
                </ul>
            </nav>

            <div class="search-panel">
                <form action="http://localhost:8080/mysite/ec-website/search.php" method="get">
                    <input type="search" name="search" id="search" placeholder="Search for watches">
                    <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>

        </div>
    </header>

    <main>

    <!--ACCOUNT INFO-->
        <section class="acc-info">

        <!--USER OPTIONS AND LINKS TO OTHER PAGES-->
            <div class="options">
                <!--SUB MENU TOGGLE ON SMALL SCREEN-->

                <span class="submenu-toggle submenu-close"><i class="fa-solid fa-arrow-left"></i></span>

                <!--SUBMENU-->

                <a href="dashboard.php" class="selected-page"><i class="fa-solid fa-user"></i> My Account</a>
                <a href="orders.php"><i class="fa-solid fa-bag-shopping"></i> Orders</a>
                <a href="inbox.php">
                    <i class="fa-solid fa-envelope"></i> Inbox
                    <span id="notification-dot" class="notification-dot hide"></span>
                </a>
                <a href="recents.php"><i class="fa-solid fa-clock-rotate-left"></i> Recently Viewed</a>
                <a href="subscriptions.php"><i class="fa-solid fa-newspaper"></i> Subscriptions</a>
                <a href="http://localhost:8080/mysite/ec-website/logout.php" id="logout-link"><i class="fa-solid fa-person-through-window"></i> Logout</a>
            </div>

            <!--USER DETAILS FROM DB-->
            <div class="details">
                <h2>Account Overview</h2>
                <div class="acc-details">
                    <h3>Account Details</h3>
                    <div class="main-details">
                        <h4>Name: <?= $_SESSION['fname'] . " " . $_SESSION["sname"] ?></h4>
                        <h4>Email: <?= $_SESSION["email"]?></h4>
                    </div>
                </div>
                <div class="shipping-details">
                        <h3>Default Shipping Details</h3>
                        <div class="loc">
                        <h4>Name: <?= $_SESSION['fname'] . " " . $_SESSION["sname"] ?></h4>
                        <h4>County: <?= $_SESSION["county"]?></h4>
                        <h4>Address: <?= $_SESSION["address"]?></h4>
                        <h4>Phone Number: +<?= $_SESSION["phone"]?></h4>
                        </div>
                </div>
            </div>
        </section>

        <!--RECOMMENDATION, JUST RANDOM FOR THE MOMENT. FROM DB-->

        <section class="recommendations">
            <h3>Recommended for you</h3>
            <div class="container">
                <?php
                
                $stmt=$conn->prepare("SELECT * FROM all_products ORDER BY id DESC LIMIT 5");
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();

                if ($result->num_rows > 0) {
                    while ($row=$result->fetch_assoc()) {
                        echo '<div class="items">
                        <a href="http://localhost:8080/mysite/ec-website/product.php?id='.$row["id"].'">
                            <img src="http://localhost:8080/mysite/ec-website/'.$row["image"] . '" alt="" class="item-images">
                            <h3>'. $row["name"] . '</h3>
                            <h4>Price: KSH ' . $row["price"] . '</h4>
                        </a>
                      </div>';
                    }
                }else{
                    echo "<h3>No Recommendations Available</h3>";
                }
                
                ?>
            </div>
        </section>
    </main>

    <footer>
        <h3>Mellow Wrist Watches &copy; Copyright 2024</h3>
        <h5>Created by, Meshack Locho</h5>
    </footer>
    <script src="http://localhost:8080/mysite/ec-website/js/user.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>