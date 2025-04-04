<?php
require "core.php";

// Получаем параметры сортировки
$sort_column = $_GET['sort'] ?? 'task_date';
$sort_order = $_GET['order'] ?? 'ASC';

// Валидация параметров
$allowed_columns = ['task_subject', 'task_description', 'contact_surname', 'task_date', 'task_time', 'priority', 'status'];
$sort_column = in_array($sort_column, $allowed_columns) ? $sort_column : 'task_date';
$sort_order = $sort_order === 'DESC' ? 'DESC' : 'ASC';

$tasks_sql = "SELECT 
    t.id AS task_id,
    u.id AS user_id,
    c.surname AS contact_surname,
    c.name AS contact_name,
    p.priority AS priority,
    s.status AS status,
    t.subject as task_subject,
    t.description as task_description,
    DATE_FORMAT(t.date, '%d.%m.%Y') AS task_date,
    DATE_FORMAT(t.time, '%H:%i') AS task_time
FROM tasks t
INNER JOIN users u ON t.user_id = u.id
INNER JOIN contacts c ON t.contact_id = c.id
INNER JOIN priorities p ON t.priority_id = p.id
INNER JOIN statuses s ON t.status_id = s.id
WHERE s.id = '1'
ORDER BY " . ($sort_column === 'task_date' ? 't.date' : $sort_column) . " $sort_order";

$tasks = $conn->query($tasks_sql);
$result = $tasks->fetch_all(MYSQLI_ASSOC);

header('Content-Type: application/json');
echo json_encode($result);
