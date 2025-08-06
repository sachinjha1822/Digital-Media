<?php
session_start();
require_once 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_new_password = $_POST['confirm_new_password'] ?? '';

    if (empty($current_password) || empty($new_password) || empty($confirm_new_password)) {
        $_SESSION['error'] = "Please fill in all password fields.";
        header("Location: account.php");
        exit();
    }

    if ($new_password !== $confirm_new_password) {
        $_SESSION['error'] = "New password and confirmation do not match.";
        header("Location: account.php");
        exit();
    }

    if (strlen($new_password) < 6) {
        $_SESSION['error'] = "New password must be at least 6 characters.";
        header("Location: account.php");
        exit();
    }

    try {
        // Fetch current password hash
        $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($current_password, $user['password'])) {
            $_SESSION['error'] = "Current password is incorrect.";
            header("Location: account.php");
            exit();
        }

        // Update password
        $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->execute([$new_password_hash, $user_id]);

        $_SESSION['success'] = "Password changed successfully.";
        header("Location: account.php");
        exit();

    } catch (PDOException $e) {
        error_log("Password change error: " . $e->getMessage());
        $_SESSION['error'] = "Failed to change password. Try again later.";
        header("Location: account.php");
        exit();
    }

} else {
    header("Location: account.php");
    exit();
}
?>