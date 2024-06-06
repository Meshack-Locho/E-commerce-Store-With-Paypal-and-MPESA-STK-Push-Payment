<?php

session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Check if cart array exists in session, if not, create it
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}



$cartCount = count($_SESSION["cart"]);

function calcTotal(){
    $total = 0;
    foreach ($_SESSION['cart'] as $item){
        $total += $item['price'];
    }
    return $total;
}

$total = calcTotal();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Out</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Josefin Sans">

          <style>
            body{
                height: 100vh;
                overflow: hidden;
            }
          </style>
</head>
<body>
    <div class="wrapper">
        <form action="checkout.php">
            <a href="cart.php"><i class="fa-solid fa-angle-left"></i>Go back to cart</a>
            <h2>Check Out Form</h2>
            <div class="fields">

            <div>
                <label for="first-name">First Name</label>
                <input type="text" name="first-name" id="first-name" required placeholder="Enter your first name">
            </div>

            <div>
                <label for="second-name">Second Name</label>
                <input type="text" name="second-name" id="second-name" required placeholder="Enter your second name">
            </div>

            <div>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="ex, johndoe@example.com" required>
            </div>

            <div>
                <label for="location">Location</label>
                <select name="location" id="location">
                    <option value="select place">Select a Place</option>
                    <option value="place1">Place 1</option>
                    <option value="place2">Place 2</option>
                    <option value="place3">Place 3</option>
                    <option value="place4">Place 4</option>
                </select>
            </div>


            <div>
                <label>Delivery Type</label>
                <span>
                    <div>
                    <label for="normal">Normal Delivery</label>
                    <input type="radio" name="radio" id="normal" value="normal">
                    </div>
                    <div>
                    <label for="overnight">Overnight delivery</label>
                    <input type="radio" name="radio" id="overnight" value="overnight">
                    </div>
                </span>
            </div>

            </div>

            <input type="submit" value="Place Order" name="submit">
        </form>


        <div class="checkout-items">
            <?php
            
            if (!empty($_SESSION['cart'])) {
                echo "<h2>Your Items:</h2>";
                foreach ($_SESSION['cart'] as $item) {
                    echo "<div class='cart-items'>
                            <img src='{$item['image']}' class='cart-images'>
                            <h4>Item: {$item['name']}</h4> 
                            <h5>Price: KSH {$item['price']}</h5>
                          </div>";
                }
                
            }else{
                echo "<h2>No Items in the Cart</h2>";
            }
            
            ?>

            <h3><?php echo "<h3>Total: $total</h3>";?></h3>    
        </div>
    </div>

    
</body>
</html>