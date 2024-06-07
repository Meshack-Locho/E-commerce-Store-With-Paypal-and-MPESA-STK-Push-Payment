<?php

session_start();
include "db.php";

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Check if cart array exists in session, if not, create it
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

$_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];


$cartCount = count($_SESSION["cart"]);

$total = $_SESSION['total'];
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
            .header{
                width: 100%;
                height: 70px;
                background-color: #080808;
            }
            .navigation{
                background-color: rgb(165, 167, 253);
                box-shadow: 0px 10px 10px rgb(202, 203, 255);
            }
            .navigation nav ul a{
                color: black;
            }
            .cart-icon{
                color: black;
            }
            @media screen and (max-width:800px) {
                body{
                    overflow: visible;
                    height: auto;
                }
            }
          </style>
</head>
<body>
    <div class="header">
    <div class="navigation">
            <a href="" class="logo">
                <img src="images/hero/hero-4.png" alt="">
                <h2>Mellow Watches</h2>
            </a>

            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
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
    </div>
    <div class="wrapper">
        <form action="stkpush.php" method="post" id="checkout-form" class="checkout-form">
            <a href="cart.php"><i class="fa-solid fa-angle-left"></i>Go back to cart</a>
            <h2>Check Out Form</h2>
            <div class="fields">
                <?php
                
                if (isset($_SESSION["id"])) {?>
                    
                    
            <div>
                <label for="first-name">First Name</label>
                <input type="text" name="first-name" id="first-name" required placeholder="Enter your first name" value="<?= $_SESSION["fname"]?>">
            </div>

            <div>
                <label for="second-name">Second Name</label>
                <input type="text" name="second-name" id="second-name" required value="<?= $_SESSION["sname"]?>">
            </div>

            <div>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="ex, johndoe@example.com" required value="<?= $_SESSION["email"]?>">
            </div>

            <div>
                <label for="phone">Phone Number</label>
                <input type="tel" name="phone" id="phone" required value="<?= $_SESSION["phone"]?>">
            </div>

            <div>
                <label for="address">Address</label>
                <input type="text" name="address" id="address" placeholder="Enter Your address">
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
                    <input type="radio" name="Order-type" id="normal" value="Normal-delivery">
                    </div>
                    <div>
                    <label for="overnight">Overnight delivery</label>
                    <input type="radio" name="Order-type" id="overnight" value="Overnight-delivery">
                    </div>
                </span>
            </div>

            

                <?php }else{ ?>
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
                <label for="phone">Phone Number</label>
                <input type="tel" name="phone" id="phone" required placeholder="Enter phone number, eg; 254712345678">
            </div>

            <div>
                <label for="address">Address</label>
                <input type="text" name="address" id="address" placeholder="Enter Your address">
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
                    <input type="radio" name="Order-type" id="normal" value="Normal-delivery">
                    </div>
                    <div>
                    <label for="overnight">Overnight delivery</label>
                    <input type="radio" name="Order-type" id="overnight" value="Overnight-delivery">
                    </div>
                </span>
            </div>
                <?php }
                
                ?>

            

            </div>

            
            <div class="payment-method">
                <div>
                    <label for="pre-pay">Pay now (Pre-pay)</label>
                    <input type="radio" name="payment-type" id="pre-pay" checked value="Mpesa">
                </div>
                <div>
                    <label for="cash-payment">Pay cash on delivery</label>
                    <input type="radio" name="payment-type" id="cash-payment" value="Cash Payment">
                </div>
            </div>

            <input type="submit" value="Place Order" name="submit">
        </form>


        <div class="checkout-items">
            <?php
            
            if (!empty($_SESSION['cart'])) {
                echo "<h2>Your Items:</h2>";
                foreach ($_SESSION['cart'] as $item) {
                    $price = $item['price'];
                    echo "<div class='cart-items'>
                            <img src='{$item['image']}' class='cart-images'>
                            <h4>Item: {$item['name']}</h4> 
                            <h5>Price: KSH " . number_format($price) . "</h5>
                          </div>";
                }
                
            }else{
                echo "<h2>No Items in the Cart</h2>";
            }
            
            ?>

            <h3><?php echo "<h3>Total: $total</h3>";?></h3>    
        </div>

        <?php
        
        if (!isset($_SESSION['id'])) {
            echo "<div class='checkout-options'>
            <button id='guest-checkout'>Checkout as Guest</button>
            <a href='signup.php'>Sign up</a>
            <a href='login.php'>Login</a>
            </div>";
        }
        
        ?>
    </div>

    <script>
        let guestCheckout = document.getElementById("guest-checkout")
        let checkoutOptions = document.querySelector(".checkout-options")
        const prepayChecker = document.getElementById("pre-pay")
        const postChecker = document.getElementById("cash-payment")
        postChecker.checked = false
        const checkoutForm = document.getElementById("checkout-form")

        postChecker.addEventListener("input", ()=>{
                checkoutForm.action = "order.php"
                console.log("checked")
                prepayChecker.checked = false
        })

        prepayChecker.oninput = function (){
            checkoutForm.action = "stkpush.php"
        }

        guestCheckout.addEventListener("click", ()=>{
            checkoutOptions.classList.add("inactive")
        })
    </script>
    
</body>
</html>