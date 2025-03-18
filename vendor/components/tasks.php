<?php
require "{$_SERVER["DOCUMENT_ROOT"]}/vendor/components/header.php";

$tasks = $conn->query("SELECT * FROM `tasks` WHERE 1");
$contacts = $conn->query("SELECT * FROM `contacts` ORDER BY `surname`");
$priorities = $conn->query("SELECT * FROM `priorities`");
$statuses = $conn->query("SELECT * FROM `statuses`");

if (isset($_SESSION['user']['id'])) {
    if ($_POST) {
        $add_task = $conn->query("INSERT INTO `tasks`
(`user_id`, 
`contact_id`, 
`subject`, 
`description`, 
`date`, 
`priority_id`) VALUES
('{$_SESSION['user']['id']}',
'{$_POST['contact']}',
'{$_POST['subject']}',
'{$_POST['description']}',
'{$_POST['date']}',
'{$_POST['priority']}')");

        if (!$add_task) {
            $error = "Ошибка добавления записи: " . $conn->error;
            error_log($error); // Логирование ошибки
        }
        redirect("tasks.php");
    }
} else {
    redirect("../../index.php");
}
?>
<div class="content tasks">
    <div class="header tasks">
        <h1>Задачи</h1>
        <button class="add_task" id="add_task">Добавить</button>
    </div>
    <hr>
    <table class="tasks_table">
        <tr>
            <th>Тема</th>
            <th>Описание</th>
            <th>Контакт</th>
            <th>Дата</th>
            <th>Приоритет</th>
            <th>Статус</th>
        </tr>
        <?php
        if ($tasks) {
            foreach ($tasks as $task) {
        ?>
                <tr>
                    <td><?= $task['subject'] ?></td>
                    <td><?= $task['description'] ?></td>
                    <td>Контакт</td>
                    <td><?= $task['date'] ?></td>
                    <td>Приоритет </td>
                    <td>статус</td>
                </tr>
        <?php
            }
        }
        ?>
    </table>
</div>
</div>
</main>

<div class="modal" id="modal">
    <div class="modal_content">

        <form action="" method="post" class="add_form">
            <div class="modal_header">
                <p id="modal_header_title">Новая задача</p>
                <button class="close_btn" type="reset"><img src="../../assets/img/icons/close.png" alt="" id="close_modal"></button>
            </div>
            <hr style="width: 70%; margin:10px 0">


            <fieldset>
                <legend>Контакт</legend>
                <select name="contact" id="contact" class="add_select add" required>
                    <option value="" selected disabled>Выберите контакт</option>
                    <?php
                    if ($contacts) {
                        foreach ($contacts as $contact) {
                    ?>
                            <option value="<?= $contact['id'] ?>">
                                <?= $contact['surname'] . " " . $contact['name'] ?>
                            </option>
                    <?php
                        }
                    }
                    ?>
                </select>
            </fieldset>

            <fieldset>
                <legend>Тема задачи</legend>
                <input type="text" name="subject" class="add_input add" required>
            </fieldset>

            <fieldset>
                <legend>Описание задачи</legend>
                <textarea name="description" id="task_description" class="add_textarea add" required></textarea>
            </fieldset>

            <fieldset>
                <legend>Дата</legend>
                <input type="date" name="date" id="task_date" class="add_input add" required>
            </fieldset>

            <fieldset>
                <legend>Приоритет</legend>

                <?php
                if ($priorities) {
                    foreach ($priorities as $priority) {
                ?>
                        <input type="radio" name="priority" value="<?= $priority['id'] ?>" id="<?= $priority['id'] ?>" class="add_radio add" required>
                        <label for="<?= $priority['id'] ?>"><?= $priority['priority'] ?></label>
                        <br>
                <?php
                    }
                }
                ?>
            </fieldset>
            <button class="add_btn" type="submit">Добавить</button>
        </form>
    </div>
</div>
<script src="../../assets/js/script.js"></script>
<script src="../../assets/js/jquery-3.7.1.min.js"></script>
<script src="../../assets/js/jquery.maskedinput.min.js"></script>
</body>

</html>