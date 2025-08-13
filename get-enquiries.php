<?php
$host = 'localhost';
$db = 'oktours';
$user = 'root';
$pass = '';

header('Content-Type: application/json');

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT id, name, phone, message, status FROM enquiries ORDER BY created_at DESC");
    $enquiries = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($enquiries);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}
?>
