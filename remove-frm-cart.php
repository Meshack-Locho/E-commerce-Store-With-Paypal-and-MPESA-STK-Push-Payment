<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart Item Deletion</title>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Josefin Sans">
    <style>
        .body{
            width: 100%;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Josefin sans;
        }
        .confirmation{
            width: 300px;
            padding: 50px 10px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            background-color: rgb(129, 131, 253);
            color: black;
            align-items: center;
            justify-content: center;
        }
        .confirmation button{
            width: 150px;
            padding: 10px;
            border: none;
            background-color: rgb(202, 203, 255);
            border-radius: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    
</body>
</html>
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
        

        if (isset($remove_id)) {
            foreach($cart as $key => $item) {
                if($item['id'] == $remove_id) {
                    unset($cart[$key]);
                    echo "<div class='confirmation'>
                            <h3>Item deleted</h3>  
                            <button onclick='history.back()'>Back</button>
                          </div>";
                    break; // Break out of loop since the item is found and unset
                }
            }

            $new_cart = json_encode($cart);

            $stmt = $conn2->prepare("UPDATE users SET cart=? WHERE id=?");
            $stmt->bind_param("si", $new_cart, $user_id);
            $stmt->execute();
            $stmt->close();
        }else{
            echo "Item ID NOT SET";
        }
    }else{
        echo "Product Not Found In Cart";
    }
}

?>

