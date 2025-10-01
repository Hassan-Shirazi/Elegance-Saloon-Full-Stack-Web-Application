<?php
// Database configuration
$host     = "localhost";   
$user     = "root";      
$pass     = "";            
$dbname   = "elegence";  

// Create connection with improved error handling
$conn = mysqli_connect($host, $user, $pass, $dbname);

// Check connection
if (!$conn) {
    die("❌ Database connection failed: " . mysqli_connect_error());
}

// Set charset for security (to avoid charset issues & SQL injection tricks)
if (!mysqli_set_charset($conn, "utf8mb4")) {
    die("❌ Error loading character set utf8mb4: " . mysqli_error($conn));
}


?>
