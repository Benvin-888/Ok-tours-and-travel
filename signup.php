<?php
require 'db.php';

// Enable error reporting for debugging (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

// Collect and sanitize input
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirmPassword = $_POST['confirm-password'] ?? '';
$id_number = trim($_POST['id'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$profilePhoto = NULL; // optional, can be updated later if file upload is implemented

// Validate inputs
if (empty($name) || empty($email) || empty($password) || empty($confirmPassword) || empty($id_number) || empty($phone)) {
    echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid email format']);
    exit();
}

if ($password !== $confirmPassword) {
    echo json_encode(['status' => 'error', 'message' => 'Passwords do not match']);
    exit();
}

// Check if email already exists
try {
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Email already registered']);
        exit();
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database query failed', 'error' => $e->getMessage()]);
    exit();
}

// Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert user
try {
    $stmt = $pdo->prepare("INSERT INTO users (name, id_number, phone, email, password, profile_photo, created_at)
                           VALUES (?, ?, ?, ?, ?, ?, NOW())");
    $stmt->execute([$name, $id_number, $phone, $email, $hashedPassword, $profilePhoto]);

    echo json_encode(['status' => 'success', 'message' => 'Sign up successful']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to register user', 'error' => $e->getMessage()]);
}
?>
