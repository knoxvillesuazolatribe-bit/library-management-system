<?php
require 'config.php';
session_start();
if (!isset($_SESSION['user'])) { header('Location: login.php'); exit; }

$action = $_GET['action'] ?? '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $title = $_POST['title']; $author = $_POST['author']; $isbn = $_POST['isbn']; $copies = intval($_POST['copies']);
        $stmt = $mysqli->prepare('INSERT INTO books (title,author,isbn,copies) VALUES (?,?,?,?)');
        $stmt->bind_param('sssi',$title,$author,$isbn,$copies); $stmt->execute();
        header('Location: books.php'); exit;
    } elseif (isset($_POST['edit'])) {
        $id = intval($_POST['id']); $title = $_POST['title']; $author = $_POST['author']; $isbn = $_POST['isbn']; $copies = intval($_POST['copies']);
        $stmt = $mysqli->prepare('UPDATE books SET title=?,author=?,isbn=?,copies=? WHERE id=?');
        $stmt->bind_param('sssii',$title,$author,$isbn,$copies,$id); $stmt->execute();
        header('Location: books.php'); exit;
    }
}
if ($action === 'delete') {
    $id = intval($_GET['id']);
    $mysqli->query('DELETE FROM books WHERE id='.$id);
    header('Location: books.php'); exit;
}
$books = $mysqli->query('SELECT * FROM books ORDER BY created_at DESC');
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Books - Library</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<?php include 'parts/nav.php'; ?>
<div class="container py-4">
  <div class="d-flex justify-content-between mb-3">
    <h4>Books</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">Add Book</button>
  </div>
  <table class="table table-striped">
    <thead><tr><th>Title</th><th>Author</th><th>ISBN</th><th>Copies</th><th>Actions</th></tr></thead>
    <tbody>
      <?php while($b = $books->fetch_assoc()): ?>
      <tr>
        <td><?php echo htmlspecialchars($b['title']); ?></td>
        <td><?php echo htmlspecialchars($b['author']); ?></td>
        <td><?php echo htmlspecialchars($b['isbn']); ?></td>
        <td><?php echo $b['copies']; ?></td>
        <td>
          <a href="books.php?action=edit&id=<?php echo $b['id']; ?>" class="btn btn-sm btn-outline-primary">Edit</a>
          <a href="books.php?action=delete&id=<?php echo $b['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete?')">Delete</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1">
  <div class="modal-dialog"><div class="modal-content">
    <form method="post">
      <div class="modal-header"><h5 class="modal-title">Add Book</h5></div>
      <div class="modal-body">
        <input name="title" class="form-control mb-2" placeholder="Title" required>
        <input name="author" class="form-control mb-2" placeholder="Author">
        <input name="isbn" class="form-control mb-2" placeholder="ISBN">
        <input name="copies" type="number" class="form-control" placeholder="Copies" value="1" min="1">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button name="add" class="btn btn-primary">Add</button>
      </div>
    </form>
  </div></div>
</div>

<!-- Edit handling -->
<?php if($action === 'edit' && isset($_GET['id'])):
    $id = intval($_GET['id']);
    $row = $mysqli->query('SELECT * FROM books WHERE id='.$id)->fetch_assoc();
?>
<div class="container py-3">
  <div class="card p-3">
    <h5>Edit Book</h5>
    <form method="post">
      <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
      <input name="title" class="form-control mb-2" value="<?php echo htmlspecialchars($row['title']); ?>" required>
      <input name="author" class="form-control mb-2" value="<?php echo htmlspecialchars($row['author']); ?>">
      <input name="isbn" class="form-control mb-2" value="<?php echo htmlspecialchars($row['isbn']); ?>">
      <input name="copies" type="number" class="form-control mb-2" value="<?php echo $row['copies']; ?>" min="1">
      <div class="d-flex"><a href="books.php" class="btn btn-secondary me-2">Cancel</a><button name="edit" class="btn btn-primary">Save</button></div>
    </form>
  </div>
</div>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
