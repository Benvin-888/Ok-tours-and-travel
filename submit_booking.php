<?php
// Database configuration
$host = 'localhost';
$db = 'oktours';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

// Error reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Initialize response array
$response = ['success' => false, 'message' => ''];

try {
    // Create database connection
    $conn = new mysqli($host, $user, $pass, $db);
    
    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Validate and sanitize inputs
    $required_fields = ['place', 'name', 'contact', 'email', 'id_number', 'num_people', 'num_days', 'travel_date'];
    
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            throw new Exception("Please fill in all required fields.");
        }
    }

    $place = htmlspecialchars(trim($_POST['place']));
    $name = htmlspecialchars(trim($_POST['name']));
    $contact = htmlspecialchars(trim($_POST['contact']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $id_number = htmlspecialchars(trim($_POST['id_number']));
    $num_people = intval($_POST['num_people']);
    $num_days = intval($_POST['num_days']);
    $travel_date = $_POST['travel_date'];

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Please enter a valid email address.");
    }

    // Validate numbers
    if ($num_people < 1 || $num_people > 50) {
        throw new Exception("Number of people must be between 1 and 50.");
    }

    if ($num_days < 1 || $num_days > 30) {
        throw new Exception("Duration must be between 1 and 30 days.");
    }

    // Validate date
    $today = new DateTime();
    $travelDate = new DateTime($travel_date);
    if ($travelDate < $today) {
        throw new Exception("Travel date cannot be in the past.");
    }

    // Prepare and execute SQL statement
    $stmt = $conn->prepare("INSERT INTO bookings 
                          (name, email, place, contact, id_number, num_people, num_days, travel_date) 
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sssssiis", 
                     $name, $email, $place, $contact, 
                     $id_number, $num_people, $num_days, 
                     $travel_date);

    if (!$stmt->execute()) {
        throw new Exception("Execution failed: " . $stmt->error);
    }

    // Success - redirect to thank you page
    $response['success'] = true;
    $response['redirect'] = 'thankyou.html';
    
    // Close connections
    $stmt->close();
    $conn->close();

    // Send JSON response for AJAX or redirect for normal form submission
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        echo json_encode($response);
        exit();
    } else {
        header("Location: thankyou.html");
        exit();
    }

} catch (Exception $e) {
    // Error handling
    $response['message'] = $e->getMessage();
    
    // For AJAX requests
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        echo json_encode($response);
        exit();
    } else {
        // For regular form submission
        die("Error: " . $e->getMessage());
    }
}