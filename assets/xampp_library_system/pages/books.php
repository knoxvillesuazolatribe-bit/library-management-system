
<?php
session_start();
if(!isset($_SESSION['user'])) header("Location: ../login.php");
include '../config.php';
if(isset($_POST['add'])){
    $t=$_POST['title']; $a=$_POST['author'];
    $conn->query("INSERT INTO books(title,author) VALUES('$t','$a')");
}
$rs=$conn->query("SELECT * FROM books");
?>
<link rel='stylesheet' href='../assets/css/style.css'>
<div class='nav'>
<a href='../dashboard.php'>Dashboard</a>
<a href='books.php'>Books</a>
<a href='../logout.php'>Logout</a>
</div>
<div class='container'>
<h2>Books</h2>
<form method='POST'>
<input name='title' placeholder='Book Title'>
<input name='author' placeholder='Author'>
<button class='btn' name='add'>Add Book</button>
</form>
<table>
<tr><th>Title</th><th>Author</th></tr>
<?php while($row=$rs->fetch_assoc()): ?>
<tr><td><?php echo $row['title']; ?></td><td><?php echo $row['author']; ?></td></tr>
<?php endwhile; ?>
</table>
</div>
