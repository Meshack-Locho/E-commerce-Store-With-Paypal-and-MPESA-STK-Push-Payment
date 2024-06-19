<?php

session_start();
include "db.php";

$user_id = $_SESSION["id"];
$stmt = $conn2->prepare("SELECT COUNT(*) AS unread_count FROM user_messages WHERE is_read=0 AND receiver_id =?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$count = $result->fetch_assoc();


$unread_count = $count["unread_count"];
echo $unread_count;
?>