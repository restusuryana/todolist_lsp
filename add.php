<?php
if (!empty($_POST['task'])) {
    $task = trim($_POST['task']);
    file_put_contents('task.txt', $task . PHP_EOL, FILE_APPEND);
}
header('Location: index.php');
exit;
