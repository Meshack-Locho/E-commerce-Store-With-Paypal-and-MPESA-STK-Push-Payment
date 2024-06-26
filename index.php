<?php

session_start();

include("db.php");


if (!isset($_SESSION["id"])) {
    if (!isset($_SESSION['cart'])) {
         $_SESSION['cart'] = array();
         $_SESSION["total"] = 0;
    }
}
// Check if cart array exists in session, if not, create it
    




// Check if item is added to cart
// if (!isset($_SESSION["id"])) {

//     if (!isset($_SESSION['cart'])) {
//         $_SESSION['cart'] = array();
//     }

//     function add_to_cart($item_id, $item_image, $item_name, $item_price) {
//         $_SESSION['cart'][] = array(
//             'id' => $item_id,
//             'image' => $item_image,
//             'name' => $item_name,
//             'price' => $item_price
//         );
//     }
    
    
//     // Function to add item to cart
    
//     if (isset($_POST['add_to_cart'])) {
//         $item_id = $_POST['item_id'];
//         $item_name = $_POST['item_name'];
//         $item_price = $_POST['item_price'];
//         $item_image = $_POST['item_image'];
//         add_to_cart($item_id, $item_image, $item_name, $item_price);
//     }
    
//     $cartCount = count($_SESSION["cart"]);
    
//     function calcTotal(){
//         $total = 0;
//         foreach ($_SESSION['cart'] as $item){
//             $total += $item['price'];
//         }
//         return $total;
//     }
//     $session_cart = $_SESSION["cart"];
    
//     $total = calcTotal();
    
//     $_SESSION["total"] = $total;
// }else{

//     //Initial Empty Cart at first Sign up

//     $myCart = [];
    
//     if (isset($_POST['add_to_cart'])) {
//         //ADD TO CART IS CLICKED

//         //ITEM ID FROM A HIDDEN FORM INPUT
//         $item_id = $_POST['item_id'];

//         //ALL PRODUCTS FROM THE DATABASE WHERE ID IS EQUAL TO THE SELECTED ITEM'S ID

//         $sql = "SELECT * FROM all_products WHERE id = ?";
//         $stmt = $conn->prepare($sql);
//         $stmt->bind_param("i", $item_id);
//         $stmt->execute();
//         $result = $stmt->get_result();
//         $row = $result->fetch_assoc();

//         //PRODUCT INFORMATION ACCORING TO SELECTED ID
//         $product_id = $row['id'];
//         $product_name = $row['name'];
//         $product_price = $row['price'];
//         $product_image = $row["image"];
//         $quantity = $_POST["quantity"];

// //Retrieving existing cart data from the database and decode it

//         $user_id = $_SESSION['id']; // user ID stored in session

//         //EACH USER WITH HIS/HER OWN CART COLUMN STORED IN JSON FORMAT
//         $sql = "SELECT cart FROM users WHERE id = ?";
//         $stmt = $conn2->prepare($sql);
//         $stmt->bind_param("i", $user_id);
//         $stmt->execute();
//         $result = $stmt->get_result();
//         $row = $result->fetch_assoc();

//         //Retrieving existing cart data from the database and decode it

//         $cart = json_decode($row['cart'], true);

//         if ($quantity) {
//             $product_price = $product_price * $quantity;
//         }else{
//             $product_price = $product_price;
//         }

        
//             //Adding the new product to the cart data
//         $cart[] = array(
//             'name' => $product_name,
//             'id' => $product_id,
//             'price' => $product_price,
//             'image' => $product_image
//         );

        

// //Encoding the updated cart data
//             $updated_cart_json = json_encode($cart);

// //Updating the database with the updated cart data
//             $sql = "UPDATE users SET cart = ? WHERE id = ?";
//             $stmt = $conn2->prepare($sql);
//             $stmt->bind_param("si", $updated_cart_json, $user_id);

//             if ($stmt->execute()) {
//                 echo "Item added";
//             }else{
//                 echo "Item not added";
//             }
//             $stmt->close();
        


//     }
    
    
    
// }








?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Josefin Sans">
    <link rel="stylesheet" href="styles.css">
    <style>
        #user-name{
            color: white;
        }
        .user-options{
            color: black;
        }
    </style>
</head>
<body>
    <header>
        <div class="navigation">
            <a href="" class="logo">
                <img src="images/hero/hero-4.png" alt="">
                <h2>Mellow Watches</h2>
            </a>

            <nav>
                <ul>
                    <li><a href="">Home</a></li>
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

        <div class="header-text-big">
            <h1>Mellow</h1>
            <div>
                <span>Wrist</span>
                <span>Watches</span>
            </div>
        </div>


        
        <img src="images/hero/hero-4.png" alt="" class="hero-img">
    </header>

    <main>
    <div class="search-filters">
    <div class="search-panel">
            <h3>Search for watches</h3>
            <form action="search.php" method="get">
                <input type="search" name="search" id="search">
                <input type="submit" value="Search">
            </form>
        </div>

        <div class="filters">
            <h3>Sort By</h3>
            <div class="sorts">
            <form method="GET" action="index.php">
                <label for="sort_by">Sort by:</label>
                <select name="sort_by" id="sort_by">
                    <option value="price">Price</option>
                    <option value="name">Name</option>
                    <option value="rating">Rating</option>
                    <option value="created_at">Date Added</option>
                </select>

                <label for="order">Order:</label>
                <select name="order" id="order">
                    <option value="ASC">Ascending</option>
                    <option value="DESC">Descending</option>
                </select>

                <button type="submit">Sort</button>
            </form>
            </div>
        </div>
    </div>
        
    <div class="container">
        <?php

            $sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'id';
            $order = isset($_GET['order']) ? $_GET['order'] : 'DESC';

// Validate sort_by and order values
            $allowed_sort_by = ['price', 'name'];
            $allowed_order = ['ASC', 'DESC'];

            if (!in_array($sort_by, $allowed_sort_by)) {
                $sort_by = 'id';
            }

            if (!in_array($order, $allowed_order)) {
                $order = 'DESC';
            }

            $stmt = $conn->prepare("SELECT * FROM all_products ORDER BY $sort_by $order");
            $stmt->execute();
            $res = $stmt->get_result();

        if ($res->num_rows > 0) {
            if (isset($_SESSION["id"])) {
                $user_id = $_SESSION['id'];
                //EACH USER WITH HIS/HER OWN CART COLUMN STORED IN JSON FORMAT
                $sql = "SELECT cart FROM users WHERE id = ?";
                $stmt = $conn2->prepare($sql);
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();

                //Retrieving existing cart data from the database and decode it

                $cart = json_decode($row['cart'], true);
            }

            function checkIfItemExists($itemId, $cartItems){
                foreach ($cartItems as $items) {
                    if ($items["id"] == $itemId) {
                        return true;
                    }
                }
                return false;
            }
            while ($row=$res->fetch_assoc()) {
                
            echo '<div class="items" title='.$row["name"].' data-sort='.$row["price"].'>
                <a href="product.php?id='.$row["id"].'">
                <img src="'. $row["image"] . '" alt="" class="item-images">
                <h3>'. $row["name"] . '</h3>
                <h4>Price: KSH ' . $row["price"] . '</h4>
                </a>
            <div class="actions">
            <form id="add-to-cart" method="POST">
                <input type="hidden" id="item_id" name="item_id" value="'. $row["id"] . '">
                <input type="hidden" id="item_image" name="item_image" value="'. $row["image"] . '">
                <input type="hidden" id="item_name" name="item_name" value="'. $row["name"] . '">
                <input type="hidden" id ="item_price" name="item_price" value="'.$row["price"].'">
                <div class="qty-cont">
                    <label for="quantity">Qty</label>
                    <input type="number" name="quantity" id="quantity">
                </div>';
            
               if (isset($_SESSION["id"])) {
                    echo (checkIfItemExists($row["id"], $cart)) ? '<a href="cart.php">Added - View Cart</a>':'<input type="submit" name="add_to_cart" value="Add to Cart" class="add-to-cart">';
               }else{
                    echo (checkIfItemExists($row["id"], $_SESSION["cart"])) ? '<a href="cart.php">Added - View Cart</a>':'<input type="submit" name="add_to_cart" value="Add to Cart" class="add-to-cart">';
               }

            echo '</form>
            </div>
            </div>';
            
    }
// }else{
// //         function checkIfItemExists($itemId, $cartItems){
// //             foreach ($cartItems as $items) {
// //                 if ($items["id"] == $itemId) {
// //                     return true;
// //                 }
// //             }
// //             return false;
// //         }
// //         while ($row=$res->fetch_assoc()) {
            
// //         echo '<div class="items">
// //             <a href="product.php?id='.$row["id"].'">
// //             <img src="'. $row["image"] . '" alt="" class="item-images">
// //             <h3>'. $row["name"] . '</h3>
// //             <h4>Price: KSH ' . $row["price"] . '</h4>
// //             </a>
// //         <div class="actions">
// //         <form method="post" id="add-to-cart">
// //             <input type="hidden" id="item_id" name="item_id" value="'. $row["id"] . '">
// //             <input type="hidden" id="item_image" name="item_image" value="'. $row["image"] . '">
// //             <input type="hidden" id="item_name" name="item_name" value="'. $row["name"] . '">
// //             <input type="hidden" id="item_price" name="item_price" value="'.$row["price"].'">
// //             <div class="qty-cont">
// //                 <label for="quantity">Qty</label>
// //                 <input type="number" name="quantity" id="quantity">
// //             </div>';
        
// //            echo (checkIfItemExists($row["id"], $_SESSION["cart"])) ? '<a href="cart.php">Added - View Cart</a>':'<input type="submit" name="add_to_cart" value="Add to Cart" class="add-to-cart">';

// //         echo '</form>
// //         <a href="checkout.php">Buy now</a>
// //         </div>
// //         </div>';
        
// // }
//     }
} // user ID stored in session

            


        
        ?>
    </div>

    <div id="cart-response" class="cart-response">
        <i class="fa-solid fa-circle-xmark" id="close-dialog"></i>
        <h3 class="added-item-name"></h3>
        <a href="cart.php">View Cart</a>
    </div>

    <div id="ajax-loader">
        <div class="spinner"></div>
    </div>
    </main>
    
    <footer>
        <h3>Mellow Wrist Watches &copy; Copyright 2024</h3>
        <h5>Created by, Meshack Locho</h5>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="js/index.js"></script>
</body>
</html>