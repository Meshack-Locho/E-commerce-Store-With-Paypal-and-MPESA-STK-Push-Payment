<?php


session_start();
include "db.php";

if (!isset($_SESSION["id"])) {
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    header("Location: http://localhost:8080/mysite/ec-website/login.php");
}
$user_id = $_SESSION["id"];
$subscription_id = $_GET["id"];

if (isset($subscription_id)) {
    $stmt = $conn2->prepare("DELETE FROM subscriptions WHERE user_id=? AND id=?");
    $stmt->bind_param("ii", $user_id, $subscription_id);
    $stmt->execute();

    if ($stmt->execute()) {
        header("Location: subscriptions.php");
    }
}


?>