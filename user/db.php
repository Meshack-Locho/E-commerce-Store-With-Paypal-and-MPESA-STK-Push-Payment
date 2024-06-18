<?php

$conn = new mysqli("localhost", "root", "", "products");
$conn2 = new mysqli("localhost", "root", "", "mellow_watches_users");
if ($conn->error) {
    die("Connection failed");
}

if ($conn2->error) {
    die("Connection failed");
}


?>