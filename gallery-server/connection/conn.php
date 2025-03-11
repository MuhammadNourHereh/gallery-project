<?php

// connection constants
define('DB_HOST', 'localhost');
define('DB_NAME', 'faq_db');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

// conn object
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_PASSWORD);
// select database
try {
    mysqli_select_db($conn, DB_NAME);
} catch (Exception $e) {
    mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS " . DB_NAME);
    mysqli_select_db($conn, DB_NAME);
    echo "Database " . DB_NAME . " was created successfully\n";
}
if ($conn->connect_error) {
    die("Connection failed $conn->connect_error");
}