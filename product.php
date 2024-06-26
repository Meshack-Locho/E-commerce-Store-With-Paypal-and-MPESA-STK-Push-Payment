<?php



session_start();

include 'db.php';

$_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];

if (isset($_GET["id"])) {
    $product_id = filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT);

    $stmt = $conn->prepare("SELECT * FROM all_products WHERE id=?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();

}
if (isset($_SESSION["id"])) {
    $user_id = $_SESSION["id"];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $row["name"]?></title>
    <link rel="stylesheet" href="css/products.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Josefin Sans">
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
    </div>

    <div class="search-filters">
    <div class="search-panel">
            <h3>Search for watches</h3>
            <form action="search.php" method="get">
                <input type="search" name="search" id="search" placeholder="Search for items">
                <input type="submit" value="Search">
            </form>
    </div>
    </div>


    <div class="wrapper">
        <div class="images-wrapper">
            <div class="main-image-desc">

                <?php
                $stmt = $conn->prepare("SELECT * FROM all_products WHERE id=?");
                $stmt->bind_param("i", $product_id);
                $stmt->execute();
                $res = $stmt->get_result();
                if ($res->num_rows>0) {
                    while ($row = $res->fetch_assoc()) {
                        echo "<div class='items'>
                              <img src='".$row["image"]."' id='main-image'>
                              <h1>".$row["name"]."</h1>  
                              <h5>Brand: Lorem</h5>
                              <h6>Free Delivery on first purchase</h6>
                              <h5>Price: KSH ". $row["price"] . "</h5>
                              <h5>Share Product</h5>
                              <div class='share-links'>
                              <a href=''><i class='fa-brands fa-facebook'></i></a>
                              <a href=''><i class='fa-brands fa-x-twitter'></i></a>
                              <div class='qty-cont'>
                                <label for='quantity'>Qty</label>
                                <input type='number' name='quantity' id='quantity'>
                              </div>
                              </div>
                                <form method='post' id='add-to-cart'>
                                    <input type='hidden' id='item_id' name='item_id' value='". $row["id"] . "'>
                                        <input type='hidden' id='item_image' name='item_image' value='". $row["image"] . "'>
                                        <input type='hidden' id='item_name' name='item_name' value='". $row["name"] . "'>
                                        <input type='hidden' id='item_price' name='item_price' value='". $row["price"] . "'>
                                        <input type='submit' name='add_to_cart' value='Add to Cart' id='add-to-cart-btn' class='add-to-cart'>
                                </form>
                              </div>";
                              
                }
                if (isset($_SESSION["id"])) {
                    $stmt = $conn->prepare("SELECT * FROM all_products WHERE id=?");
                    $stmt->bind_param("i", $product_id);
                    $stmt->execute();
                    $res = $stmt->get_result();

                    if ($res->num_rows > 0) {
                        $product = $res->fetch_assoc();
                        $stmt=$conn2->prepare("INSERT INTO recent_views (product_id, user_id, name, image, price) VALUES (?,?,?,?,?) 
                        ON DUPLICATE KEY UPDATE time_viewed = CURRENT_TIMESTAMP ");
                        $stmt->bind_param("iissi", $product_id, $user_id, $product["name"], $product["image"], $product["price"]);
                        $stmt->execute();

                        $stmt->close();
                    }
                    
                }
                
                }
                
                
                ?>
            </div>

            <div class="gallery-info">
                <h4>Other Images Example</h4>
            <div class="image-gallery">
                <img src="images/gold-watch.jpg" alt="">
                <img src="images/round-silver-watch.jpg" alt="">
                <img src="images/watch-3.jpg" alt="">
                <img src="images/watch-2.jpg" alt="">
            </div>

            <div class="info">
                <h3>Order Now</h3>
                <a href="tel:+254712345678"><i class="fa-solid fa-phone"></i> Call Now for delivery</a>
                <button id="whatsapp-order">Order on Whatsapp <i class="fa-brands fa-whatsapp"></i></button>

                <h3>Types of Delivery</h3>
                <div class="delivery-types">
                    <div class="type">
                        <div class="det-head">
                        <div>
                        <i class="fa-solid fa-hands-holding"></i>
                        <h5>Door Delivery</h5>
                        </div>
                        <button class="details-btn">Details</button>
                        </div>
                        <p class="details">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem molestias fuga magnam molestiae, hic animi alias ea beatae, explicabo aut quo praesentium! Ea error architecto dicta, numquam voluptate excepturi distinctio.
                        </p>
                    </div>
                    <div class="type">
                        <div class="det-head">
                            <div>
                                <i class="fa-solid fa-truck"></i>
                                <h5>Pick up Delivery</h5>
                            </div>
                            <button class="details-btn">Details</button>
                        </div>

                        <p class="details">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem molestias fuga magnam molestiae, hic animi alias ea beatae, explicabo aut quo praesentium! Ea error architecto dicta, numquam voluptate excepturi distinctio.
                        </p>
                    </div>
                    <div class="type">
                        <div class="det-head">
                            <div>
                                <i class="fa-solid fa-moon"></i>
                                <h5>Overnight Delivery</h5>
                            </div>
                            <button class="details-btn">Details</button>
                        </div>

                        <p class="details">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem molestias fuga magnam molestiae, hic animi alias ea beatae, explicabo aut quo praesentium! Ea error architecto dicta, numquam voluptate excepturi distinctio.
                        </p>
                    </div>
                </div>
            </div>
            </div>
        </div>

        <h2>Product Details and Descriptions</h2>

        <div class="details-desc">
        <div class="desc">
            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Error quas est eos, deleniti nisi, cum ducimus veniam sequi mollitia sed nihil nulla hic exercitationem fugit nesciunt asperiores voluptate distinctio dolore.

            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Obcaecati quae nam deserunt harum! Consectetur sequi sit saepe numquam, minus mollitia. Illum voluptatum reprehenderit a facere fugit. Quo mollitia voluptatem obcaecati!
            </p>
        </div>

        <h2>Features</h2>

        <div class="details">
            <ol>
                <li>Detail</li>
                <li>Detail</li>
                <li>Detail</li>
                <li>Detail</li>
                <li>Detail</li>
                <li>Detail</li>
            </ol>
        </div>
        </div>

        <h2>You may also Like</h2>

        <div class="other-items">
            <?php
            $stmts=$conn->prepare("SELECT * FROM all_products ORDER BY id LIMIT 4");
            $stmts->execute();
            $products = $stmts->get_result();
            while ($row = $products->fetch_assoc()) {
                echo '
                <div>
                <a href="product.php?id='.$row["id"].'">
                    <img src="'. $row["image"] . '" alt="" class="item-images">
                    <h3>'. $row["name"] . '</h3>
                    <h4>Price: KSH ' . $row["price"] . '</h4>
                    </a>
                </div>';
            }

            
            ?>
            

        </div>
    </div>

    <div id="cart-response" class="cart-response">
        <i class="fa-solid fa-circle-xmark" id="close-dialog"></i>
        <h3 class="added-item-name"></h3>
        <a href="cart.php">View Cart</a>
    </div>

    <div id="ajax-loader">
        <div class="spinner"></div>
    </div>

    <footer>
        <h3>Mellow Wrist Watches &copy; Copyright 2024</h3>
        <h5>Created by, Meshack Locho</h5>
    </footer>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="js/index.js"></script>

    <script>
        let moreProdPhotos = document.querySelectorAll(".image-gallery img")
        let mainImage = document.getElementById("main-image")


        for (let i = 0; i < moreProdPhotos.length; i++) {
            moreProdPhotos[i].addEventListener("click", ()=>{
                mainImage.src = moreProdPhotos[i].src
            })
            
        }

        let types = document.querySelectorAll(".type")

        document.addEventListener("DOMContentLoaded", ()=>{
            for (let i = 0; i < types.length; i++) {
                types[i].addEventListener("click", (event)=>{
                    if (event.target && event.target.classList.contains('details-btn')) {
                        types[i].classList.toggle("active")
                    }
                })
                
            }
        })

        <?php

        $product_id = filter_var($_GET["id"], FILTER_SANITIZE_NUMBER_INT);

        $stmt = $conn->prepare("SELECT * FROM all_products WHERE id=?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc(); ?>
            const productUrl = "http://localhost:8080/mysite/ec-website/product.php?id=<?php echo $row["id"]?>"
            const productName = "<?php echo $row["name"]?>"
            const productPrice = "<?php echo $row["price"]?>"
        <?php
        ?>

        let whatsappOrderBtn = document.getElementById("whatsapp-order")
        const phone = 254714352684

        whatsappOrderBtn.onclick = function () {
            let url = "https://wa.me/" + phone + "?text=" + 
            "Product Name: " + productName + "%0a" +
            "Product Url: " + productUrl + "%0a" +
            "Product price: " + productPrice + "%0a%0a"

            window.open(url, "_blank").focus()
        }

    </script>

    
    <?php
    
    $conn->close();
    $conn2->close();
    ?>
    
</body>
</html>