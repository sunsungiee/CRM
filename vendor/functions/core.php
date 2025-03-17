<?php
session_start();

$conn = new mysqli("localhost", "root", "", "CRM");

if (!$conn) {
    die("Ошибка подключения БД");
}

function redirect($path)
{
    header("Location: $path");
}

function userSession(){
    
}