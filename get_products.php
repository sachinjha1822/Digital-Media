<?php
require_once 'config.php';

header('Content-Type: application/json');

$category = isset($_GET['category']) ? $_GET['category'] : null;

try {
    if ($category) {
        $categoryName = str_replace('-', ' ', $category);
        $stmt = $pdo->prepare("SELECT p.*, c.name as category_name 
                              FROM products p 
                              JOIN categories c ON p.category_id = c.id 
                              WHERE c.name = ?");
        $stmt->execute([$categoryName]);
    } else {
        $stmt = $pdo->query("SELECT p.*, c.name as category_name 
                            FROM products p 
                            JOIN categories c ON p.category_id = c.id");
    }
    
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Process images and specifications from JSON
    foreach ($products as &$product) {
        $product['images'] = json_decode($product['images'], true);
        $product['specifications'] = json_decode($product['specifications'], true);
        $product['category_id'] = str_replace(' ', '-', strtolower($product['category_name']));
    }
    
    echo json_encode($products);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}