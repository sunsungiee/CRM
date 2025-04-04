<?php
require "core.php";

if ($_POST) {
    $add = $conn->query("INSERT INTO `contacts`(`surname`, `name`, `email`, `phone`, `firm`) VALUES 
    ('{$_POST['contact_surname']}','{$_POST['contact_name']}','{$_POST['contact_email']}','{$_POST['contact_phone']}','{$_POST['contact_firm']}')");

    if ($add) {
        redirect("../components/contacts.php");
    } else {
        $error = $conn->error;
        echo "<script>alert('Ошибка добавления: " . addslashes($error) . "');</script>";
    }
}
