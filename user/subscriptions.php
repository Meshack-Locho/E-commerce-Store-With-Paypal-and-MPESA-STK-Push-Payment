<?php

session_start();
include "db.php";

if (!isset($_SESSION["id"])) {
    header("Location: http://localhost:8080/mysite/ec-website/login.php");
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Subscriptions</title>
    <link rel="stylesheet" href="http://localhost:8080/mysite/ec-website/css/users.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Josefin Sans">
</head>
<body>
<header>
    <div class="navigation">
            <a href="http://localhost:8080/mysite/ec-website/index.php" class="logo">
                <img src="http://localhost:8080/mysite/ec-website/images/hero/hero-4.png" alt="">
                <h2>Mellow Watches</h2>
            </a>
            <div class="search-panel">
                <form action="http://localhost:8080/mysite/ec-website/search.php" method="get">
                    <input type="search" name="search" id="search" placeholder="Search for watches">
                    <input type="submit" value="Search">
                </form>
            </div>

            <nav>
                <ul>
                    <li id="user-name">Hello <?= $_SESSION["fname"]?> <i class="fa-solid fa-angle-down"></i>
                            
                    <div class="user-options">
                        <a href="http://localhost:8080/mysite/ec-website/index.php">Home</a>
                        <a href="http://localhost:8080/mysite/ec-website/checkout.php">Checkout</a>
                        <a href="http://localhost:8080/mysite/ec-website/logout.php">Logout</a>
                    </div>
                    </li>
                </ul>
            </nav>

            <a href="http://localhost:8080/mysite/ec-website/cart.php" class="cart-toggle cart-icon">
                <i class="fa-solid fa-cart-shopping"></i>
                <span id="items-count">0</span>
            </a>
        </div>
    </header>

    <main>
        <section class="acc-info">
            <div class="options">
                <a href="dashboard.php"><i class="fa-solid fa-user"></i> My Account</a>
                <a href="orders.php"><i class="fa-solid fa-bag-shopping"></i> Orders</a>
                <a href="inbox.php">
                    <i class="fa-solid fa-envelope"></i> Inbox
                    <span id="notification-dot" class="notification-dot hide"></span>
                </a>
                <a href="recents.php"><i class="fa-solid fa-clock-rotate-left"></i> Recently Viewed</a>
                <a href="subscriptions.php" class="selected-page"><i class="fa-solid fa-newspaper"></i> Subscriptions</a>
                <a href="http://localhost:8080/mysite/ec-website/logout.php" id="logout-link"><i class="fa-solid fa-person-through-window"></i> Logout</a>
            </div>

            <div class="subscriptions">
                <h3>Subscriptions</h3>
                <div class="subscribed">
                    <div class="no-subscriptions">
                        <i class="fa-solid fa-newspaper"></i> 
                        <h4>You have no subscriptions at the moment</h4>
                        <p>All your subscriptions will appear here. You can unsubscribe at any moment</p>
                        <form action="newsletter.php" method="post">
                            <input type="email" name="email" id="email" value="<?= $_SESSION["email"]?> " required>
                            <input type="submit" value="Subscribe">
                        </form>
                        <a href="http://localhost:8080/mysite/ec-website/index.php">More Subscriptions</a>
                    </div>
                </div>
            </div>
        </section>

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