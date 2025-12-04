<?php
require __DIR__ . '/alegend.php'; 

$message = '';
$message_type = ''; // 'success' or 'error'

// handle POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['fullname'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $gender   = $_POST['gender'] ?? 'Other';

    // basic validation
    if ($fullname === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6) {
        $message = 'Please enter a valid name, a valid email, and a password (min 6 chars).';
        $message_type = 'error';
    } else {
        // check duplicate email using prepared statement
        $chk = $conn->prepare('SELECT email FROM users WHERE email = ? LIMIT 1');
        if ($chk) {
            $chk->bind_param('s', $email);
            $chk->execute();
            $chk->store_result();
            if ($chk->num_rows > 0) {
                $message = 'This email is already registered';
                $message_type = 'error';
            } else {
                // insert new user
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $ins = $conn->prepare('INSERT INTO users (fullname, email, password, gender) VALUES (?, ?, ?, ?)');
                if ($ins) {
                    $ins->bind_param('ssss', $fullname, $email, $hash, $gender);
                    if ($ins->execute()) {
                        $message = 'Registration successful — you can now <a href="login.php" style="color:#cfefff">login</a>.';
                        $message_type = 'success';
                        // clear form values
                        $fullname = $email = $gender = '';
                    } else {
                        // handle duplicate or other DB error gracefully
                        if ($conn->errno === 1062) {
                            $message = 'This email is already registered';
                        } else {
                            $message = 'Registration failed. Please try again later.';
                        }
                        $message_type = 'error';
                    }
                    $ins->close();
                } else {
                    $message = 'Database error (prepare failed).';
                    $message_type = 'error';
                }
            }
            $chk->close();
        } else {
            $message = 'Database error (prepare failed).';
            $message_type = 'error';
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Register | MN'S</title>
  <link rel="stylesheet" href="style3.css"/>
</head>
<body>

  <div class="card" role="main" aria-labelledby="regTitle">
    <h1 id="regTitle">Create account</h1>
    <p class="lead">Sign up </p>

    <?php if ($message !== ''): ?>
      <div class="msg <?= $message_type === 'success' ? 'success' : 'error' ?>">
        <?= $message_type === 'success' ? $message : htmlspecialchars($message) ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="register.php" novalidate>
      <input name="fullname" type="text" placeholder="Full name" required value="<?= htmlspecialchars($fullname ?? '') ?>">
      <input name="email" type="email" placeholder="Email" required value="<?= htmlspecialchars($email ?? '') ?>">

      <div class="pw-wrapper">
        <input id="passwordInput" name="password" type="password" placeholder="Password (min 6 chars)" required>
        <button type="button" class="pw-toggle" aria-label="Show password" aria-pressed="false">
          <svg class="eye-open" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"></path>
            <circle cx="12" cy="12" r="3"></circle>
          </svg>
          <svg class="eye-closed" style="display:none" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M17.94 17.94A10.94 10.94 0 0 1 12 19c-7 0-11-7-11-7 .91-1.58 2.12-2.95 3.58-4.14"></path>
            <path d="M1 1l22 22"></path>
            <path d="M9.53 9.53A3.5 3.5 0 0 0 12 15.5"></path>
          </svg>
        </button>
      </div>

      <select name="gender" required>
        <option value="" disabled <?= empty($gender) ? 'selected' : '' ?>>Select gender</option>
        <option value="Male" <?= (isset($gender) && $gender==='Male') ? 'selected' : '' ?>>Male</option>
        <option value="Female" <?= (isset($gender) && $gender==='Female') ? 'selected' : '' ?>>Female</option>
        <option value="Other" <?= (isset($gender) && $gender==='Other') ? 'selected' : '' ?>>Other</option>
      </select>

      <button type="submit">Sign Up</button>
    </form>

    <p class="muted">Already registered? <a href="login.php" style="color:#cfefff">Login</a></p>
    <footer>© 2025 THE MN'S | All Rights Reserved</footer>
  </div>

<script>
  //eye toggle (java script)
  (function(){
    const btn = document.querySelector('.pw-toggle');
    const input = document.getElementById('passwordInput');
    const openIcon = btn.querySelector('.eye-open');
    const closedIcon = btn.querySelector('.eye-closed');

    btn.addEventListener('click', () => {
      if (input.type === 'password') {
        input.type = 'text';
        btn.setAttribute('aria-pressed','true');
        btn.setAttribute('aria-label','Hide password');
        openIcon.style.display = 'none';
        closedIcon.style.display = 'block';
      } else {
        input.type = 'password';
        btn.setAttribute('aria-pressed','false');
        btn.setAttribute('aria-label','Show password');
        openIcon.style.display = 'block';
        closedIcon.style.display = 'none';
      }
    });
  })();
</script>

</body>
</html>
