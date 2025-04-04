<?php
require "core.php";

header('Content-Type: application/json');

$sortColumn = $_GET['sort'] ?? 'surname';
$sortOrder = $_GET['order'] ?? 'asc';

// Проверка допустимости столбца для сортировки
$allowedColumns = ['surname', 'name', 'phone', 'email', 'firm'];
if (!in_array($sortColumn, $allowedColumns)) {
    $sortColumn = 'surname';
}

$sortOrder = strtoupper($sortOrder) === 'DESC' ? 'DESC' : 'ASC';

$stmt = $conn->prepare("SELECT * FROM contacts ORDER BY {$sortColumn} {$sortOrder}");
$stmt->execute();
$result = $stmt->get_result();

$contacts = [];
while ($row = $result->fetch_assoc()) {
    $contacts[] = $row;
}

echo json_encode($contacts);
