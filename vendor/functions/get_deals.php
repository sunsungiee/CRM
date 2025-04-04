<?php
require "core.php";

header('Content-Type: application/json');

if (!isset($_SESSION['user']['id'])) {
    echo json_encode(['error' => 'Не авторизован']);
    exit;
}

// Параметры сортировки
$sortColumn = $_GET['sort'] ?? 'end_date';
$sortOrder = $_GET['order'] ?? 'desc';
$userId = (int)$_SESSION['user']['id'];

// Соответствие столбцов таблицы полям БД
$columnMapping = [
    'client' => 'c.surname',
    'subject' => 'd.subject',
    'end_date' => 'd.end_date',
    'end_time' => 'd.end_time',
    'phase' => 'p.phase',
    'sum' => 'd.sum'
];

if (!array_key_exists($sortColumn, $columnMapping)) {
    $sortColumn = 'end_date';
}

$sortOrder = strtoupper($sortOrder) === 'ASC' ? 'ASC' : 'DESC';

try {
    $sql = "SELECT 
        d.id,
        c.surname AS client,
        d.subject,
        DATE_FORMAT(d.end_date, '%d.%m.%Y') AS end_date,
        DATE_FORMAT(d.end_time, '%H:%i') AS end_time,
        p.phase,
        d.sum
    FROM deals d
    INNER JOIN contacts c ON d.client_id = c.id
    INNER JOIN deal_phases p ON d.phase_id = p.id
    WHERE d.user_id = ?
    ORDER BY {$columnMapping[$sortColumn]} {$sortOrder}";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $deals = [];
    while ($row = $result->fetch_assoc()) {
        $deals[] = $row;
    }

    echo json_encode($deals);
} catch (Exception $e) {
    echo json_encode(['error' => 'Ошибка сервера: ' . $e->getMessage()]);
}
