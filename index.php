<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $aksi = $_POST['aksi'] ?? '';

  if ($aksi === 'tambah' && trim($_POST['task']) !== '') {
    $koneksi->prepare("INSERT INTO todos (task) VALUES (?)")
            ->execute([trim($_POST['task'])]);
  } elseif ($aksi === 'selesai') {
    $koneksi->prepare("UPDATE todos SET is_done = NOT is_done WHERE id = ?")
            ->execute([$_POST['id']]);
  } elseif ($aksi === 'hapus') {
    $koneksi->prepare("DELETE FROM todos WHERE id = ?")
            ->execute([$_POST['id']]);
  }

  header("Location: index.php");
  exit;
}

$todos = $koneksi->query("SELECT * FROM todos ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>To-Do List</title>
</head>
<body>
  <h2>To-Do List</h2>

  <form method="POST">
    <input type="hidden" name="aksi" value="tambah">
    <input type="text" name="task" placeholder="Tulis tugas..." required>
    <button>Tambah</button>
  </form>

  <ul>
  <?php foreach ($todos as $t): ?>
    <li>
      <span style="<?= $t['is_done'] ? 'text-decoration:line-through' : '' ?>">
        <?= htmlspecialchars($t['task']) ?>
      </span>
      <form method="POST" style="display:inline">
        <input type="hidden" name="id" value="<?= $t['id'] ?>">
        <button name="aksi" value="selesai">✔</button>
        <button name="aksi" value="hapus">🗑</button>
      </form>
    </li>
  <?php endforeach; ?>
  </ul>
</body>
</html>