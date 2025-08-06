<?php
session_start();
require_once 'includes/db.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['order_id'])) {
    header("Location: login.php");
    exit();
}

$order_id = $_GET['order_id'];
$user_id = $_SESSION['user_id'];

// Verify order belongs to user and is returnable
$stmt = $pdo->prepare("
    SELECT id FROM orders 
    WHERE id = ? AND user_id = ? AND status = 'Delivered'
");
$stmt->execute([$order_id, $user_id]);
$order = $stmt->fetch();

if (!$order) {
    $_SESSION['error'] = 'Order not found or cannot be returned';
    header("Location: account.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reason = trim($_POST['reason']);
    $details = trim($_POST['details']);
    
    if (empty($reason)) {
        $_SESSION['error'] = 'Please select a return reason';
    } else {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO returns 
                (order_id, user_id, reason, details, status, requested_at)
                VALUES (?, ?, ?, ?, 'Pending', NOW())
            ");
            $stmt->execute([$order_id, $user_id, $reason, $details]);
            
            // Add status history
            $stmt = $pdo->prepare("
                INSERT INTO order_status_history 
                (order_id, status, notes)
                VALUES (?, 'Return Requested', ?)
            ");
            $stmt->execute([$order_id, "Return requested. Reason: $reason"]);
            
            $_SESSION['success'] = 'Return request submitted successfully';
            header("Location: order_details.php?id=$order_id");
            exit();
        } catch (PDOException $e) {
            $_SESSION['error'] = 'Database error: ' . $e->getMessage();
        }
    }
}

$pageTitle = 'Request Return - Digital Media';
include('header.php');
?>

<div class="container">
    <div class="return-request-form" style="max-width: 600px; margin: 40px auto;">
        <h1>Request Return for Order #<?php echo htmlspecialchars($order_id); ?></h1>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group" style="margin-bottom: 20px;">
                <label for="reason" style="display: block; margin-bottom: 8px; font-weight: 500;">Reason for Return</label>
                <select id="reason" name="reason" class="form-control" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                    <option value="">Select a reason</option>
                    <option value="Wrong Item">Wrong Item</option>
                    <option value="Damaged/Defective">Damaged/Defective</option>
                    <option value="Not as Described">Not as Described</option>
                    <option value="No Longer Needed">No Longer Needed</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            
            <div class="form-group" style="margin-bottom: 20px;">
                <label for="details" style="display: block; margin-bottom: 8px; font-weight: 500;">Additional Details</label>
                <textarea id="details" name="details" rows="4" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;"></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary" style="padding: 10px 20px; background-color: #F37254; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Submit Return Request
            </button>
            
            <a href="order_details.php?id=<?php echo $order_id; ?>" class="btn btn-outline" style="padding: 10px 20px; margin-left: 10px; border: 1px solid #F37254; color: #F37254; border-radius: 4px; text-decoration: none;">
                Cancel
            </a>
        </form>
    </div>
</div>

<?php include('footer.php'); ?>