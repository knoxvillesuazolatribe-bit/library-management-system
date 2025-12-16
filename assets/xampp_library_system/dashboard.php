
<?php session_start(); if(!isset($_SESSION['user'])) header("Location: login.php"); ?>
<link rel='stylesheet' href='assets/css/style.css'>
<div class='nav'>
<a href='dashboard.php'>Dashboard</a>
<a href='pages/books.php'>Books</a>
<a href='logout.php'>Logout</a>
</div>
<div class='container'>
<h2>Welcome, <?php echo $_SESSION['user']; ?></h2>
<div class='card'>Library System V3</div>
</div>
