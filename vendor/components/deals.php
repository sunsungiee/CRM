<?php
require "{$_SERVER["DOCUMENT_ROOT"]}/vendor/components/header.php";

if (isset($_SESSION['user']['id'])) {
    $deals_sql = "SELECT 
    d.id AS deal_id,
    u.id AS user_id,
    c.surname AS contact_surname,
    c.id AS client_id,
    d.subject as deal_subject,
    p.phase AS phase,
    p.id AS phase_id,
    d.sum as deal_sum,
    DATE_FORMAT(d.end_date, '%d.%m.%Y') AS deal_date,
    DATE_FORMAT(d.end_time, '%H:%i') AS deal_time
FROM deals d
INNER JOIN users u ON d.user_id = u.id
INNER JOIN contacts c ON d.client_id = c.id
INNER JOIN deal_phases p ON d.phase_id = p.id
WHERE  user_id = '{$_SESSION['user']['id']}'
ORDER BY phase";

    $deals = $conn->query($deals_sql);

    $contacts = $conn->query("SELECT * FROM `contacts`");
    $phases = $conn->query("SELECT * FROM deal_phases");

    if (isset($_POST['deal_id'])) {
        $res = $conn->query("DELETE FROM `deals` WHERE `id` = '{$_POST['deal_id']}'");
        if ($res) {
            redirect("deals.php");
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
        <h1>Сделки</h1>
        <button class="add_task" id="add_task">Добавить</button>
        <a href="#" id="burger_open" class="burger_btn">
            <img src="../../assets/img/icons/burger.svg" alt="Меню">
        </a>
    </div>
    <hr>
    <div class="content_tasks">
        <div class="time_limit">
            <table class="tasks_table" id="deals_table">
                <thead>
                    <tr>
                        <th data-column="client" data-sort="desc">Клиент</th>
                        <th data-column="subject" data-sort="">Тема</th>
                        <th data-column="end_date" data-sort="">Дата завершения</th>
                        <th data-column="end_time" data-sort="">Время завершения</th>
                        <th data-column="phase" data-sort="">Стадия</th>
                        <th data-column="deal_sum" data-sort="">Сумма</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($deals && $deals->num_rows > 0) {
                        foreach ($deals as $deal) {
                            // echo "<pre>";
                            // print_r($deals); // Покажет всю структуру данных
                            // echo "</pre>";
                            error_reporting(E_ALL);
                            ini_set('display_errors', 1);
                    ?>

                            <tr>
                                <td class="editable-client"
                                    data-field="client"
                                    data-current-id="<?= $deal['client_id'] ?>"><?= $deal['contact_surname'] ?></td>
                                <td class="editable" data-field="subject"><?= $deal['deal_subject'] ?></td>
                                <td class="editable-date" data-field="end_date"><?= $deal['deal_date'] ?></td>
                                <td class="editable-time" data-field="end_time"><?= $deal['deal_time'] ?></td>
                                <td class="editable-phase"
                                    data-field="phase"
                                    data-current-id="<?= $deal['phase'] ?>"><?= $deal['phase'] ?></td>
                                <td class="editable" data-field="deal_sum"><?= $deal['deal_sum'] ?></td>
                                <td class="actions">
                                    <form action="" method="post">
                                        <button class="btn-delete" name="deal_id" value="<?= $deal['deal_id']; ?>">
                                            <i class="fas fa-trash-alt"></i> Удалить
                                        </button>
                                    </form>
                                </td>
                            </tr>
                    <?php

                        }
                    } else {
                        // echo $conn->error;
                    }
                    ?>
                </tbody>
            </table>

        </div>
    </div>

</div>
<script>
    // Передаем данные в JS
    const contactsData = <?= json_encode($contacts->fetch_all(MYSQLI_ASSOC)) ?>;
    const phasesData = <?= json_encode($phases->fetch_all(MYSQLI_ASSOC)) ?>;
</script>
<?php
include "deals_modal.php";
?>

<script src="../../assets/js/script.js"></script>
<script src="../../assets/js/deals.js"></script>
<script src="../../assets/js/burger.js"></script>
</body>

</html>