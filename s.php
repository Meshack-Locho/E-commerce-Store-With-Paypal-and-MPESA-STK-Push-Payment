<?php
session_start(); // Start the session
include 'db.php';

// Check if cart array exists in session, if not, create it
if (!isset($_SESSION["id"])) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
    
    $cartCount = count($_SESSION["cart"]);
    
    echo $cartCount;
}else{
    $user_id = $_SESSION["id"];

    $stmt = $conn2->prepare("SELECT cart FROM users WHERE id =?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $row=$res->fetch_assoc();
    $cart = json_decode($row['cart'], true);


    echo count($cart);
}
// $conn = new mysqli("localhost", "root", "", "products");


// $stmt = $conn->prepare("SELECT * FROM all_products ORDER BY id DESC");
// $stmt->execute();
// $res = $stmt->get_result();

// if ($res->num_rows > 0) {
//     while ($row=$res->fetch_assoc()) {
//         echo '<div class="items">
//         <a href="">
//         <img src="'. $row["image"] . '" alt="" class="item-images">
//         <h3>'. $row["name"] . '</h3>
//         <h4>Price: $' . $row["price"] . '</h4>
//         </a>
//         <form method="post" action="">
//         <input type="hidden" name="item_id" value="'. $row["id"] . '">
//         <input type="hidden" name="item_image" value="'. $row["image"] . '">
//         <input type="hidden" name="item_name" value="'. $row["name"] . '">
//         <input type="hidden" name="item_price" value="'. $row["price"] . '">
//         <input type="submit" name="add_to_cart" value="Add to Cart">
//         </form>
//         </div>';
//     }
// }



// // Function to add item to cart
// function add_to_cart($item_id, $item_image, $item_name, $item_price) {
//     $_SESSION['cart'][] = array(
//         'id' => $item_id,
//         'image' => $item_image,
//         'name' => $item_name,
//         'price' => $item_price
//     );
// }

// // Function to remove item from cart
// function remove_from_cart($item_id) {
//     foreach ($_SESSION['cart'] as $key => $item) {
//         if ($item['id'] === $item_id) {
//             unset($_SESSION['cart'][$key]);
//             break;
//         }
//     }
// }

// // Check if item is added to cart
// if (isset($_POST['add_to_cart'])) {
//     $item_id = $_POST['item_id'];
//     $item_name = $_POST['item_name'];
//     $item_price = $_POST['item_price'];
//     $item_image = $_POST['item_image'];
//     add_to_cart($item_id, $item_image, $item_name, $item_price);
// }

// // Check if item is removed from cart
// if (isset($_POST['remove_from_cart'])) {
//     $item_id = $_POST['remove_item_id'];
//     remove_from_cart($item_id);
// }

// // Display cart contents
// if (!empty($_SESSION['cart'])) {
//     echo "<h2>Cart Contents:</h2>";
//     foreach ($_SESSION['cart'] as $item) {
//         echo "<div class='cart-items'>
//               <img src='{$item['image']}' class='cart-images'>
//               <h4>Item: {$item['name']}</h4> 
//               <h5>Price: {$item['price']}</h5>
//               </div>";
//         echo "<form method='post' action=''>
//               <input type='hidden' name='remove_item_id' value='{$item['id']}'>
//               <input type='submit' name='remove_from_cart' value='Remove'>
//               </form><br>";
//     }
    
// }else{
//     echo "<h2>No Items in the Cart</h2>";
// }



// Sample form to add items to cart
?>
