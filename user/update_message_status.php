<?php
session_start();
include 'db.php'; 
$user_id = $_SESSION["id"];
// Check if the message ID is set
if (isset($_POST['message_id'])) {
    $message_id = $_POST['message_id'];
    $message_color = $_POST["message_color"];

    // SQL to update the message status
    $sql = "UPDATE user_messages SET is_read = 1, read_color = ? WHERE id = ? AND receiver_id=?";

    // Prepare and execute the statement
    if ($stmt = $conn2->prepare($sql)) {
        $stmt->bind_param("sii",$message_color, $message_id, $user_id);
        if ($stmt->execute()) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => $conn->error]);
    }
}

$conn->close();
?>
