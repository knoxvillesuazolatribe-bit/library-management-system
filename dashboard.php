<?php
require 'config.php';
session_start();
if (!isset($_SESSION['user'])) { header('Location: login.php'); exit; }
$user = $_SESSION['user'];
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Dashboard - Library</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="dashboard.php">Library</a>
    <div class="ms-auto text-white">Hello, <?php echo htmlspecialchars($user['username']); ?> &nbsp; <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a></div>
  </div>
</nav>
<div class="container py-4">
  <div class="row">
    <div class="col-md-3">
      <div class="list-group">
        <a href="dashboard.php" class="list-group-item list-group-item-action active">Dashboard</a>
        <a href="books.php" class="list-group-item list-group-item-action">Books</a>
        <a href="issue.php" class="list-group-item list-group-item-action">Issue / Return</a>
      </div>
    </div>
    <div class="col-md-9">
      <h4>Overview</h4>
      <?php
      $books = $mysqli->query("SELECT COUNT(*) as c FROM books")->fetch_assoc()['c'];
      $users = $mysqli->query("SELECT COUNT(*) as c FROM users")->fetch_assoc()['c'];
      $issued = $mysqli->query("SELECT COUNT(*) as c FROM transactions WHERE returned_at IS NULL")->fetch_assoc()['c'];
      ?>
      <div class="row">
        <div class="col-md-4"><div class="card p-3"><h5>Books</h5><p><?php echo $books; ?></p></div></div>
        <div class="col-md-4"><div class="card p-3"><h5>Users</h5><p><?php echo $users; ?></p></div></div>
        <div class="col-md-4"><div class="card p-3"><h5>Issued</h5><p><?php echo $issued; ?></p></div></div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
