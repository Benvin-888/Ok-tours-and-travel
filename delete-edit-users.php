<?php
// delete-edit-users.php

$conn = new mysqli("localhost", "root", "", "oktours");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// DELETE OPERATION
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM users WHERE id=$id");
    header("Location: manage-users.php");
    exit;
}

// UPDATE OPERATION
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_id'])) {
    $id = intval($_POST['update_id']);
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $id_number = $conn->real_escape_string($_POST['id_number']);

    $conn->query("UPDATE users SET name='$name', email='$email', phone='$phone', id_number='$id_number' WHERE id=$id");
    header("Location: manage-users.php");
    exit;
}
?>
