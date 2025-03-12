<?php

// connection constants
define('DB_HOST', 'localhost');
define('DB_NAME', 'gallery_db');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

// conn object
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_PASSWORD);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Select database or create it if not exists
try {
    mysqli_select_db($conn, DB_NAME);
} catch (Exception $e) {
    mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS " . DB_NAME);
    mysqli_select_db($conn, DB_NAME);
    echo "Database " . DB_NAME . " was created successfully\n";
}