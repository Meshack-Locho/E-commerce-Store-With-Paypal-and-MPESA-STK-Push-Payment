<?php

session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userId = filter_var($_POST["user-id"], FILTER_SANITIZE_NUMBER_INT);
    $subject = $_POST["subject"];
    $message = $_POST["message"];
    $sender = "Mellow Watches";

    $stmt = $conn2->prepare("INSERT INTO user_messages (sender, receiver_id, subject, message) VALUES (?,?,?,?)");
    $stmt->bind_param("siss", $sender, $userId, $subject, $message);
    $stmt->execute();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
        <label for="user-id">User's ID</label>
        <input type="number" name="user-id" id="user-id" required>
        <label for="subject">Subject</label>
        <input type="text" name="subject" id="subject">
        <label for="message">Message</label>
        <textarea name="message" id="message" required></textarea>
        <input type="submit" value="send">
    </form>
</body>
</html>