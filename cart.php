<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}


if (isset($_GET['name'])) {
    echo $_SESSION["cart"][$_GET['name']];
}


$cartCount = count($_SESSION["cart"]);
$total = $_SESSION["total"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Josefin Sans">
</head>
<body>
<div class="search-header">
    <div class="navigation">
            <a href="" class="logo">
                <img src="images/hero/hero-4.png" alt="">
                <h2>Mellow Watches</h2>
            </a>

            <nav>
                <ul>
                    <li><a href="">Home</a></li>
                    <li><a href="">Watches</a></li>
                    <li><a href="">Contact</a></li>
                    <li><a href="" id="login-link">Login</a></li>
                    <li><a href="" id="signup-link">Sign Up</a></li>
                </ul>
            </nav>

            <a href="cart.php" class="cart-toggle cart-icon">
                <i class="fa-solid fa-cart-shopping"></i>
                <span id="items-count">0</span>
            </a>
        </div>

        <div class="header-text-big-search" style="justify-content: space-evenly;">
            <h1 style="text-align: center;">Mellow</h1>
            <div>
                <span>Wrist</span>
                <span>Watches</span>
            </div>
        </div>


        <div class="search-panel">
            <h3>Search for watches</h3>
            <form action="search.php" method="get">
                <input type="search" name="search" id="search">
                <input type="submit" value="Search">
            </form>
        </div>
    </div>


    <div class="cart-page">

    <h4>Total: <?php echo $total?></h4>

    <a href="checkout.php" id="checkout-link">Go To Checkout</a>

        <div class="cart-page-items">
        <?php
        
        
        function remove_from_cart($item_id) {
            foreach ($_SESSION['cart'] as $key => $item) {
                if ($item['id'] === $item_id) {
                    unset($_SESSION['cart'][$key]);
                    break;
                }
            }
        }
        
        if (isset($_POST['remove_from_cart'])) {
            $item_id = $_POST['remove_item_id'];
            remove_from_cart($item_id);
        }
        
        if (!empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                $price = $item["price"];
                echo "<div class='cart-items-cont'>
                <a href='' class='cart-items'>
                        <img src='{$item['image']}' class='cart-images'>
                        <h4>Item: {$item['name']}</h4> 
                        <h5>Price: KSH " . number_format((int)$price) . "</h5>
                </a>
                <form method='post' action=''>
                      <input type='hidden' name='remove_item_id' value='{$item['id']}'>
                      <input type='submit' name='remove_from_cart' value='Remove'>
                </form><br>
                </div>";
            }
            
        }else{
            echo "<h2>No Items in the Cart</h2>";
        }
        
        ?>
        </div>
    </div>

    <script src="js/index.js"></script>
</body>
</html>