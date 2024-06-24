<?php

session_start();
include "db.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



if (!isset($_SESSION["id"])) {

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    function add_to_cart($item_id, $item_image, $item_name, $item_price, $quantity) {
        $_SESSION['cart'][] = array(
            'id' => $item_id,
            'image' => $item_image,
            'name' => $item_name,
            'price' => $item_price,
            'quantity' => $quantity
        );
    }
    
    
    // Function to add item to cart
    
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $item_id = $_POST['item_id'];
        $item_name = $_POST['item_name'];
        $item_price = $_POST['item_price'];
        $item_image = $_POST['item_image'];
        $quantity = $_POST["quantity"];
        if ($quantity) {
            $item_price = $item_price * $quantity;
        }else{
            $item_price = $item_price;
        }
        add_to_cart($item_id, $item_image, $item_name, $item_price, $quantity);
    }

    
    
    $cartCount = count($_SESSION["cart"]);
    
    function calcTotal(){
        $total = 0;
        foreach ($_SESSION['cart'] as $item){
            $total += $item['price'];
        }
        return $total;
    }
    $session_cart = $_SESSION["cart"];
    
    $total = calcTotal();
    
    $_SESSION["total"] = $total;

    if ($quantity>0) {
        echo "$quantity of $item_name has been added to your cart";
    }else{
        echo "1 of $item_name has been added to your cart";
    }
}else{

   

    //Initial Empty Cart at first Sign up


    $myCart = [];
    
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
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
        $quantity = $_POST["quantity"];


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

        if ($quantity) {
            $product_price = $product_price * $quantity;
        }else{
            $product_price = $product_price;
        }

        
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
            
            if ($stmt->execute()) {
                if ($quantity>0) {
                    echo "$quantity of $product_name has been added to your cart";
                }else{
                    echo "1 of $product_name has been added to your cart";
                }
            }else{
                echo "An error occured while adding the item to the cart, please try again.";
            }
            $stmt->close();
        


    }
    
    
    
}


?>