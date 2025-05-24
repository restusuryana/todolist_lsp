<?php

session_start();


// Inisialisasi array tugas
if (!isset($_SESSION['tasks'])) {
    $_SESSION['tasks'] = [];
}

// Tambah tugas baru
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['task'])) {
    $task = trim($_POST['task']);
    if ($task !== '') {
        $_SESSION['tasks'][] = ['name' => $task, 'done' => false];
    }
    header("Location: index.php");
    exit;
}

// Toggle status selesai
if (isset($_GET['toggle'])) {
    $index = $_GET['toggle'];
    if (isset($_SESSION['tasks'][$index])) {
        $_SESSION['tasks'][$index]['done'] = !$_SESSION['tasks'][$index]['done'];
    }
    header("Location: index.php");
    exit;
}

// Hapus tugas
if (isset($_GET['delete'])) {
    $index = $_GET['delete'];
    if (isset($_SESSION['tasks'][$index])) {
        unset($_SESSION['tasks'][$index]);
        $_SESSION['tasks'] = array_values($_SESSION['tasks']);
    }
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>To-Do List dengan Checkbox</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .todo-container {
      max-width: 600px;
      margin: 50px auto;
    }
    .done {
      text-decoration: line-through;
      color: #999;
    }
  </style>
</head>
<body>

<div class="container todo-container">
  <div class="card shadow">
    <div class="card-header bg-primary text-white text-center">
      <h3>📋 Aplikasi To-Do List</h3>
    </div>
    <div class="card-body">

      <!-- Form tambah tugas -->
      <form method="POST" class="mb-4 d-flex gap-2">
        <input type="text" name="task" class="form-control" placeholder="Tugas baru..." required>
        <button type="submit" class="btn btn-success">Tambah</button>
      </form>

      <!-- Daftar tugas -->
      <?php if (!empty($_SESSION['tasks'])): ?>
        <ul class="list-group">
          <?php foreach ($_SESSION['tasks'] as $index => $task): ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <div class="form-check">
                <input 
                  class="form-check-input" 
                  type="checkbox" 
                  onclick="location.href='?toggle=<?= $index ?>'"
                    <?= $task['done'] ? 'checked' : '' ?>
                >
                <label class="form-check-label <?= $task['done'] ? 'done' : '' ?>">
                  <?= htmlspecialchars($task['name']) ?>
                </label>
              </div>
              <a href="?delete=<?= $index ?>" class="btn btn-danger btn-sm">🗑️</a>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php else: ?>
        <div class="alert alert-info text-center">Belum ada tugas. Tambahkan tugas di atas.</div>
      <?php endif; ?>

    </div>
  </div>
</div>

</body>
</html>
