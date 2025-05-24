<?php
if (isset($_POST['index'])) {
    $todos = file('task.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    unset($todos[$_POST['index']]);
    file_put_contents('task.txt', implode(PHP_EOL, $todos) . PHP_EOL);
}
header('Location: index.php');
exit;
