<?php

session_start();
include "db.php";

if (!isset($_SESSION['id'])) {
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
}else{
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    
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
                box-shadow: 0px 10px 10px rgba(0, 0, 0, 0.2);
            }
            .navigation nav ul a{
                color: black;
            }
            .cart-icon, .checkout-username, .fa-bars{
                color: black;
            }
            .user-options{
                background-color: rgb(162, 163, 251);
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
                    <li><a href="contact.php">Contact</a></li>
                    <?php
                    
                        if (isset($_SESSION["id"])) { ?>
                            <li id="user-name" class="checkout-username" style="color: black;"><?= $_SESSION["fname"]?> <i class="fa-solid fa-angle-down"></i>
                            
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
                <input type="text" name="address" id="address" value="<?= $_SESSION["address"]?>" required>
            </div>


            <div>
                <label for="country">Country</label>
                <select name="country" id="country" required>
                    <option value="select place">Choose Country</option>
                    <option value="Kenya">Kenya</option>
                    <option value="Tanzania">Tanzania</option>
                    <option value="Uganda">Uganda</option>
                    <option value="Ethiopia">Ethiopia</option>
                </select>
            </div>

            <div>
                <label for="city">City</label>
                <select name="city" id="city" required>
                    <option value="<?= $_SESSION["county"]?>"><?= $_SESSION["county"]?></option>
                </select>
            </div>

            <div>
                <label for="postal-code">Postal Code</label>
                <input type="tel" name="postal-code" id="postal-code" required placeholder="Enter postal code">
            </div>

            <div>
                <label>Delivery Type</label>
                <span>
                    <div>
                    <label for="normal">Normal Delivery</label>
                    <input type="radio" name="Order-type" id="normal" value="Normal-delivery" required>
                    </div>
                    <div>
                    <label for="overnight">Overnight delivery</label>
                    <input type="radio" name="Order-type" id="overnight" value="Overnight-delivery" required>
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
                <input type="text" name="address" id="address" placeholder="Enter Your address" required>
            </div>

            <div>
                <label for="country">Country</label>
                <select name="country" id="country" required>
                    <option value="select place">Choose Country</option>
                    <option value="Kenya">Kenya</option>
                    <option value="Tanzania">Tanzania</option>
                    <option value="Uganda">Uganda</option>
                    <option value="Ethiopia">Ethiopia</option>
                </select>
            </div>

            <div>
                <label for="city">City</label>
                <select name="city" id="city" required>
                    <option value="select place">Choose City</option>
                    <option value="place1">Nairobi</option>
                    <option value="place2">Mombasa</option>
                    <option value="place3">Nakuru</option>
                    <option value="place4">Kisumu</option>
                </select>
            </div>

            <div>
                <label for="postal-code">Postal Code</label>
                <input type="tel" name="postal-code" id="postal-code" required>
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
                    <label for="pre-pay">Pay now (Pre-pay - M Pesa)</label>
                    <input type="radio" name="payment-type" id="pre-pay" checked value="Mpesa">
                </div>
                <div>
                    <label for="paypal">Pay now (Paypal)</label>
                    <input type="radio" name="payment-type" id="paypal" value="paypal">
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
            
            if (!isset($_SESSION["id"])) {
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
                    </div>";

                }
            }else{
                echo "Cart is Empty";
            }
            }
            
            ?>

            <h3><?php echo "<h3>Total: KSH $total</h3>";?></h3>    
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="js/index.js"></script>

    <script>
        let guestCheckout = document.getElementById("guest-checkout")
        let checkoutOptions = document.querySelector(".checkout-options")
        const prepayChecker = document.getElementById("pre-pay")
        const postChecker = document.getElementById("cash-payment")
        const paypal = document.getElementById("paypal")
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
        paypal.oninput = ()=>{
            checkoutForm.action = "paypal_order.php"
        }

        guestCheckout.addEventListener("click", ()=>{
            checkoutOptions.classList.add("inactive")
        })


    </script>

    
</body>
</html>