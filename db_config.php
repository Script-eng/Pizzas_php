<?php
// Database configuration
$host = 'localhost';
$dbname = 'pizzeria_db';
$username = 'root';
$password = '';

try {
    // Create a PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set error mode to exception for debugging
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle connection errors
    die("Database connection failed: " . $e->getMessage());
}
?>
