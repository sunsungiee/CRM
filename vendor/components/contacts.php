<?php
require "{$_SERVER["DOCUMENT_ROOT"]}/vendor/components/header.php";

$contacts = $conn->query("SELECT * FROM `contacts`");

?>

<div class="content tasks">
    <div class="header tasks">
        <h1>Список контактов</h1>
        <button class="add_task" id="add_task">Добавить</button>
    </div>

    <hr>
    <table class="tasks_table">
        <tr>
            <th>Фамилия</th>
            <th>Имя</th>
            <th>Номер телефона</th>
            <th>Эл. почта</th>
            <th>Организация</th>
        </tr>
        <tr>
            <?php
            foreach ($contacts as $contact) {
            ?>
        <tr>
            <td><?= $contact['surname'] ?></td>
            <td><?= $contact['name'] ?></td>
            <td><?= $contact['phone'] ?></td>
            <td><?= $contact['email'] ?></td>
            <td><?= $contact['firm'] ?></td>
        </tr>
    <?php
            }
    ?>


    </tr>
    </table>
</div>
</div>
</main>

<div class="modal" id="modal">
    <div class="modal_content">
        <form action="../functions/contact_handler.php" method="post" class="add_form">
            <div class="modal_header">
                <p id="modal_header_title">Новый контакт</p>
                <button class="close_btn" type="reset"><img src="../../assets/img/icons/close.png" alt="" id="close_modal"></button>
            </div>
            <hr style="width: 70%; margin:10px 0">

            <fieldset>
                <legend>Фамилия</legend>
                <input type="text" name="contact_surname" class="add_input add" required>
            </fieldset>

            <fieldset>
                <legend>Имя</legend>
                <input type="text" name="contact_name" class="add_input add" required>
            </fieldset>

            <fieldset>
                <legend>Номер телефона</legend>
                <input type="text" name="contact_phone" id="phone" class="add_input add" required>
            </fieldset>

            <fieldset>
                <legend>Эл. почта</legend>
                <input type="email" name="contact_email" class="add_input add" required>
            </fieldset>

            <fieldset>
                <legend>Организация</legend>
                <input type="text" name="contact_firm" class="add_input add" required>
            </fieldset>
            <button class="add_btn" type="submit">Добавить</button>
        </form>
    </div>
    <script src="../../assets/js/jquery-3.7.1.min.js"></script>
    <script src="../../assets/js/jquery.maskedinput.min.js"></script>
    <script src="../../assets/js/script.js"></script>

    </body>