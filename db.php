<?php

$conn = new mysqli("localhost", "root", "", "products");

if ($conn->error) {
    die("Connection failed");
}

?>