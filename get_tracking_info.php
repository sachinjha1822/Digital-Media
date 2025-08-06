<?php
// get_tracking_info.php

require_once 'includes/db.php';

// Validate request
if (!isset($_GET['order_id']) || !is_numeric($_GET['order_id'])) {
    echo json_encode(['success' => false, 'error' => 'Invalid order ID']);
    exit();
}

$order_id = (int)$_GET['order_id'];

// Fetch tracking info from database
try {
    $stmt = $pdo->prepare("
        SELECT 
            ot.status,
            ot.tracking_number,
            ot.carrier,
            ot.tracking_url,
            ot.history,
            ot.updated_at
        FROM order_tracking ot
        WHERE ot.order_id = ?
    ");
    $stmt->execute([$order_id]);
    $trackingInfo = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$trackingInfo) {
        echo json_encode(['success' => false, 'error' => 'Tracking information not found']);
        exit();
    }

    // Decode history if it exists
    $history = [];
    if (!empty($trackingInfo['history'])) {
        $history = json_decode($trackingInfo['history'], true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $history = [];
        }
    }

    // Prepare response
    $response = [
        'success' => true,
        'tracking_info' => [
            'status' => $trackingInfo['status'],
            'tracking_number' => $trackingInfo['tracking_number'],
            'carrier' => $trackingInfo['carrier'],
            'tracking_url' => $trackingInfo['tracking_url'],
            'history' => $history,
            'last_updated' => $trackingInfo['updated_at']
        ]
    ];

    echo json_encode($response);
    
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'Database error']);
}