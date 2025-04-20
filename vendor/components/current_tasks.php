<?php
require "{$_SERVER["DOCUMENT_ROOT"]}/vendor/components/header.php";

if (isset($_SESSION['user']['id'])) {
    $tasks_sql = "SELECT 
    t.id AS task_id,
    u.id AS user_id,
    c.surname AS contact_surname,
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
WHERE s.id = '1' AND user_id = '{$_SESSION['user']['id']}'
ORDER BY task_date";

    $tasks = $conn->query($tasks_sql);

    $contacts = $conn->query("SELECT * FROM `contacts`");
    $priorities = $conn->query("SELECT * FROM `priorities`");
    $statuses = $conn->query("SELECT * FROM `statuses`");

    if (isset($_POST['task_id'])) {
        $res = $conn->query("DELETE FROM `tasks` WHERE `id` = '{$_POST['task_id']}'");
        if ($res) {
            redirect("current_tasks.php");
        }
    }
} else {
    redirect("../../index.php");
}
?>
<!-- //подключение файла jquery -->
<script src="../../assets/js/jquery-3.7.1.min.js"></script>

<div class="content tasks">
    <div class="header tasks">
        <h1>Задачи</h1>
        <div class="header_btns">
            <button class="add_task" id="add_task">Добавить</button>
            <a href="#" id="burger_open" class="burger_btn">
                <img src="../../assets/img/icons/burger.svg" alt="Меню">
            </a>
        </div>
    </div>
    <hr>
    <div class="content_tasks">
        <div class="time_limit">
            <table class="tasks_table" id="tasks_table" data-contacts='<?= json_encode($contacts) ?>'>
                <thead>
                    <tr>
                        <th data-column="subject">Тема</th>
                        <th data-column="description">Описание</th>
                        <th data-column="contact">Контакт</th>
                        <th data-column="date">Дата</th>
                        <th data-column="time">Время</th>
                        <th data-column="priority">Приоритет</th>
                        <th data-column="status">Статус</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($tasks) {
                        foreach ($tasks as $task) {
                            // echo "<pre>";
                            // print_r($task); // Покажет всю структуру данных
                            // echo "</pre>";
                    ?>

                            <tr>
                                <td><?= $task['task_subject'] ?></td>
                                <td><?= $task['task_description'] ?></td>
                                <td class="editable-select"><?= $task['contact_surname'] ?></td>
                                <td><?= $task['task_date'] ?></td>
                                <td><?= $task['task_time'] ?></td>
                                <td class="editable-select"><?= $task['priority'] ?> </td>
                                <td class="editable-select"><?= $task['status'] ?></td>
                                <td class="actions">
                                    <form action="" method="post">
                                        <button class="btn-delete" name="task_id" value="<?= $task['task_id']; ?>">
                                            <i class="fas fa-trash-alt"></i> Удалить
                                        </button>
                                    </form>
                                </td>
                            </tr>
                    <?php

                        }
                    }
                    ?>
                </tbody>
            </table>

        </div>
    </div>

</div>
</main>

<?php
include "tasks_modal.php";
?>

<script src="../../assets/js/jquery.maskedinput.min.js"></script>
<script src="../../assets/js/script.js"></script>
<script src="../../assets/js/tasks.js"></script>
<script src="../../assets/js/burger.js"></script>

</body>

</html>