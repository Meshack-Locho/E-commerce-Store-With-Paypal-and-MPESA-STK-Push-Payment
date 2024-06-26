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
    <title>My Subscriptions</title>
    <link rel="stylesheet" href="http://localhost:8080/mysite/ec-website/css/users.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Josefin Sans">
</head>
<body>
<header>
    <div class="navigation">
            <i class="fa-solid fa-bars submenu-toggle"></i>
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
                <span id="items-count" class="items-count">0</span>
            </a>

            <i class="fa-solid fa-user menu-toggle"></i>
        </div>


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
        <section class="acc-info">
            <div class="options">
                <span class="submenu-toggle submenu-close"><i class="fa-solid fa-arrow-left"></i></span>
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
                <h3><span>Subscriptions</span></h3>
                <div class="subscribed">
                    <?php
                    $user_id = $_SESSION["id"];
                    $stmt = $conn2->prepare("SELECT * FROM subscriptions WHERE user_id=? ORDER BY time DESC");
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $results = $stmt->get_result();

                    if ($results->num_rows>0) {
                        while ($row=$results->fetch_assoc()) {
                            $time = new DateTime($row["time"]);
                            $formattedTime =  $time->format('d / Y H:i A');
                            $time = DateTime::createFromFormat('d / Y H:i A', $formattedTime);
                            echo "<div class='subscription'>
                                    <h3>Subscription</h3>
                                    <div>
                                        <h4>".htmlspecialchars($row["subscription_type"])."</h4>
                                        <a href='https://gmail.com' target='_blank' style='color: rgb(109, 112, 255);'>Open email</a>
                                        <h5>".htmlspecialchars($time->format("F") . ", " . $formattedTime)."</h5>
                                        <a href='unsubscribe.php?id=".$row["id"]."' id='unsubscribe'>Unsubscribe <i class='fa-solid fa-trash'></i></a>
                                    </div>
                                  </div>";
                        }
                    }else{?>
                        <div class="no-subscriptions">
                            <i class="fa-solid fa-newspaper"></i> 
                            <h4>You have no subscriptions at the moment</h4>
                            <p>All your subscriptions will appear here. You can unsubscribe at any moment</p>
                            <form action="newsletter.php" method="post">
                                <input type="email" name="email" id="email" value="<?= $_SESSION["email"]?> " required>
                                <input type="hidden" name="subscription_type" value="Newsletter Subscription ">
                                <input type="submit" value="Subscribe">
                            </form>
                            <a href="http://localhost:8080/mysite/ec-website/index.php">More Subscriptions</a>
                    </div>
                    <?php }

                    ?>
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