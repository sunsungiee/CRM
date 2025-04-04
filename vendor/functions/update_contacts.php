<?php
require "core.php";

header('Content-Type: application/json');

try {
    $id = (int)$_POST['id'];
    $field = $_POST['field'];
    $value = $_POST['value'];

    // Проверка допустимых полей
    $allowedFields = ['surname', 'name', 'phone', 'email', 'firm'];
    if (!in_array($field, $allowedFields)) {
        throw new Exception('Недопустимое поле');
    }

    $stmt = $conn->prepare("UPDATE contacts SET {$field} = ? WHERE id = ?");
    $stmt->bind_param("si", $value, $id);

    if (!$stmt->execute()) {
        throw new Exception('Ошибка базы данных');
    }

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
