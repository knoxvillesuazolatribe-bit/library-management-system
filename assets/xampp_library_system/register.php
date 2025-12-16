
<?php
include 'config.php';
if(isset($_POST['reg'])){
    $u=$_POST['username']; $p=$_POST['password'];
    $conn->query("INSERT INTO users(username,password) VALUES('$u','$p')");
    header("Location: login.php");
}
?>
<link rel='stylesheet' href='assets/css/style.css'>
<div class='container'>
<h2>Register</h2>
<form method='POST'>
<input name='username' placeholder='Username'>
<input name='password' type='password' placeholder='Password'>
<button class='btn' name='reg'>Register</button>
</form>
</div>
