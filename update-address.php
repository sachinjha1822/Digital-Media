<?php
session_start();
require 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Build Shipping Address JSON
$shipping = json_encode([
    'address_line1' => $_POST['shipping_line1'] ?? '',
    'address_line2' => $_POST['shipping_line2'] ?? '',
    'city'          => $_POST['shipping_city'] ?? '',
    'state'         => $_POST['shipping_state'] ?? '',
    'zip_code'      => $_POST['shipping_zip'] ?? '',
    'country'       => $_POST['shipping_country'] ?? ''
]);

// Build Billing Address JSON
$billing = json_encode([
    'address_line1' => $_POST['billing_line1'] ?? '',
    'address_line2' => $_POST['billing_line2'] ?? '',
    'city'          => $_POST['billing_city'] ?? '',
    'state'         => $_POST['billing_state'] ?? '',
    'zip_code'      => $_POST['billing_zip'] ?? '',
    'country'       => $_POST['billing_country'] ?? ''
]);

try {
    // Update database
    $sql = "UPDATE users SET shipping_address = ?, billing_address = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$shipping, $billing, $userId]);

    $_SESSION['success'] = "Addresses updated successfully!";
} catch (Exception $e) {
    $_SESSION['error'] = "Error updating addresses: " . $e->getMessage();
}

header("Location: account.php");
exit();
?>
