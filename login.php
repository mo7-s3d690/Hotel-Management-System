<?php
// REMOVED: session_start();
require __DIR__ . '/alegend.php';

$error = ''; 
$registered = isset($_GET['registered']); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? ''); 
    $password = $_POST['password'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
        $error = 'Please enter email and password.';
    } else {
        // Updated to select 'is_admin' column for the check in Booking.php
        $stmt = $conn->prepare('SELECT id, fullname, password, is_admin FROM users WHERE email = ? LIMIT 1');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows === 1) { 
            $stmt->bind_result( $id, $fullname, $hash, $is_admin);
            $stmt->fetch();
            if (password_verify($password, $hash)) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = $id;
                $_SESSION['fullname'] = $fullname;
                // Since 'is_admin' is now selected, it will work with the check in alegend.php
                header('Location: Booking.php?login=success');
                exit;
            } else {
                $error = 'Invalid credentials.';
            }
        } else {
            $error = 'Invalid credentials.';
        }
        $stmt->close();
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Login | MN'S</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="card">
    <h2>Login</h2>

    <?php if ($registered): ?>
      <div class="alert success">Registered successfully. Please login.</div>
    <?php endif; ?>

    <?php if ($error): ?>
      <div class="alert error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="login.php" method="POST">
      <input type="email" name="email" placeholder="Email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>

    <p class="muted">Don't have an account? <a href="register.php" style="color:#cfefff">Sign Up</a></p>
    <footer>© 2025 THE MN'S | All Rights Reserved</footer>
  </div>
</body>
</html>