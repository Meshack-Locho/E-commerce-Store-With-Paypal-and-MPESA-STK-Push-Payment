<?php

session_start();
include "db.php";

if (isset($_POST['remove_from_cart'])) {
    $user_id = $_SESSION["id"];
    // $item_key = null;
    // $item_id = $_POST["remove_item_id"];
    // foreach ($cart as $key => $item) {
    //     if ($item->id == $item_id) {
    //         $item_key = $key;
    //         break;
    //   }
    // }

    // if ($item_key !== null) {
    //     unset($cart->$item_key);
    // }

    // $stmt = $conn2->prepare("UPDATE users SET cart=? WHERE id=?");
    // $new_cart = json_encode($cart);
    // $stmt->bind_param("si", $new_cart, $user_id);
    // $stmt->execute();
    // $stmt->close();

    if (isset($_POST["remove_item_id"])) {
        $remove_id = $_POST["remove_item_id"];
        $stmt=$conn2->prepare("SELECT cart FROM users WHERE id=?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $cart = json_decode($row['cart'], true);
        echo $remove_id;
        

        if (isset($remove_id)) {
            foreach($cart as $key => $item) {
                if($item['id'] == $remove_id) {
                    unset($cart[$key]);
                    echo "Item deleted";
                    break; // Break out of loop since the item is found and unset
                }
            }

            $new_cart = json_encode($cart);

            $stmt = $conn2->prepare("UPDATE users SET cart=? WHERE id=?");
            $stmt->bind_param("si", $new_cart, $user_id);
            $stmt->execute();
            $stmt->close();
            echo "SET";
        }else{
            echo "NOT SET";
        }
    }else{
        echo "Product Not Found In Cart";
    }
}

?>