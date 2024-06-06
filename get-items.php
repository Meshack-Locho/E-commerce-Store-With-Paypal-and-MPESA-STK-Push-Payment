<?php

session_start(); // Start the session

include("db.php");


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