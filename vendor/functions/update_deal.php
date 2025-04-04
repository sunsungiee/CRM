<?php
require "core.php";

header('Content-Type: application/json');

if (!isset($_SESSION['user']['id'])) {
    echo json_encode(['success' => false, 'error' => 'Не авторизован']);
    exit;
}

try {
    $id = (int)$_POST['id'];
    $field = $_POST['field'];
    $value = $_POST['value'];
    $userId = (int)$_SESSION['user']['id'];

    // Проверка прав доступа
    $check = $conn->prepare("SELECT id FROM deals WHERE id = ? AND user_id = ?");
    $check->bind_param("ii", $id, $userId);
    $check->execute();

    if (!$check->get_result()->num_rows) {
        throw new Exception('Нет доступа к этой сделке');
    }

    // Разрешенные поля для обновления
    $allowedFields = ['subject', 'end_date', 'end_time', 'deal_sum', 'phase', 'client'];

    if (!in_array($field, $allowedFields)) {
        throw new Exception('Недопустимое поле');
    }

    // Подготовленный запрос
    $sql = "UPDATE deals SET {$field} = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($value === '') {
        $stmt->bind_param("si", $null, $id);
        $null = null;
    } else {
        $stmt->bind_param("si", $value, $id);
    }

    if (!$stmt->execute()) {
        throw new Exception('Ошибка базы данных: ' . $stmt->error);
    }

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
