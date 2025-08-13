<?php
$host = 'localhost';
$db = 'oktours';
$user = 'root';
$pass = '';

header('Content-Type: application/json');

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $data = json_decode(file_get_contents("php://input"), true);
    $id = intval($data['id']);
    $newStatus = $data['status'] === 'resolved' ? 'resolved' : 'pending';

    $stmt = $pdo->prepare("UPDATE enquiries SET status = ? WHERE id = ?");
    $stmt->execute([$newStatus, $id]);

    echo json_encode(['success' => true]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Server error: ' . $e->getMessage()]);
}
?>
