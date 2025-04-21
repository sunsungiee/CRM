<?php
ob_start();
session_start();

$conn = new mysqli("localhost", "root", "", "CRM");

$conn->set_charset("utf8mb4");

if (!$conn) {
    die("Ошибка подключения БД");
}

function redirect($path)
{
    header("Location: $path");
}
