<?php
// Database setup script
$servername = "localhost";
$username = "root";
$password = "";

// Create connection without selecting a database
$conn = mysqli_connect($servername, $username, $password);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS messenger_system";
if (mysqli_query($conn, $sql)) {
    echo "Database 'messenger_system' created successfully or already exists.<br>";
} else {
    echo "Error creating database: " . mysqli_error($conn) . "<br>";
}

// Select the database
mysqli_select_db($conn, "messenger_system");

// Create users table
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    phone VARCHAR(15) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $sql)) {
    echo "Table 'users' created successfully or already exists.<br>";
} else {
    echo "Error creating table: " . mysqli_error($conn) . "<br>";
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Database Setup - Messenger System</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; }
        .success { color: green; }
        .error { color: red; }
        .btn { display: inline-block; padding: 10px 20px; margin: 10px 0; text-decoration: none; background: #007bff; color: white; border-radius: 5px; }
        .btn:hover { opacity: 0.8; }
    </style>
</head>
<body>
    <h1>Database Setup Complete</h1>
    <p>The database and tables have been set up for the Messenger System.</p>
    <a href="index.php" class="btn">Go to Homepage</a>
</body>
</html>
