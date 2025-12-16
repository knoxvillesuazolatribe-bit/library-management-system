<?php
require 'config.php';
session_start();
$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = $_POST['username'] ?? '';
    $p = $_POST['password'] ?? '';
    $stmt = $mysqli->prepare('SELECT id, username, password, role FROM users WHERE username = ?');
    $stmt->bind_param('s', $u);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    if ($res && password_verify($p, $res['password'])) {
        $_SESSION['user'] = ['id'=>$res['id'],'username'=>$res['username'],'role'=>$res['role']];
        header('Location: dashboard.php');
        exit;
    } else {
        $err = 'Invalid credentials';
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Login - Library</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="login-page">
<div class="container d-flex justify-content-center align-items-center" style="min-height:80vh">
  <div class="card p-4 shadow-sm" style="width:380px">
    <h4 class="mb-3 text-center">Library Login</h4>
    <?php if($err): ?><div class="alert alert-danger"><?php echo $err; ?></div><?php endif; ?>
    <form method="post">
      <div class="mb-2"><input name="username" class="form-control" placeholder="Username" required></div>
      <div class="mb-3"><input name="password" type="password" class="form-control" placeholder="Password" required></div>
      <div class="d-grid gap-2"><button class="btn btn-primary">Login</button></div>
    </form>
    <div class="mt-3 text-center">
      <a href="register.php">Create an account</a>
    </div>
  </div>
</div>
</body>
</html>
