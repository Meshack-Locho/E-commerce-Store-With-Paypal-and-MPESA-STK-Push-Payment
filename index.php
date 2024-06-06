<?php

session_start();

include("db.php");

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


// Sample form to add items to cart
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
                    <li><a href="" id="login-link">Login</a></li>
                    <li><a href="" id="signup-link">Sign Up</a></li>
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


        <div class="search-panel">
            <h3>Search for watches</h3>
            <form action="search.php" method="get">
                <input type="search" name="search" id="search">
                <input type="submit" value="Search">
            </form>
        </div>
        <img src="images/hero/hero-4.png" alt="" class="hero-img">
    </header>
    <div class="container">
        <?php

            $stmt = $conn->prepare("SELECT * FROM all_products ORDER BY id DESC");
            $stmt->execute();
            $res = $stmt->get_result();

        if ($res->num_rows > 0) {
            while ($row=$res->fetch_assoc()) {
            echo '<div class="items">
                <a href="">
                <img src="'. $row["image"] . '" alt="" class="item-images">
                <h3>'. $row["name"] . '</h3>
                <h4>Price: KSH ' . $row["price"] . '</h4>
                </a>
            <div class="actions">
            <form method="post" action="" id="add-to-cart">
                <input type="hidden" name="item_id" value="'. $row["id"] . '">
                <input type="hidden" name="item_image" value="'. $row["image"] . '">
                <input type="hidden" name="item_name" value="'. $row["name"] . '">
                <input type="hidden" name="item_price" value="'. $row["price"] . '">
                <input type="submit" name="add_to_cart" value="Add to Cart">
            </form>
            <a href="checkout.php">Buy now</a>
            </div>
            </div>';
    }
}

        
        ?>
    </div>
    

    <script src="js/index.js"></script>
</body>
</html>