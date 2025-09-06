<?php
// add_to_cart.php
require_once 'config.php';

header('Content-Type: application/json');

$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['package_id'], $data['destination'], $data['start_date'], $data['end_date'], $data['travelers'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

try {
    // Get package price
    $stmt = $pdo->prepare("SELECT base_price FROM tour_packages WHERE package_id = :package_id");
    $stmt->bindParam(':package_id', $data['package_id'], PDO::PARAM_INT);
    $stmt->execute();
    $package = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$package) {
        echo json_encode(['success' => false, 'message' => 'Package not found']);
        exit;
    }
    
    $price_per_person = $package['base_price'];
    $subtotal = $price_per_person * $data['travelers'];
    
    // Insert into cart
    $stmt = $pdo->prepare("
        INSERT INTO user_cart (user_id, package_id, destination, start_date, end_date, travelers, price_per_person, subtotal)
        VALUES (:user_id, :package_id, :destination, :start_date, :end_date, :travelers, :price_per_person, :subtotal)
    ");
    
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':package_id', $data['package_id'], PDO::PARAM_INT);
    $stmt->bindParam(':destination', $data['destination']);
    $stmt->bindParam(':start_date', $data['start_date']);
    $stmt->bindParam(':end_date', $data['end_date']);
    $stmt->bindParam(':travelers', $data['travelers'], PDO::PARAM_INT);
    $stmt->bindParam(':price_per_person', $price_per_person);
    $stmt->bindParam(':subtotal', $subtotal);
    
    $stmt->execute();
    $cart_id = $pdo->lastInsertId();
    
    // Add extras if any
    if (!empty($data['extras'])) {
        foreach ($data['extras'] as $extra) {
            $stmt = $pdo->prepare("
                INSERT INTO cart_extras (cart_id, extra_name, extra_price)
                VALUES (:cart_id, :extra_name, :extra_price)
            ");
            $stmt->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
            $stmt->bindParam(':extra_name', $extra['name']);
            $stmt->bindParam(':extra_price', $extra['price']);
            $stmt->execute();
            
            // Update subtotal with extra price
            $subtotal += $extra['price'];
        }
        
        // Update cart with new subtotal
        $stmt = $pdo->prepare("UPDATE user_cart SET subtotal = :subtotal WHERE cart_id = :cart_id");
        $stmt->bindParam(':subtotal', $subtotal);
        $stmt->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
        $stmt->execute();
    }
    
    echo json_encode(['success' => true, 'cart_id' => $cart_id, 'message' => 'Item added to cart']);
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Failed to add item to cart']);
}
?>