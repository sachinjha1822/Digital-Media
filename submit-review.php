<?php
session_start();

// Database connection
$db = new mysqli('localhost', 'username', 'password', 'digital_media');

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input
    $product_id = intval($_POST['product_id']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $rating = intval($_POST['rating']);
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    
    // Basic validation
    $errors = [];
    
    if (empty($product_id) || $product_id <= 0) {
        $errors[] = "Invalid product";
    }
    
    if (empty($name)) {
        $errors[] = "Name is required";
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required";
    }
    
    if ($rating < 1 || $rating > 5) {
        $errors[] = "Please select a valid rating";
    }
    
    if (empty($title)) {
        $errors[] = "Review title is required";
    }
    
    if (empty($content)) {
        $errors[] = "Review content is required";
    }
    
    // If no errors, insert review
    if (empty($errors)) {
        $stmt = $db->prepare("INSERT INTO reviews (product_id, author_name, author_email, rating, title, content) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ississ", $product_id, $name, $email, $rating, $title, $content);
        
        if ($stmt->execute()) {
            // Update product rating and review count
            $update_stmt = $db->prepare("
                UPDATE products 
                SET 
                    rating = (SELECT AVG(rating) FROM reviews WHERE product_id = ?),
                    review_count = (SELECT COUNT(*) FROM reviews WHERE product_id = ?)
                WHERE id = ?
            ");
            $update_stmt->bind_param("iii", $product_id, $product_id, $product_id);
            $update_stmt->execute();
            
            $_SESSION['review_success'] = true;
            header("Location: product-details.php?id=" . $product_id);
            exit();
        } else {
            $errors[] = "Failed to submit review. Please try again.";
        }
    }
    
    // If there were errors, store them in session and redirect back
    $_SESSION['review_errors'] = $errors;
    $_SESSION['review_data'] = [
        'name' => $name,
        'email' => $email,
        'rating' => $rating,
        'title' => $title,
        'content' => $content
    ];
    header("Location: product-details.php?id=" . $product_id . "#review-form");
    exit();
}

// If not a POST request, redirect to home
header("Location: index.php");
exit();
?>