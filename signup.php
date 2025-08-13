<?php
require 'db.php';

header(header: 'Content-Type: application/json');

$name = trim($_POST['name'] ?? '');
$email = trim(string: $_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirmPassword = $_POST['confirm-password'] ?? '';
$id_number = trim(string: $_POST['id'] ?? '');
$phone = trim(string: $_POST['phone'] ?? '');
$profilePhoto = ''; // Placeholder for future photo upload support

// Validate inputs
if (empty($name) || empty($email) || empty($password) || empty($confirmPassword) || empty($id_number) || empty($phone)) {
    echo json_encode(value: ['status' => 'error', 'message' => 'All fields are required']);
    exit();
}

if ($password !== $confirmPassword) {
    echo json_encode(value: ['status' => 'error', 'message' => 'Passwords do not match']);
    exit();
}

// Check if email exists
$stmt = $pdo->prepare(query: "SELECT id FROM users WHERE email = ?");
$stmt->execute(params: [$email]);

if ($stmt->rowCount() > 0) {
    echo json_encode(value: ['status' => 'error', 'message' => 'Email already registered']);
    exit();
}

// Insert user
$hashedPassword = password_hash(password: $password, algo: PASSWORD_DEFAULT);

$stmt = $pdo->prepare(query: "INSERT INTO users (name, id_number, phone, email, password, profile_photo, created_at)
                       VALUES (?, ?, ?, ?, ?, ?, NOW())");

if ($stmt->execute(params: [$name, $id_number, $phone, $email, $hashedPassword, $profilePhoto])) {
    echo json_encode(value: ['status' => 'success', 'message' => 'Sign up successful']);
} else {
    echo json_encode(value: ['status' => 'error', 'message' => 'Failed to register user']);
}
?>
