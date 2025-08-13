<?php
$conn = new mysqli("localhost", "root", "", "oktours");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$bgResult = $conn->query("SELECT image_path FROM website_background ORDER BY uploaded_at DESC LIMIT 1");

$background = '';
if ($bgResult && $bgResult->num_rows > 0) {
    $row = $bgResult->fetch_assoc();
    $background = $row['image_path'];
}
?>
