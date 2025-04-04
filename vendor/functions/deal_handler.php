<?php
session_start();
require "core.php";

if ($_POST) {
    $add = $conn->query("INSERT INTO `deals`(`user_id`, `client_id`, `subject`, `end_date`, `end_time`, `sum`) VALUES (
    '{$_SESSION['user']['id']}',
    '{$_POST['contact']}',
    '{$_POST['subject']}',
    '{$_POST['end_date']}',
    '{$_POST['end_time']}',
    '{$_POST['deal_sum']}'
    )");

    if ($add) {
        redirect("../components/deals.php");
    } else {
        $error = $conn->error;
        echo "<script>alert('Ошибка добавления: " . addslashes($error) . "');</script>";
    }
}
