
<?php
session_start();
include 'config.php';
if(isset($_POST['login'])){
    $u=$_POST['username']; $p=$_POST['password'];
    $r=$conn->query("SELECT * FROM users WHERE username='$u' AND password='$p'");
    if($r->num_rows>0){
        $_SESSION['user']=$u;
        header("Location: dashboard.php"); exit;
    } else { $err="Wrong login."; }
}
?>
<link rel='stylesheet' href='assets/css/style.css'>
<div class='container'>
<h2>Login</h2>
<form method='POST'>
<input name='username' placeholder='Username'>
<input name='password' type='password' placeholder='Password'>
<button class='btn' name='login'>Login</button>
<?php if(isset($err)) echo "<p>$err</p>"; ?>
</form>
</div>
