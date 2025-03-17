<?php
session_start();
require "{$_SERVER["DOCUMENT_ROOT"]}/vendor/functions/core.php";

if (isset($_SESSION['user'])) {
    $username = $_SESSION['user']['name'];
    $userpost = $_SESSION['user']['post'];
} else {
    redirect("../../index.php");
}

?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRM</title>

    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Oswald:wght@200..700&display=swap" rel="stylesheet">
</head>

<body>
    <main>
        <nav class="side_bar_menu">
            <div class="side_bar_menu_top">
                <div class="logo">
                    <h2 style="width: fit-content;"> CRM</h2>
                </div>
                <ul>
                    <li><a href="homepage.php">Рабочий стол</a></li>
                    <li><a href="analytics.php">Аналитика</a></li>
                    <li><a href="tasks.php">Задачи</a></li>
                    <li><a href="dealings.php">Сделки</a></li>
                    <li><a href="contacts.php">Контакты</a></li>
                    <li><a href="chats.php">Чаты</a></li>
                </ul>
            </div>
            <ul>
                <li>
                    <a href="#">
                        <img src="" alt=""><?= $username; ?>
                    </a>
                    <a style="display: block;">
                        <span style="color: gray; font-size: 12px;">
                            <?= $userpost; ?>
                        </span>
                    </a>
                </li>
                <li>
                    <a href="logout.php">
                        <img src="#" alt="" class="logout_icon">Выйти
                    </a>
                </li>
            </ul>
        </nav>