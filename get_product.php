<?php
require_once 'config.php';

header('Content-Type: application/json');

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Product ID is required']);
    exit;
}

$productId = $_GET['id'];

try {
    $stmt = $pdo->prepare("SELECT p.*, c.name as category_name 
                          FROM products p 
                          JOIN categories c ON p.category_id = c.id 
                          WHERE p.id = ?");
    $stmt->execute([$productId]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$product) {
        http_response_code(404);
        echo json_encode(['error' => 'Product not found']);
        exit;
    }
    
    // Process images and specifications from JSON
    $product['images'] = json_decode($product['images'], true);
    $product['specifications'] = json_decode($product['specifications'], true);
    $product['category_id'] = str_replace(' ', '-', strtolower($product['category_name']));
    
    echo json_encode($product);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}