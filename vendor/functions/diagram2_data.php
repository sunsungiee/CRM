<?php
require "core.php";

// Запрос для получения статистики по статусам сделок
$stats = $conn->query("SELECT 
    COUNT(*) as total_deals,
    SUM(CASE WHEN phase_id = 4 THEN 1 ELSE 0 END) as completed,
    SUM(CASE WHEN phase_id != 4 THEN 1 ELSE 0 END) as not_completed
FROM deals");

if (!$stats) {
    // Обработка ошибки запроса
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Ошибка выполнения запроса']);
    exit;
}

$data = $stats->fetch_assoc();

// Рассчитываем проценты
if ($data['total_deals'] > 0) {
    $data['completed_percent'] = round(($data['completed'] / $data['total_deals']) * 100);
    $data['not_completed_percent'] = 100 - $data['completed_percent'];
} else {
    $data['completed_percent'] = 0;
    $data['not_completed_percent'] = 0;
}

header('Content-Type: application/json');
echo json_encode($data);
?>