<?php
require "../functions/core.php";


if ($_POST) {
    $res = $conn->query("SELECT * FROM `users` WHERE `login` = '{$_POST['login']}'");
    if ($res->num_rows == 0) {
        $reg = $conn->query("INSERT INTO `users`(`surname`, `name`, `post`, `phone`, `email`, `login`, `password`) VALUES ('{$_POST['surname']}',
        '{$_POST['name']}',
        '{$_POST['post']}',
        '{$_POST['phone']}',
        '{$_POST['email']}',
        '{$_POST['login']}',
        '{$_POST['password']}')");

        if ($reg) {
            $_SESSION['user'] = $user;
            redirect("homepage.php");
        } else {
            $error_msg = "Ошибка регистрации";
        }
    } else {
        $error_msg = "Пользователь с таким логином уже существует";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRM</title>

    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Oswald:wght@200..700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <form action="" method="post" class="auth_form">
            <h1 class="form_h">Регистрация</h1>

            <input type="text" name="surname" placeholder="Фамилия">
            <input type="text" name="name" placeholder="Имя">
            <input type="text" name="post" placeholder="Должность">
            <input type="text" name="phone" id="phone" placeholder="Телефон">
            <input type="email" name="email" placeholder="Эл. почта">
            <input type="text" name="login" placeholder="Логин пользователя">
            <input type="password" name="password" placeholder="Пароль">

            <p>Или <a href="../../index.php">авторизуйтесь</a>, если вы уже с нами!</p>

            <?php
            if (isset($error_msg)) {
                echo "<p>" . $error_msg . "</p>";
            }
            ?>
            <button type="submit">Зарегистрироваться</button>
        </form>
    </div>
    </main>

    <script src="../../assets/js/jquery-3.7.1.min.js"></script>
    <script src="../../assets/js/jquery.maskedinput.min.js"></script>
    <script>
        $('#phone').mask("+7(999)-999-99-99");
    </script>
</body>

</html>