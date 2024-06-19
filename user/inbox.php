<?php

session_start();
include "db.php";

if (!isset($_SESSION["id"])) {
    header("Location: http://localhost:8080/mysite/ec-website/login.php");
}else{
    $user_id = $_SESSION["id"];
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Inbox</title>
    <link rel="stylesheet" href="http://localhost:8080/mysite/ec-website/css/users.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Josefin Sans">
</head>
<body>
<header>
    <div class="navigation">
            <a href="" class="logo">
                <img src="http://localhost:8080/mysite/ec-website/images/hero/hero-4.png" alt="">
                <h2>Mellow Watches</h2>
            </a>
            <div class="search-panel">
                <form action="search.php" method="get">
                    <input type="search" name="search" id="search" placeholder="Search for watches">
                    <input type="submit" value="Search">
                </form>
            </div>

            <nav>
                <ul>
                    <li id="user-name">Hello <?= $_SESSION["fname"]?> <i class="fa-solid fa-angle-down"></i>
                            
                    <div class="user-options">
                        <a href="http://localhost:8080/mysite/ec-website/index.php">Home</a>
                        <a href="http://localhost:8080/mysite/ec-website/checkout.php">Checkout</a>
                        <a href="http://localhost:8080/mysite/ec-website/logout.php">Logout</a>
                    </div>
                    </li>
                </ul>
            </nav>

            <a href="http://localhost:8080/mysite/ec-website/cart.php" class="cart-toggle cart-icon">
                <i class="fa-solid fa-cart-shopping"></i>
                <span id="items-count">0</span>
            </a>
        </div>
    </header>

    <main>
        <section class="acc-info">
            <div class="options">
                <a href="dashboard.php"><i class="fa-solid fa-user"></i> My Account</a>
                <a href="orders.php"><i class="fa-solid fa-bag-shopping"></i> Orders</a>
                <a href="inbox.php"><i class="fa-solid fa-envelope"></i> Inbox</a>
                <a href="recents.php"><i class="fa-solid fa-clock-rotate-left"></i> Recently Viewed</a>
                <a href="subscriptions.php"><i class="fa-solid fa-newspaper"></i> Subscriptions</a>
                <a href="http://localhost:8080/mysite/ec-website/logout.php" id="logout-link"><i class="fa-solid fa-person-through-window"></i> Logout</a>
            </div>

            <div class="messages">
                <h3>Inbox</h3>
                <div class="inbox">
                    <?php
                    
                        $stmt = $conn2->prepare("SELECT * FROM user_messages WHERE receiver_id=? ORDER BY time DESC");
                        $stmt->bind_param("i", $user_id);
                        $stmt->execute();
                        $results = $stmt->get_result();

                        if ($results->num_rows > 0) {
                            while ($messages = $results->fetch_assoc()) {
                                $messageId = $messages["id"];
                                $sender = $messages["sender"];
                                $subject = $messages["subject"];
                                $message = $messages["message"];
                                $time = new DateTime($messages["time"]);
                                $formattedTime =  $time->format('d - Y H:i A');
                                $time = DateTime::createFromFormat('d - Y H:i A', $formattedTime);

                                echo "<div class='message' data-message-id='$messageId '>
                                    
                                        <h4>From: ".htmlspecialchars($sender)."</h4>
                                        <h5>".htmlspecialchars($subject)."</h5>
                                        <p>".htmlspecialchars($message)."</p>
                                        <h6>".htmlspecialchars($time->format("F") . ", ". $formattedTime)."</h6>

                                      </div>";
                            }
                        }else{ ?>
                            <div class="no-messages">
                                <i class="fa-solid fa-envelope"></i>
                                <h4>You currenly don't have any messages</h4>
                                <p>Here, you will be able to see any messages we send you.</p>
                                <a href="http://localhost:8080/mysite/ec-website/index.php">Shop Now</a>
                            </div>
                        <?php }
                    
                    ?>
                </div>
            </div>
        </section>

        <div class="message-display">
            <i class="fa-solid fa-circle-xmark close-message"></i>
            <h2>Message Body</h2>
            <h4></h4>
            <h5 id="subject"></h5>
            <p></p>
            <h6></h6>
        </div>

        <section class="recommendations">
            <h3>Recommended for you</h3>
            <div class="container">
                <?php
                
                $stmt=$conn->prepare("SELECT * FROM all_products ORDER BY id DESC LIMIT 5");
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();

                if ($result->num_rows > 0) {
                    while ($row=$result->fetch_assoc()) {
                        echo '<div class="items">
                        <a href="http://localhost:8080/mysite/ec-website/product.php?id='.$row["id"].'">
                            <img src="http://localhost:8080/mysite/ec-website/'.$row["image"] . '" alt="" class="item-images">
                            <h3>'. $row["name"] . '</h3>
                            <h4>Price: KSH ' . $row["price"] . '</h4>
                        </a>
                      </div>';
                    }
                }else{
                    echo "<h3>No Recommendations Available</h3>";
                }
                
                ?>
            </div>
        </section>
    </main>

    <footer>
        <h3>Mellow Wrist Watches &copy; Copyright 2024</h3>
        <h5>Created by, Meshack Locho</h5>
    </footer>

    <script src="http://localhost:8080/mysite/ec-website/js/user.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
// Add an event listener to message elements
document.querySelectorAll('.message').forEach(message => {
    message.addEventListener('click', function() {
        // Get the message ID from a data attribute
        const messageId = this.getAttribute('data-message-id');
        
        // Send the message ID to the server to update the status
        markAsRead(messageId);
    });
});

function markAsRead(messageId) {
    // Make an AJAX request to update the message status
    fetch('update_message_status.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `message_id=${messageId}`,
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            console.log(`Message ${messageId} marked as read.`);
            // Optionally, update the UI to reflect the read status
            document.querySelector(`[data-message-id='${messageId}']`).classList.add('read');
        } else {
            console.error('Error updating message status:', data.message);
        }
    })
    .catch(error => console.error('Request failed', error));
}
</script>
</body>
</html>