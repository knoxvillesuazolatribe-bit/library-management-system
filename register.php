<?php
require 'config.php';
session_start();
$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = $_POST['username'] ?? '';
    $p = $_POST['password'] ?? '';
    if (strlen($p) < 4) { $err = 'Password must be at least 4 characters.'; }
    else {
        $hash = password_hash($p, PASSWORD_DEFAULT);
        $stmt = $mysqli->prepare('INSERT INTO users (username,password,role) VALUES (?,?,?)');
        $role = 'user';
        $stmt->bind_param('sss',$u,$hash,$role);
        if ($stmt->execute()) {
            header('Location: login.php');
            exit;
        } else {
            $err = 'Could not create user (maybe username taken).';
        }
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Register - Library</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="login-page">
<div class="container d-flex justify-content-center align-items-center" style="min-height:80vh">
  <div class="card p-4 shadow-sm" style="width:380px">
    <h4 class="mb-3 text-center">Create Account</h4>
    <?php if($err): ?><div class="alert alert-danger"><?php echo $err; ?></div><?php endif; ?>
    <form method="post">
      <div class="mb-2"><input name="username" class="form-control" placeholder="Username" required></div>
      <div class="mb-3"><input name="password" type="password" class="form-control" placeholder="Password" required></div>
      <div class="d-grid gap-2"><button class="btn btn-primary">Register</button></div>
    </form>
    <div class="mt-3 text-center">
      <a href="login.php">Back to login</a>
    </div>
  </div>
</div>
</body>
</html>
