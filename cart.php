<?php
session_start();
include 'db.php';


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
                    <li><a href="">Home</a></li>
                    <li><a href="">Watches</a></li>
                    <li><a href="">Contact</a></li>
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

    <h4>Total: <?php echo $total?></h4>

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
        }else{
            $user_id = $_SESSION["id"];

            $stmt = $conn2->prepare("SELECT cart FROM users WHERE id =?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $res = $stmt->get_result();
            $row=$res->fetch_assoc();
            $cart = json_decode($row['cart']);

            
            var_dump($cart);
            $t = (array)$cart;

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
                    <form method='post' action=''>
                          <input type='hidden' name='remove_item_id' value='".$items->id."'>
                          <input type='submit' name='remove_from_cart' value='Remove' id='remove-items-form'>
                    </form><br>
                    </div>";

                }
                if (isset($_POST['remove_from_cart'])) {
                    // $item_key = null;
                    // $item_id = $_POST["remove_item_id"];
                    // foreach ($cart as $key => $item) {
                    //     if ($item->id == $item_id) {
                    //         $item_key = $key;
                    //         break;
                    //   }
                    // }

                    // if ($item_key !== null) {
                    //     unset($cart->$item_key);
                    // }

                    // $stmt = $conn2->prepare("UPDATE users SET cart=? WHERE id=?");
                    // $new_cart = json_encode($cart);
                    // $stmt->bind_param("si", $new_cart, $user_id);
                    // $stmt->execute();
                    // $stmt->close();

                    if (isset($_POST["remove_item_id"])) {
                        $remove_id = $_POST["remove_item_id"];
                        $stmt=$conn2->prepare("SELECT cart FROM users WHERE id=?");
                        $stmt->bind_param("i", $user_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $row = $result->fetch_assoc();
                        $cart = json_decode($row['cart'], true);
                        echo $remove_id;
                        echo $cart->$remove_id;

                        if (isset($remove_id)) {
                            unset($cart->$remove_id);

                            $new_cart = json_encode($cart);

                            $stmt = $conn2->prepare("UPDATE users SET cart=? WHERE id=?");
                            $stmt->bind_param("si", $new_cart, $user_id);
                            $stmt->execute();
                            $stmt->close();
                            echo "SET";
                        }else{
                            echo "NOT SET";
                        }
                    }else{
                        echo "Product Id Not there";
                    }
                }
            }else{
                echo "Cart is Empty";
            }
        }
        
        ?>
        </div>
    </div>
</main>

    <script src="js/index.js"></script>
</body>
</html>