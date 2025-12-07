<?php
require __DIR__ . '/alegend.php';

// SECURITY: Ensure user is logged in
require_login(); 

// SECURITY: Ensure user is an admin
if (!is_admin($conn)) {
    $_SESSION['flash_error'] = "Access denied. Only administrators can view this page.";
    header('Location: Booking.php'); // Redirect non-admins
    exit;
}

// Simple list of all bookings for testing
$stmt = $conn->prepare("SELECT 
    b.Booking_ID, b.Start_Date, b.Nights, b.Price, b.Room_No, b.Booking_Date, u.fullname AS user_fullname
FROM Bookings b
LEFT JOIN users u ON b.user_id = u.id
ORDER BY b.Booking_Date DESC LIMIT 200");
$stmt->execute();
// Added $u for user_fullname
$stmt->bind_result($id,$s,$n,$p,$r,$b,$u); 
$rows = [];
while ($stmt->fetch()) $rows[] = compact('id','s','n','p','r','b','u');
$stmt->close();
?>
<!doctype html><html><head><meta charset="utf-8"><title>Admin Bookings</title></head><body>
<h2>Bookings (admin)</h2>
<table border="1" cellpadding="6">
  <tr><th>ID</th><th>User</th><th>Booking Date</th><th>Check-in</th><th>Nights</th><th>Room</th><th>Price</th></tr>
  <?php foreach($rows as $row): ?>
    <tr>
      <td><?= e($row['id']) ?></td>
      <td><?= e($row['u'] ?? 'Guest/Unknown') ?></td>
      <td><?= e($row['b']) ?></td>
      <td><?= e($row['s']) ?></td>
      <td><?= e($row['n']) ?></td>
      <td><?= e($row['r']) ?></td>
      <td><?= e($row['p']) ?></td>
    </tr>
  <?php endforeach; ?>
</table>
<p><a href="Booking.php">Back to Booking Page</a></p>
</body></html>