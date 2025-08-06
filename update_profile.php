<?php
session_start();
require_once 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $phone = trim($_POST['phone'] ?? '');

    // Basic validation
    if (empty($first_name) || empty($last_name)) {
        $_SESSION['error'] = "First and last name are required.";
        header("Location: account.php");
        exit();
    }

    // Handle file upload
    $avatarPath = null;
    if (!empty($_FILES['avatar']['name'])) {
        $uploadDir = 'assets/images/avatars/';
        
        // Create directory if it doesn't exist
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $fileExtension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
        $fileName = 'user_' . $user_id . '_' . time() . '.' . $fileExtension;
        $targetPath = $uploadDir . $fileName;
        
        // Check if file is an image
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $fileType = $_FILES['avatar']['type'];
        $maxFileSize = 2 * 1024 * 1024; // 2MB
        
        if (!in_array($fileType, $allowedTypes)) {
            $_SESSION['error'] = "Only JPG, PNG, GIF, and WEBP images are allowed.";
            header("Location: account.php");
            exit();
        }
        
        if ($_FILES['avatar']['size'] > $maxFileSize) {
            $_SESSION['error'] = "Image size must be less than 2MB.";
            header("Location: account.php");
            exit();
        }
        
        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $targetPath)) {
            $avatarPath = $targetPath;
            
            // Delete old avatar if it exists and isn't the default
            $stmt = $pdo->prepare("SELECT avatar FROM users WHERE id = ?");
            $stmt->execute([$user_id]);
            $oldAvatar = $stmt->fetchColumn();
            
            if ($oldAvatar && $oldAvatar !== './assets/images/profile-avatar.jpg' && file_exists($oldAvatar)) {
                unlink($oldAvatar);
            }
        } else {
            $_SESSION['error'] = "Failed to upload image. Please try again.";
            header("Location: account.php");
            exit();
        }
    }

    try {
        if ($avatarPath) {
            $stmt = $pdo->prepare("UPDATE users SET first_name = ?, last_name = ?, phone = ?, avatar = ? WHERE id = ?");
            $stmt->execute([$first_name, $last_name, $phone, $avatarPath, $user_id]);
        } else {
            $stmt = $pdo->prepare("UPDATE users SET first_name = ?, last_name = ?, phone = ? WHERE id = ?");
            $stmt->execute([$first_name, $last_name, $phone, $user_id]);
        }
        
        $_SESSION['success'] = "Profile updated successfully!";
        header("Location: account.php");
        exit();

    } catch (PDOException $e) {
        error_log("Profile update error: " . $e->getMessage());
        $_SESSION['error'] = "Failed to update profile. Try again later.";
        header("Location: account.php");
        exit();
    }
} else {
    header("Location: account.php");
    exit();
}