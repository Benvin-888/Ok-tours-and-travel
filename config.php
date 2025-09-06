<?php
// config.php - Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'oktours');
define('DB_USER', 'root');
define('DB_PASS', '');

try {
    $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Start session for user tracking
session_start();
if (!isset($_SESSION['user_id'])) {
    // For demo purposes, set a default user ID
    $_SESSION['user_id'] = 1;
}
?>