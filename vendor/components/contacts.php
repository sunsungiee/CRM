<?php
require "{$_SERVER["DOCUMENT_ROOT"]}/vendor/components/header.php";
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
            <td>test</td>
            <td>test</td>
            <td>test</td>
            <td>test</td>
            <td>test</td>
        </tr>
    </table>

</div>




</div>

</main>
<div class="modal" id="modal">
    <div class="modal_content">
        <div class="modal_header">
            <p id="modal_header_title">Новый контакт</p>
            <img src="../../assets/img/icons/close.png" alt="" id="close_modal">

        </div>
    </div>
    <script src="../../assets/js/script.js"></script>
    <script src="../../assets/js/jquery-3.7.1.min.js"></script>
    <script src="../../assets/js/jquery.maskedinput.min.js"></script>

    </body>