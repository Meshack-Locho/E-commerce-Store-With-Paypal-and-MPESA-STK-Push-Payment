<?php

session_start();
include "db.php";

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

    //Initial Empty Cart at first Sign up

    $myCart = [];
    
    if (isset($_POST['add_to_cart'])) {
        //ADD TO CART IS CLICKED

        //ITEM ID FROM A HIDDEN FORM INPUT
        $item_id = $_POST['item_id'];

        //ALL PRODUCTS FROM THE DATABASE WHERE ID IS EQUAL TO THE SELECTED ITEM'S ID

        $sql = "SELECT * FROM all_products WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $item_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        //PRODUCT INFORMATION ACCORING TO SELECTED ID
        $product_id = $row['id'];
        $product_name = $row['name'];
        $product_price = $row['price'];
        $product_image = $row["image"];

//Retrieving existing cart data from the database and decode it

        $user_id = $_SESSION['id']; // user ID stored in session

        //EACH USER WITH HIS/HER OWN CART COLUMN STORED IN JSON FORMAT
        $sql = "SELECT cart FROM users WHERE id = ?";
        $stmt = $conn2->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        //Retrieving existing cart data from the database and decode it

        $cart = json_decode($row['cart'], true);

//Adding the new product to the cart data
        $cart[] = array(
            'name' => $product_name,
            'id' => $product_id,
            'price' => $product_price,
            'image' => $product_image
        );

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

        echo $total;

        

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