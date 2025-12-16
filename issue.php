<?php
require 'config.php';
session_start();
if (!isset($_SESSION['user'])) { header('Location: login.php'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['issue'])) {
        $user_id = intval($_POST['user_id']);
        $book_id = intval($_POST['book_id']);
        $mysqli->query('INSERT INTO transactions (user_id,book_id) VALUES ('.$user_id.','.$book_id.')');
        header('Location: issue.php'); exit;
    } elseif (isset($_POST['return'])) {
        $tid = intval($_POST['transaction_id']);
        $mysqli->query('UPDATE transactions SET returned_at = NOW() WHERE id='.$tid);
        header('Location: issue.php'); exit;
    }
}

$transactions = $mysqli->query('SELECT t.*, u.username, b.title FROM transactions t JOIN users u ON u.id=t.user_id JOIN books b ON b.id=t.book_id ORDER BY t.issued_at DESC');
$users = $mysqli->query('SELECT id,username FROM users');
$books = $mysqli->query('SELECT id,title,copies FROM books');
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Issue / Return - Library</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<?php include 'parts/nav.php'; ?>
<div class="container py-4">
  <h4>Issue / Return</h4>
  <div class="card p-3 mb-3">
    <form method="post" class="row g-2 align-items-end">
      <div class="col-md-4"><label>User</label><select name="user_id" class="form-select"><?php while($u=$users->fetch_assoc()): ?><option value="<?php echo $u['id']; ?>"><?php echo htmlspecialchars($u['username']); ?></option><?php endwhile; ?></select></div>
      <div class="col-md-4"><label>Book</label><select name="book_id" class="form-select"><?php while($b=$books->fetch_assoc()): ?><option value="<?php echo $b['id']; ?>"><?php echo htmlspecialchars($b['title']); ?></option><?php endwhile; ?></select></div>
      <div class="col-md-4"><button name="issue" class="btn btn-primary">Issue Book</button></div>
    </form>
  </div>

  <h5>Transactions</h5>
  <table class="table table-bordered">
    <thead><tr><th>User</th><th>Book</th><th>Issued At</th><th>Returned At</th><th>Action</th></tr></thead>
    <tbody>
      <?php while($t = $transactions->fetch_assoc()): ?>
      <tr>
        <td><?php echo htmlspecialchars($t['username']); ?></td>
        <td><?php echo htmlspecialchars($t['title']); ?></td>
        <td><?php echo $t['issued_at']; ?></td>
        <td><?php echo $t['returned_at'] ? $t['returned_at'] : '-'; ?></td>
        <td>
          <?php if(!$t['returned_at']): ?>
          <form method="post" style="display:inline"><input type="hidden" name="transaction_id" value="<?php echo $t['id']; ?>"><button name="return" class="btn btn-sm btn-success">Return</button></form>
          <?php else: ?>Returned<?php endif; ?>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>
