<?php

session_start();

include("db.php");
$search = $_GET["search"];


if (isset($_POST["add_to_cart"])) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
    
    // Check if cart array exists in session, if not, create it
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
    
    // Function to add item to cart
    function add_to_cart($item_id, $item_image, $item_name, $item_price) {
        $_SESSION['cart'][] = array(
            'id' => $item_id,
            'image' => $item_image,
            'name' => $item_name,
            'price' => $item_price
        );
    }
    
    
    // Check if item is added to cart
    if (isset($_POST['add_to_cart'])) {
        $item_id = $_POST['item_id'];
        $item_name = $_POST['item_name'];
        $item_price = $_POST['item_price'];
        $item_image = $_POST['item_image'];
        add_to_cart($item_id, $item_image, $item_name, $item_price);
    }
    
    $cartCount = count($_SESSION["cart"]);
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results for <?php echo  "'$search'"?></title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Josefin Sans">
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
                    <li><a href="index.php">Watches</a></li>
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
                    <li><a href="contact.php">Contact</a></li>
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
                <span>Wrist</span>
                <span>Watches</span>
            </div>
        </div>

    </div>

    <div class="search-panel">
            <h3>Search for watches</h3>
            <form action="search.php" method="get">
                <input type="search" name="search" id="search">
                <input type="submit" value="Search">
            </form>
        </div>

    <div class="search-results-wrapper" style="flex-direction: column;">
    <h2 style="text-align: center;">Search Results for <?php echo "'$search'"?></h2>
        <?php
            if ($_SERVER["REQUEST_METHOD"] === "GET") {
                $stmt = $conn->prepare("SELECT * FROM all_products WHERE name LIKE ?");
                $searchTerm = '%' . $search . '%';
                $stmt->bind_param("s", $searchTerm);
                $stmt->execute();
                $result = $stmt->get_result();

                ?>
            
                <div class="search-res"> 
                    <?php
                if ($result->num_rows > 0) {
            
                    while ($row=$result->fetch_assoc()) {
                        
                                echo '<div class="search-items">
                                <a href="product.php?id='.$row["id"].'" class="item-links">
                                    <img src="'. $row["image"] . '" alt="" class="item-images">
                                    <div>
                                        <h3>'. $row["name"] . '</h3>
                                        <h4>Price: KSH ' . $row["price"] . '</h4>
                                    </div>
                                </a>
                                </div>';

                        }
                            
                          
                }else{
                    echo "<h2>No results found</h2>";
                } ?>
                </div>
                <?php
            }

        ?>
    </div>

    <div class="cart"></div>

    <footer>
        <h3>Mellow Wrist Watches &copy; Copyright 2024</h3>
        <h5>Created by, Meshack Locho</h5>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="js/index.js"></script>
</body>
</html>