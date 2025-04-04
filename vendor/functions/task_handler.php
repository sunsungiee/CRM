<?php
require "core.php";

$date = !empty($_POST['date']) ? "'" . $_POST['date'] . "'" : NULL;
$time = !empty($_POST['time']) ? "'" . $_POST['time'] . "'" : NULL;

$contact = $_POST['contact'] ?? NULL;

$add_task = $conn->query("INSERT INTO `tasks`
(`user_id`, 
`contact_id`, 
`subject`, 
`description`, 
`date`, 
`time`, 
`priority_id`) VALUES
('{$_SESSION['user']['id']}',
'$contact',
'{$_POST['subject']}',
'{$_POST['description']}',
$date,
$time,
'{$_POST['priority']}')");

if (!$add_task) {
    die($conn->error);
    $error = "Ошибка добавления записи: " . $conn->error;
    error_log($error); // Логирование ошибки
} else {
    redirect("../components/tasks.php");
}
