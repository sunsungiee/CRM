<?php
require "{$_SERVER["DOCUMENT_ROOT"]}/vendor/components/header.php";
?>

<div class="content tasks">
    <div class="header tasks">
        <h1>Задачи</h1>
        <button class="add_task" id="add_task">Добавить</button>
    </div>

    <hr>
    <table class="tasks_table">
        <tr>
            <th>Контакт</th>
            <th>Тема</th>
            <th>Дата </th>
            <th>Приоритет</th>
            <th>Статус</th>
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
            <p id="modal_header_title">Новая задача</p>
            <img src="../../assets/img/icons/close.png" alt="" id="close_modal">

        </div>
        <hr style="width: 70%; margin:10px 0">
        <form action="" method="post" class="add_form">
            <fieldset>
                <legend>Контакт</legend>
                <select name="contact" id="contact" class="add_select">
                    <option value="vasya">vasya</option>
                </select>
            </fieldset>
            <fieldset>
                <legend>Тема задачи</legend>
                <input type="text" name="theme" class="add_input">
            </fieldset>
            <fieldset>
                <legend>Дата</legend>
                <input type="date" name="date" class="add_input">
            </fieldset>
            <fieldset>
                <legend>Приоритет</legend>
                <input type="radio" name="priority" value="" class="add_radio"><label for="priority">1</label><br>
                <input type="radio" name="priority" value="" class="add_radio"><label for="priority">1</label><br>
                <input type="radio" name="priority" value="" class="add_radio"><label for="priority">1</label>
            </fieldset>
            <button>Добавить</button>
        </form>
    </div>
    <script src="../../assets/js/script.js"></script>
    <script src="../../assets/js/jquery-3.7.1.min.js"></script>
    <script src="../../assets/js/jquery.maskedinput.min.js"></script>

    </body>