<?php
session_start();
include 'db.php';
$_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];

if (!isset($_SESSION["id"])) {
    if (isset($_GET['name'])) {
        echo $_SESSION["cart"][$_GET['name']];
    }
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
        $_SESSION['total'] = 0;
    }
    
    $cartCount = count($_SESSION["cart"]);

    if (isset($_SESSION['total'])) {
        $total = $_SESSION["total"];
    }
}else{
    $user_id = $_SESSION["id"];
        $stmt = $conn2->prepare("SELECT cart FROM users WHERE id=?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        $dec = json_decode($row['cart']);
      
        
        $total = 0;

        foreach ($dec as $value) {
            $total += $value->price;
        }
        

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />

    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Josefin Sans">
          <style>
            #user-name{
            color: white;
            }
          </style>
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
                    <li><a href="index.php">Home</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <?php
                    
                        if (isset($_SESSION["id"])) { ?>
                            <li id="user-name"><?= $_SESSION["fname"]?> <i class="fa-solid fa-angle-down"></i>
                            
                            <div class="user-options">
                                <a href="dashboard.php">Dashboard</a>
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
                <span>Wrist</span>
                <span>Watches</span>
            </div>
        </div>

    </div>

    
<main>
    
<div class="search-panel">
            <h3>Search for watches</h3>
            <form action="search.php" method="get">
                <input type="search" name="search" id="search">
                <input type="submit" value="Search">
            </form>
        </div>


    <div class="cart-page">

    <a href="checkout.php" id="checkout-link">Go To Checkout</a>

    

        <div class="cart-page-items">
        <?php
        
        
        if (!isset($_SESSION["id"])) {
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = array();
            }
            function remove_from_cart($item_id) {
                foreach ($_SESSION['cart'] as $key => $item) {
                    if ($item['id'] === $item_id) {
                        $_SESSION["total"] -= $item["price"];
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
                    <form method='post' action='". htmlspecialchars($_SERVER['PHP_SELF']) ."'>
                          <input type='hidden' name='remove_item_id' value='{$item['id']}'>
                          <input type='submit' name='remove_from_cart' value='Remove' onsubmit='preventRel()'>
                    </form><br>
                    </div>";
                }
            }else{
                echo "<h2>No Items in the Cart</h2>";
            }
        }else{
            $user_id = $_SESSION["id"];

            $stmt = $conn2->prepare("SELECT cart FROM users WHERE id =?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $res = $stmt->get_result();
            $row=$res->fetch_assoc();
            $cart = json_decode($row['cart']);

            if (!empty($cart)) {
                foreach ($cart as $items) {
                    // echo "ID: " . $items->id . ", ";
                    // echo "Image: " . $items->image . ", ";
                    // echo "Name: " . $items->name . ", ";
                    // echo "Price: " . $items->price . "<br>";
                    // $id = $items["id"];
                    // $image = $items["image"];
                    // $name = $items["name"];
                    // $price = $items["price"];
                    // 
                    echo "<div class='cart-items-cont'>
                    <a href='' class='cart-items'>
                            <img src='".$items->image."' class='cart-images'>
                            <h4>Item: ".$items->name."</h4> 
                            <h5>Price: KSH " . $items->price . "</h5>
                    </a>
                    <form method='post' action='remove-frm-cart.php'>
                          <input type='hidden' name='remove_item_id' value='".$items->id."'>
                          <input type='submit' name='remove_from_cart' value='Remove' id='remove-items-form'>
                    </form><br>
                    </div>";

                }
            }else{
                echo "Cart is Empty";
            }
        }
        
        ?>
        </div>
        <h4>Total: <?php if (isset($_SESSION["id"])) {echo $total;}else {echo $_SESSION["total"];}?></h4>
    </div>

    <h2>More Watches</h2>

    <div class="container">
    <?php

        $stmt = $conn->prepare("SELECT * FROM all_products ORDER BY id DESC");
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows > 0) {
        while ($row=$res->fetch_assoc()) {
        echo '<div class="items">
                <a href="product.php?id='.$row["id"].'">
                <img src="'. $row["image"] . '" alt="" class="item-images">
                <h3>'. $row["name"] . '</h3>
                <h4>Price: KSH ' . $row["price"] . '</h4>
                </a>
        </div>';
}
}


?>
    </div>
</main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="js/index.js"></script>
</body>
</html>