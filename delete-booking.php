<?php
$conn = new mysqli("localhost", "root", "", "oktours");

// Check for connection error
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
  $id = intval($_GET['id']); // Sanitize ID

  // Prepare the statement
  $stmt = $conn->prepare("DELETE FROM bookings WHERE id = ?");
  $stmt->bind_param("i", $id);

  if ($stmt->execute()) {
    // Optional: success message (can be passed in redirect)
  } else {
    echo "Error deleting booking: " . $conn->error;
  }

  $stmt->close();
}

// Redirect back to admin booking page
header("Location: bookings.php"); // or wherever the admin views bookings
exit();
?>
