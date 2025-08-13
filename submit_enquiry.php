<?php
$host = 'localhost';
$db = 'oktours';
$user = 'root';       // Change if you use a different MySQL user
$pass = '';           // Add password if set

header('Content-Type: application/json');

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Read input data
    $data = json_decode(file_get_contents("php://input"), true);

    $name = trim($data['name'] ?? '');
    $phone = trim($data['phone'] ?? '');
    $message = trim($data['message'] ?? '');

    if (empty($name) || empty($phone)) {
        http_response_code(400);
        echo json_encode(['error' => 'Name and phone are required']);
        exit;
    }

    $stmt = $pdo->prepare("INSERT INTO enquiries (name, phone, message) VALUES (?, ?, ?)");
    $stmt->execute([$name, $phone, $message]);

    echo json_encode(['success' => true]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}
?>
