<?php
require 'core.php';

$id = $_POST['id'];
$field = $_POST['field'];
$value = $_POST['value'];

// Валидация полей
$allowed_fields = ['subject', 'description', 'date', 'time', 'priority_id', 'status_id', 'contact_id'];
if (!in_array($field, $allowed_fields)) {
    die(json_encode(['error' => 'Недопустимое поле']));
}

if ($value === '' || $value === 'null') {
    $value = null;
}

try {
    $stmt = null;
    // Особые обработки для разных типов полей
    switch ($field) {
        case 'date':
            // Преобразуем дату из формата YYYY-MM-DD в DATETIME
            $value = $value ? date('Y-m-d', strtotime($value)) : null;
            $stmt = $conn->query("UPDATE tasks SET date = '$value' WHERE id = '$id'");
            break;

        case 'time':
            // Проверяем формат времени HH:MM
            if ($value && !preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/', $value)) {
                throw new Exception("Неверный формат времени");
            }
            $stmt = $conn->query("UPDATE tasks SET time = '$value' WHERE id = '$id'");
            break;

        default:
            $stmt = $conn->query("UPDATE tasks SET $field = '$value' WHERE id = '$id'");
    }

    if ($stmt && $stmt->num_rows >= 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
