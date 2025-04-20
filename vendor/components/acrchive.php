<?php
require "{$_SERVER["DOCUMENT_ROOT"]}/vendor/components/header.php";

if (isset($_SESSION['user']['id'])) {
    $tasks_sql = "SELECT 
    t.id AS task_id,
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
WHERE s.id != '1' AND user_id = '{$_SESSION['user']['id']}'
ORDER BY task_date";

    $tasks = $conn->query($tasks_sql);

    $contacts = $conn->query("SELECT * FROM `contacts` ORDER BY `surname`");
    $priorities = $conn->query("SELECT * FROM `priorities`");
    $statuses = $conn->query("SELECT * FROM `statuses`");
} else {
    redirect("../../index.php");
}
?>
<!-- //подключение файла jquery -->
<script src="../../assets/js/jquery-3.7.1.min.js"></script>

<div class="content tasks">
    <div class="header tasks">
        <h1>Архив задач</h1>
        <a href="#" id="burger_open" class="burger_btn">
            <img src="../../assets/img/icons/burger.svg" alt="Меню">
        </a>
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
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($tasks) {
                        foreach ($tasks as $task) {
                    ?>
                            <tr>
                                <td><?= $task['task_subject'] ?></td>
                                <td><?= $task['task_description'] ?></td>
                                <td class="editable-select"><?= $task['contact_surname'] ?></td>
                                <td><?= $task['task_date'] ?></td>
                                <td><?= $task['task_time'] ?></td>
                                <td class="editable-select"><?= $task['priority'] ?> </td>
                                <td class="editable-select"><?= $task['status'] ?></td>
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

<script src="../../assets/js/jquery.maskedinput.min.js"></script>
<script src="../../assets/js/script.js"></script>
<script src="../../assets/js/archive.js"></script>
<script src="../../assets/js/burger.js"></script>

</body>

</html>