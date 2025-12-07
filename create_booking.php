<?php
// create_booking.php
require __DIR__ . '/alegend.php';

// Must be logged in to create a booking
require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "Method not allowed";
    exit;
}

// CSRF check
if (!check_csrf($_POST['csrf_token'] ?? '')) {
    http_response_code(400);
    echo "Invalid CSRF token";
    exit;
}

// Gather input
$dateRange = trim($_POST['dateRange'] ?? '');
$roomNo = intval($_POST['roomNo'] ?? 0);
$payment = $_POST['payment_type'] ?? 'Pending';

// parse dateRange expecting "YYYY-MM-DD to YYYY-MM-DD" from Flatpickr
$parts = array_map('trim', explode(' to ', $dateRange));
if (count($parts) !== 2) {
    $_SESSION['flash_error'] = "Invalid date range format. Please use the date picker.";
    header('Location: Booking.php');
    exit;
}

list($start, $end) = $parts;

if (!DateTime::createFromFormat('Y-m-d', $start) || !DateTime::createFromFormat('Y-m-d', $end)) {
    $_SESSION['flash_error'] = "Invalid date format submitted.";
    header('Location: Booking.php');
    exit;
}

$nights = nights_between($start, $end);
if ($nights <= 0) {
    $_SESSION['flash_error'] = "Check-out date must be after check-in date.";
    header('Location: Booking.php');
    exit;
}

// Price calc (simple: get Price_per_night)
$price = 0.0;
$pr = $conn->prepare("SELECT Price_per_night FROM Rooms WHERE roomNo = ? LIMIT 1");
$pr->bind_param('i', $roomNo);
$pr->execute();
$pr->bind_result($ppn);
if ($pr->fetch()) {
    $price = (float)$ppn * $nights;
}
$pr->close();

// Availability check 
if (!room_is_available($conn, $roomNo, $start, $nights)) {
    $_SESSION['flash_error'] = "Room is not available for the chosen dates. Please choose another.";
    header('Location: Booking.php');
    exit;
}

// Insert booking - UPDATED to include user_id and set optional fields to NULL
$uid = $_SESSION['user_id']; 
$null = NULL; 

$ins = $conn->prepare("INSERT INTO Bookings (user_id, Start_Date, Booking_Date, Payment_Type, Nights, Price, `G-ssn`, `AG-ID`, `M-ID`, Room_No)
                       VALUES (?, ?, NOW(), ?, ?, ?, ?, ?, ?, ?)");
if (!$ins) {
    $_SESSION['flash_error'] = "DB error: could not prepare insert statement.";
    header('Location: Booking.php');
    exit;
}

// FIX: Correct type string (9 characters for 9 variables)
// i (uid), s (Start), s (Payment), i (Nights), d (Price), s (G-ssn), s (AG-ID), s (M-ID), i (RoomNo)
$ins->bind_param('issdisssi', $uid, $start, $payment, $nights, $price, $null, $null, $null, $roomNo);
$ok = $ins->execute();
if ($ok) {
    $_SESSION['flash_success'] = "Booking successful! Total Price: $" . number_format($price, 2);
} else {
    $_SESSION['flash_error'] = "Booking failed due to a database error: " . $conn->error;
}

header('Location: Booking.php');
exit;
?>