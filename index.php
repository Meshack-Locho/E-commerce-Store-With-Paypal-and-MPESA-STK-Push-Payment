<?php

session_start();

include("db.php");

// Check if cart array exists in session, if not, create it
    




// Check if item is added to cart
if (!isset($_SESSION["id"])) {

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    function add_to_cart($item_id, $item_image, $item_name, $item_price) {
        $_SESSION['cart'][] = array(
            'id' => $item_id,
            'image' => $item_image,
            'name' => $item_name,
            'price' => $item_price
        );
    }
    
    
    // Function to add item to cart
    
    if (isset($_POST['add_to_cart'])) {
        $item_id = $_POST['item_id'];
        $item_name = $_POST['item_name'];
        $item_price = $_POST['item_price'];
        $item_image = $_POST['item_image'];
        add_to_cart($item_id, $item_image, $item_name, $item_price);
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
    
    $_SESSION["total"] = $total;
}else{
    // $cartArr = $_SESSION["cart"];
    
    // $cartJson = json_encode($_SESSION["cart"]);

    $myCart = [];

    



    // function add_to_cart() {
        
    //     $item_name = $_POST['item_name'];
    //     $item_price = $_POST['item_price'];
    //     $item_image = $_POST['item_image'];

    //     $cartArr = array(
    //         'id' => $item_id,
    //         'image' => $item_image,
    //         'name' => $item_name,
    //         'price' => $item_price
    //     );
    //     $cartJson = json_encode($cartArr);
    // }
    
    if (isset($_POST['add_to_cart'])) {
        

        $item_id = $_POST['item_id'];

        $sql = "SELECT * FROM all_products WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $item_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $product_id = $row['id'];
        $product_name = $row['name'];
        $product_price = $row['price'];
        $product_image = $row["image"];

//Retrieving existing cart data from the database and decode it

        $user_id = $_SESSION['id']; // Assuming you have user ID stored in session
        $sql = "SELECT cart FROM users WHERE id = ?";
        $stmt = $conn2->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $cart = json_decode($row['cart'], true);

//Adding the new product to the cart data
        $cart[] = array(
            'name' => $product_name,
            'id' => $product_id,
            'price' => $product_price,
            'image' => $product_image
        );

//Encoding the updated cart data
            $updated_cart_json = json_encode($cart);

//Updating the database with the updated cart data
            $sql = "UPDATE users SET cart = ? WHERE id = ?";
            $stmt = $conn2->prepare($sql);
            $stmt->bind_param("si", $updated_cart_json, $user_id);
            $stmt->execute();
            $stmt->close();
    }
    
    
    
}



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
                <button>Prices</button>
                <button>Name</button>
                <button>Type</button>
            </div>
        </div>
    </div>
        
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
            <div class="actions">
            <form method="post" action="" id="add-to-cart" onsubmit="preventRel()">
                <input type="hidden" name="item_id" value="'. $row["id"] . '">
                <input type="hidden" name="item_image" value="'. $row["image"] . '">
                <input type="hidden" name="item_name" value="'. $row["name"] . '">
                <input type="hidden" name="item_price" value="'.$row["price"].'">
                <input type="submit" name="add_to_cart" value="Add to Cart">
            </form>
            <a href="checkout.php">Buy now</a>
            </div>
            </div>';
    }
}

        
        ?>
    </div>
    </main>
    
    <footer>
        <h3>Mellow Wrist Watches &copy; Copyright 2024</h3>
        <h5>Created by, Meshack Locho</h5>
    </footer>

    <script src="js/index.js"></script>
</body>
</html>