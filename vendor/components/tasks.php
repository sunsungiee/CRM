<?php
require "{$_SERVER["DOCUMENT_ROOT"]}/vendor/components/header.php";

if (isset($_SESSION['user']['id'])) {
    $tasks_sql = "SELECT 
    u.id AS user_id,
    c.surname AS contact_surname,
    c.name AS contact_name,
    p.priority AS priority,
    s.status AS status,
    t.subject as task_subject,
    t.description as task_description,
    DATE_FORMAT(t.date, '%d.%m.%Y') AS task_date,
    DATE_FORMAT(t.time, '%H:%i') AS task_time
FROM tasks t
INNER JOIN users u ON t.user_id = u.id
INNER JOIN contacts c ON t.contact_id = c.id
INNER JOIN priorities p ON t.priority_id = p.id
INNER JOIN statuses s ON t.status_id = s.id
ORDER BY task_date";

    $tasks = $conn->query($tasks_sql);

    $contacts = $conn->query("SELECT * FROM `contacts` ORDER BY `surname`");
    $priorities = $conn->query("SELECT * FROM `priorities`");
    $statuses = $conn->query("SELECT * FROM `statuses`");
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

    <div class="content_tasks">

        <div class="time_limit">
            <table class="tasks_table">
                <tr>
                    <th>Тема

                    </th>
                    <th>Описание

                    </th>
                    <th>Контакт</th>
                    <th>Дата</th>
                    <th>Время</th>
                    <th>Приоритет</th>
                    <th>Статус</th>
                </tr>
                <?php
                if ($tasks) {
                    foreach ($tasks as $task) {
                ?>
                        <tr>
                            <td><?= $task['task_subject'] ?></td>
                            <td><?= $task['task_description'] ?></td>
                            <td><?= $task['contact_surname'] ?> <?= $task['contact_name'] ?></td>
                            <td><?= $task['task_date'] ?></td>
                            <td><?= $task['task_time'] ?></td>
                            <td><?= $task['priority'] ?> </td>
                            <td><?= $task['status'] ?>
                            </td>
                        </tr>
                <?php
                    }
                }
                ?>
            </table>
        </div>

        <div class="timeless">
            <h2>Задачи без учета времени</h2>

        </div>
    </div>

</div>
</div>
</main>

<div class="modal" id="modal">
    <div class="modal_content">

        <form action="../functions/task_handler.php" method="post" class="add_form">
            <div class="modal_header">
                <p id="modal_header_title">Новая задача</p>
                <button class="close_btn" type="reset"><img src="../../assets/img/icons/close.png" alt="" id="close_modal"></button>
            </div>
            <hr style="width: 70%; margin:10px 0">

            <fieldset>
                <legend>Контакт</legend>
                <select name="contact" id="contact" class="add_select add" required>
                    <option value="" selected disabled>Выберите контакт</option>
                    <option value="0" selected>Без контакта</option>
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
                <input type="date" name="date" id="task_date" class="add_input add">
            </fieldset>

            <fieldset>
                <legend>Время</legend>
                <input type="time" name="time" id="task_time" class="add_input add">
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