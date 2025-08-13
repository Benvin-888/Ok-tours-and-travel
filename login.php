<?php
session_start();

// Database connection
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'oktours';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die(json_encode(['status' => 'error', 'message' => 'Database connection failed']));
}

// Get form data
$emailOrUsername = trim($_POST['email'] ?? $_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$isAdminLogin = isset($_POST['username']); // Determine login type

if (empty($emailOrUsername) || empty($password)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Please enter both ' . ($isAdminLogin ? 'username' : 'email') . ' and password.'
    ]);
    exit();
}

if ($isAdminLogin) {
    // Admin login
    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->bind_param("s", $emailOrUsername);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($admin = $result->fetch_assoc()) {
        // Note: You should hash admin passwords too!
        if ($password === $admin['password']) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $admin['username'];
            echo json_encode(['status' => 'success', 'redirect' => 'admin-dashboard.php']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid admin credentials']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Admin not found']);
    }

} else {
    // User login
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $emailOrUsername);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_logged_in'] = true;
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name'] = $user['name'];

            echo json_encode([
                'status' => 'success',
                'user' => [
                    'email' => $user['email'],
                    'name' => $user['name'],
                    'profile_photo' => $user['profile_photo'] ?? ''
                ]
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Incorrect password']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'User not found']);
    }
}

$conn->close();
?>
