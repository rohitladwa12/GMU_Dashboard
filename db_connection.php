<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database configuration
$db_host = 'localhost';
$db_user = 'root';  // Default XAMPP username
$db_pass = '';      // Default XAMPP password
$db_name = 'gmu';

// Create connection with error handling
try {
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
    
    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Set charset to utf8mb4
    if (!$conn->set_charset("utf8mb4")) {
        throw new Exception("Error setting charset: " . $conn->error);
    }

    // Set timezone
    $conn->query("SET time_zone = '+05:30'");  // Indian timezone

    // Test the connection
    if (!$conn->ping()) {
        throw new Exception("Database server has gone away");
    }

} catch (Exception $e) {
    // Log error and return JSON error response
    error_log("Database connection error: " . $e->getMessage());
    header('Content-Type: application/json');
    die(json_encode([
        "error" => true,
        "message" => "Database connection failed. Please try again later.",
        "debug" => $e->getMessage(),
        "connection_info" => [
            "host" => $db_host,
            "database" => $db_name,
            "connected" => isset($conn) ? $conn->ping() : false
        ]
    ]));
}
?> 