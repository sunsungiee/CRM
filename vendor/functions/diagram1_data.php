<?php
require "core.php";

// Получаем имена пользователей вместе с ID
$diagram = $conn->query("SELECT 
    SUM(CASE WHEN status_id = 2 THEN 1 ELSE 0 END) as completed,
    SUM(CASE WHEN status_id = 3 THEN 1 ELSE 0 END) as rejected,
    SUM(CASE WHEN status_id = 1 THEN 1 ELSE 0 END) as in_progress
FROM tasks");

$data = $diagram->fetch_assoc();

header('Content-Type: application/json');
echo json_encode($data);
