<?php
// alelegend.php
// Consolidated DB + helpers. Include in pages with: require __DIR__ . '/alegend.php';

// IMPORTANT: session_start() must only be called once.
// We call it here, so it should be REMOVED from other files like login.php.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// DB connection (XAMPP default)
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'hotel_project';
$db_port = 3306;

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);
if ($conn->connect_error) {
    die('DB connection failed: ' . $conn->connect_error);
}
$conn->set_charset('utf8mb4');

// -- Helper functions -- //
function is_logged_in() {
    return !empty($_SESSION['user_id']);
}

function require_login() {
    if (!is_logged_in()) {
        header('Location: login.php');
        exit;
    }
}

// NEW: Admin Check with fallback for missing column
function is_admin($conn) {
    if (!is_logged_in()) return false;
    
    // Check if the 'is_admin' column exists before querying it
    $result = $conn->query("SHOW COLUMNS FROM users LIKE 'is_admin'");
    if (!$result || $result->num_rows === 0) {
        // Fallback: If the column is missing, no one is an admin (prevents Fatal Error)
        return false;
    }
    $result->free();

    // Now, safely check the admin status
    $stmt = $conn->prepare("SELECT is_admin FROM users WHERE id = ? LIMIT 1");
    if (!$stmt) return false;
    
    $stmt->bind_param('i', $_SESSION['user_id']);
    $stmt->execute();
    $stmt->bind_result($is_admin);
    $stmt->fetch();
    $stmt->close();
    
    return $is_admin == 1;
}


function e($s) {
    return htmlspecialchars($s, ENT_QUOTES|ENT_SUBSTITUTE, 'UTF-8');
}

// CSRF helpers (simple)
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(16));
}
function csrf_token() {
    return $_SESSION['csrf_token'];
}
function check_csrf($token) {
    return hash_equals($_SESSION['csrf_token'] ?? '', $token ?? '');
}

// Small utility that returns nights between two ISO dates
function nights_between($start, $end) {
    $d1 = new DateTime($start);
    $d2 = new DateTime($end);
    $interval = $d1->diff($d2);
    return max(0, (int)$interval->days);
}

// CORRECTED: Room availability check (returns true if room is free for given date range)
function room_is_available($conn, $roomNo, $start_date, $nights) {
    $checkout_date = (new DateTime($start_date))->add(new DateInterval('P' . $nights . 'D'))->format('Y-m-d');

    $query = "SELECT COUNT(*) AS cnt FROM Bookings
              WHERE Room_No = ?
                AND Start_Date < ? /* Existing booking starts before proposed checkout */
                AND DATE_ADD(Start_Date, INTERVAL Nights DAY) > ? /* Existing booking ends after proposed checkin */
              LIMIT 1";

    $stmt = $conn->prepare($query);
    if (!$stmt) return false;
    
    $stmt->bind_param('iss', $roomNo, $checkout_date, $start_date);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    return $count === 0;
}
?>