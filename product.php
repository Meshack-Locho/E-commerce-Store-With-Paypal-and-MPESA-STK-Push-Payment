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
    <title>Document</title>
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
                              </div>
                                <form action='add-to-cart.php' method='post'>
                                    <input type='hidden' name='item_id' value='". $row["id"] . "'>
                                        <input type='hidden' name='item_image' value='". $row["image"] . "'>
                                        <input type='hidden' name='item_name' value='". $row["name"] . "'>
                                        <input type='hidden' name='item_price' value='". $row["price"] . "'>
                                        <input type='submit' name='add_to_cart' value='Add to Cart' id='add-to-cart-btn'>
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
                $conn->close();
                $conn2->close();
                }
                
                
                ?>
            </div>

            <div class="gallery-info">
            <div class="image-gallery">
                <img src="images/gold-watch.jpg" alt="">
                <img src="images/round-silver-watch.jpg" alt="">
                <img src="images/watch-3.jpg" alt="">
                <img src="images/watch-2.jpg" alt="">
            </div>

            <div class="info">
                <h3>Order Now</h3>
                <a href="">Buy Now</a>
                <a href=""><i class="fa-solid fa-phone"></i> Call Now for delivery</a>

                <h3>Types of Delivery</h3>
                <div class="delivery-types">
                    <div class="type">
                        <div>
                        <i class="fa-solid fa-hands-holding"></i>
                        <h5>Door Delivery</h5>
                        </div>
                        <button>Details</button>
                    </div>
                    <div class="type">
                        <div>
                        <i class="fa-solid fa-truck"></i>
                        <h5>Pick up Delivery</h5>
                        </div>
                        <button>Details</button>
                    </div>
                    <div class="type">
                        <div>
                        <i class="fa-solid fa-moon"></i>
                        <h5>Overnight Delivery</h5>
                        </div>
                        <button>Details</button>
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
            <div>
                <a href="">
                    <img src="images/gold-watch.jpg" alt="">
                    <h5>Watch Four</h5>
                    <h5>Price KSH 2, 345</h5>
                </a>    

                <button>Add to Cart</button>
            </div>

            <div>
                <a href="">
                    <img src="images/watch-5.jpg" alt="">
                    <h5>Watch Five</h5>
                    <h5>Price KSH 1, 299</h5>
                </a>    

                <button>Add to Cart</button>
            </div>

            <div>
                <a href="">
                    <img src="images/round-silver-watch.jpg" alt="">
                    <h5>Watch Type One</h5>
                    <h5>Price KSH 1, 789</h5>
                </a>    

                <button>Add to Cart</button>
            </div>
            <div>
                <a href="">
                    <img src="images/square-anlogue-watch.jpg" alt="">
                    <h5>Square Analogue watch</h5>
                    <h5>Price KSH 789</h5>
                </a>    

                <button>Add to Cart</button>
            </div>
            <div>
                <a href="">
                    <img src="images/wrist-watch.jpg" alt="">
                    <h5>Wrist Watch</h5>
                    <h5>Price KSH 1, 089</h5>
                </a>    

                <button>Add to Cart</button>
            </div>

        </div>
    </div>

    <footer>
        <h3>Mellow Wrist Watches &copy; Copyright 2024</h3>
        <h5>Created by, Meshack Locho</h5>
    </footer>
    

    <script>
        let moreProdPhotos = document.querySelectorAll(".image-gallery img")
        let mainImage = document.getElementById("main-image")


        for (let i = 0; i < moreProdPhotos.length; i++) {
            moreProdPhotos[i].addEventListener("click", ()=>{
                mainImage.src = moreProdPhotos[i].src
            })
            
        }

//         document.addEventListener('DOMContentLoaded', function() {
//         const productId = <?php echo $product_id?>; // Replace with the actual product ID
//         const userId = <?php echo $user_id?>; // Replace with the actual user ID if available

//     fetch('product.php', {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/x-www-form-urlencoded'
//         },
//         body: `product_id=${productId}&user_id=${userId}`
//     })
//     .then(response => response.json())
//     .then(data => {
//         if (data.status === 'success') {
//             console.log('View logged successfully');
//         } else {
//             console.log('Failed to log view');
//         }
//     })
//     .catch(error => console.error('Error:', error));

   
// });


    </script>
</body>
</html>