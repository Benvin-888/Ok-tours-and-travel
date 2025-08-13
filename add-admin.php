<?php include 'get_background.php'; ?>

<?php
session_start();

// Database connection
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'oktours';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get form data
$mainUsername = $_POST['mainAdminUsername'] ?? '';
$mainPassword = $_POST['mainAdminPassword'] ?? '';
$newUsername = $_POST['newAdminUsername'] ?? '';
$newPassword = $_POST['newAdminPassword'] ?? '';

// Check if required fields are present
if (empty($mainUsername) || empty($mainPassword) || empty($newUsername) || empty($newPassword)) {
  echo "<script>alert('Please fill in all required fields.'); window.location.href='admin-add-admin.html';</script>";
  exit();
}

// Verify main admin
$checkQuery = "SELECT * FROM admins WHERE username = ?";
$stmt = $conn->prepare($checkQuery);
$stmt->bind_param("s", $mainUsername);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
  $admin = $result->fetch_assoc();

  if ($mainPassword === $admin['password']) {
    // Insert new admin
    $insertQuery = "INSERT INTO admins (username, password) VALUES (?, ?)";
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bind_param("ss", $newUsername, $newPassword);

    if ($insertStmt->execute()) {
      echo "<script>alert('New admin added successfully.'); window.location.href='admin-add-admin.php';</script>";
    } else {
      echo "<script>alert('Failed to add new admin.'); window.location.href='admin-add-admin.php';</script>";
    }

    $insertStmt->close();
  } else {
    echo "<script>alert('Main admin password is incorrect.'); window.location.href='admin-add-admin.php';</script>";
  }
} else {
  echo "<script>alert('Main admin username not found.'); window.location.href='admin-add-admin.php';</script>";
}

$stmt->close();
$conn->close();
?>
