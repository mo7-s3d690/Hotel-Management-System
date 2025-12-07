<?php
// Booking.php
require __DIR__ . '/alegend.php';
require_login();

// fetch rooms (simple list)
$rooms = [];
$res = $conn->query("SELECT roomNo, room_type, capacity, Price_per_night, status, description FROM Rooms ORDER BY roomNo ASC");
if ($res) {
    while ($r = $res->fetch_assoc()) $rooms[] = $r;
    $res->free();
}

// flash messages
$flash_error = $_SESSION['flash_error'] ?? '';
$flash_success = $_SESSION['flash_success'] ?? '';
unset($_SESSION['flash_error'], $_SESSION['flash_success']);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Bookings | MN'S</title>
 <link rel="stylesheet" href="style4.css">
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css">
</head>
<body>
  <div class="card">
    <h2>Book a room</h2>

    <?php if ($flash_success): ?>
      <div class="alert success"><?= e($flash_success) ?></div>
    <?php endif; ?>
    <?php if ($flash_error): ?>
      <div class="alert error"><?= e($flash_error) ?></div>
    <?php endif; ?>

    <form id="bookingForm" method="POST" action="create_booking.php">
      <label for="dateRange">Check-in and Check-out Dates:</label>
      <input type="text" id="dateRange" name="dateRange" placeholder="Select Date Range" required>

      <label for="payment_type">Payment Type:</label>
      <select id="payment_type" name="payment_type" required>
        <option value="">Select Payment Type</option>
        <option value="Cash">Cash</option>
        <option value="Visa">Visa</option>
        <option value="InstaPay">InstaPay</option>
        <option value="PayPal">PayPal</option>
      </select>
      
      <label for="roomNo">Select Room:</label>
      <select id="roomNo" name="roomNo" class="room-select" required>
        <option value="">Select a Room</option>
        <?php foreach($rooms as $r): ?>
          <option value="<?= e($r['roomNo']) ?>">
            <?= e($r['roomNo']) . ' - ' . e($r['room_type']) . ' - ' . e($r['capacity']) . 'p - $' . e($r['Price_per_night']) . ' /night (' . e($r['status']) . ')' ?>
          </option>
        <?php endforeach; ?>
      </select>

      <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
      <button type="submit">Book</button>
    </form>

    <p class="muted">Logged in as <?= e($_SESSION['fullname']) ?> — <a href="logout.php">Logout</a></p>
    
    <?php if (is_admin($conn)): ?>
      <p class="muted">Admin Panel: <a href="admin_bookings.php">View All Bookings</a></p>
    <?php endif; ?>

    <h3>Your bookings</h3>
    <ul>
      <?php
      $uid = $_SESSION['user_id'];
      // FIXED QUERY: Fetches bookings linked to the user_id
      $stmt = $conn->prepare("SELECT Booking_ID, Start_Date, Nights, Price, Room_No, Booking_Date FROM Bookings WHERE user_id = ? ORDER BY Booking_Date DESC LIMIT 50");
      
      if ($stmt) {
          $stmt->bind_param('i', $uid); // Bind the user_id
          $stmt->execute();
          $stmt->bind_result($bid,$sdate,$nights,$price,$rno,$bdate);
          while ($stmt->fetch()) {
              echo '<li>'.e($bdate).' - Room '.e($rno).' from '.e($sdate).' for '.e($nights).' nights. Price: $'.e($price).'</li>';
          }
          $stmt->close();
      } else {
          echo '<li>Error fetching bookings.</li>';
      }
      ?>
    </ul>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Initialize Flatpickr on the dateRange input
      flatpickr("#dateRange", {
        mode: "range",
        minDate: "today",
        dateFormat: "Y-m-d", // Matches the format expected by PHP
        disableMobile: true 
      });
    });
  </script>
</body>
</html>