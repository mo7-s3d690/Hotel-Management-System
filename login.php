<?php
session_start();
require __DIR__ . '/alegend.php';

$error = ''; //ده variable هستخدمه في line 54
$registered = isset($_GET['registered']); // ده variable هستخدمه في line 50

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? ''); // بياخد ال email و بيتريم ال spaces
    $password = $_POST['password'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {// check valid email and pass
        $error = 'Please enter email and password.';
    } else {
        $stmt = $conn->prepare('SELECT id, fullname, password FROM users WHERE email = ? LIMIT 1');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();// database queries
        if ($stmt->num_rows === 1) { //لو فيه واحد عنده الايميل ده كمل
            $stmt->bind_result( $id, $fullname, $hash);// hashing
            $stmt->fetch();
            if (password_verify($password, $hash)) {//comparing the original with the entered
                session_regenerate_id(true);
                $_SESSION['user_id'] = $id;
                $_SESSION['fullname'] = $fullname;
                // success message page or redirect
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

    <p class="muted">Don't have an account? <a href="register.php">Register</a></p>
    <footer> © 2025 THE MN'S | All Rights Reserved </footer>
  </div>

  
</body>
</html>
