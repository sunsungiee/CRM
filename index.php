<?php
session_start();
require "vendor/functions/core.php";

if ($_POST) {
    $res = $conn->query("SELECT * FROM `users` WHERE `login` = '{$_POST['login']}' and `password` = '{$_POST['password']}'");
    if ($res && $res->num_rows > 0) {
        $_SESSION['user'] = $res->fetch_assoc();
        redirect("vendor/components/analytics.php");
    } else {
        $error_msg = "Пользователь не найден";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRM</title>

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Oswald:wght@200..700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <form action="" method="post" class="auth_form">
            <h1 class="form_h">Авторизация</h1>

            <input type="text" name="login" placeholder="Логин пользователя">
            <input type="password" name="password" placeholder="Пароль">

            <p>Или <a href="vendor/components/reg.php">зарегистрируйтесь</a>, чтобы стать частью команды</p>
            <?php
            if (isset($error_msg)) {
                echo "<p>" . $error_msg . "</p>";
            }
            ?>
            <button type="submit">Войти</button>
        </form>
    </div>
    </main>
</body>

</html>