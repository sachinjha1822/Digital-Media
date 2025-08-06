<form method="post" action="update-address.php">
  <label>Shipping Address:</label>
  <textarea name="shipping_address"><?php echo htmlspecialchars($user['shipping_address']); ?></textarea>

  <label>Billing Address:</label>
  <textarea name="billing_address"><?php echo htmlspecialchars($user['billing_address']); ?></textarea>

  <button type="submit">Save Changes</button>
</form>
