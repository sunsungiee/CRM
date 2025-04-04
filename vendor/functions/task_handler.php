<?php
require "core.php";

$date = !empty($_POST['date']) ? $_POST['date'] : null;
$time = !empty($_POST['time']) ? $_POST['time'] : null;
$contact = !empty($_POST['contact']) ? $_POST['contact'] : null;

// $add_task = $conn->query("INSERT INTO `tasks`
// (`user_id`, 
// `contact_id`, 
// `subject`, 
// `description`, 
// `date`, 
// `time`, 
// `priority_id`) VALUES
// ('{$_SESSION['user']['id']}',
// '$contact',
// '{$_POST['subject']}',
// '{$_POST['description']}',
// '$date',
// '$time',
// '{$_POST['priority']}')");

// if (!$add_task) {
//     die($conn->error);
//     $error = "Ошибка добавления записи: " . $conn->error;
//     error_log($error); // Логирование ошибки
// } else {
//     redirect("../components/tasks.php");
// }
// Используем подготовленные выражения для безопасности
$stmt = $conn->prepare("INSERT INTO `tasks`
    (`user_id`, `contact_id`, `subject`, `description`, `date`, `time`, `priority_id`) 
    VALUES (?, ?, ?, ?, ?, ?, ?)");

if (!$stmt) {
    die("Ошибка подготовки запроса: " . $conn->error);
}

// Привязываем параметры с указанием типов (s - string, i - integer)
$stmt->bind_param(
    "iissssi",
    $_SESSION['user']['id'],
    $contact,
    $_POST['subject'],
    $_POST['description'],
    $date,
    $time,
    $_POST['priority']
);

// Выполняем запрос
if (!$stmt->execute()) {
    die("Ошибка выполнения запроса: " . $stmt->error);
}

$stmt->close();
redirect("../components/current_tasks.php");
