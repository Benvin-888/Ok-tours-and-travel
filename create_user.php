<?php
// DB connection
$host = "localhost";
$user = "root";
$password = ""; // change if needed
$database = "oktours";

$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get submitted data
$name = $_POST['name'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure hash
$id_number = $_POST['id_number'];
$phone = $_POST['phone'];
$created_at = date("Y-m-d H:i:s");

// Handle file upload
$targetDir = "uploads/";
$profilePhoto = $_FILES["profile_photo"]["name"];
$targetFile = $targetDir . time() . "_" . basename($profilePhoto);

if (move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $targetFile)) {
    // Insert into users table
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, profile_photo, id_number, phone, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $name, $email, $password, $targetFile, $id_number, $phone, $created_at);

    if ($stmt->execute()) {
        echo "User created successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Error uploading profile photo.";
}

$conn->close();
?>
