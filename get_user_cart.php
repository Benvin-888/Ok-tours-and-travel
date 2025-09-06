<?php
// get_tour_packages.php
require_once 'config.php';

header('Content-Type: application/json');

try {
    $stmt = $pdo->query("SELECT * FROM tour_packages WHERE is_active = TRUE");
    $packages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode(['success' => true, 'packages' => $packages]);
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Failed to fetch packages']);
}
?>