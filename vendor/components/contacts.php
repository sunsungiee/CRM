<?php
require "{$_SERVER["DOCUMENT_ROOT"]}/vendor/components/header.php";

$contacts = $conn->query("SELECT * FROM `contacts`");

if (isset($_POST['contact_id'])) {
    $res = $conn->query("DELETE FROM `contacts` WHERE `id` = '{$_POST['contact_id']}'");
    if ($res) {
        redirect("contacts.php");
    }
}
?>

<div class="content tasks">
    <div class="header tasks">
        <h1>Список контактов</h1>
        <div class="header_btns">
            <button class="add_task" id="add_task">Добавить</button>
            <a href="#" id="burger_open" class="burger_btn">
                <img src="../../assets/img/icons/burger.svg" alt="Меню">
            </a>
        </div>
    </div>

    <hr>
    <table class="tasks_table" id="contacts_table">
        <thead>
            <tr>
                <th data-column="surname">Фамилия</th>
                <th data-column="name">Имя</th>
                <th data-column="phone">Номер телефона</th>
                <th data-column="email">Эл. почта</th>
                <th data-column="firm">Организация</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <?php
                foreach ($contacts as $contact) {
                ?>
            <tr data-id="<?= $contact['id'] ?>">
                <td class="editable" data-field="surname"><?= $contact['surname'] ?></td>
                <td class="editable" data-field="name"><?= $contact['name'] ?></td>
                <td class="editable" data-field="phone"><?= $contact['phone'] ?></td>
                <td class="editable" data-field="email"><?= $contact['email'] ?></td>
                <td class="editable" data-field="firm"><?= $contact['firm'] ?></td>
                <td class="actions">
                    <form action="" method="post">
                        <button class="btn-delete" name="contact_id" value="<?= $contact['id']; ?>">
                            <i class="fas fa-trash-alt"></i> Удалить
                        </button>
                    </form>
                </td>
            </tr>

        <?php
                }
        ?>
        </tbody>
    </table>
</div>
</div>
</main>
<?php
include "contacts_modal.php";
?>
<script src="../../assets/js/jquery-3.7.1.min.js"></script>
<script src="../../assets/js/jquery.maskedinput.min.js"></script>
<script src="../../assets/js/script.js"></script>
<script src="../../assets/js/contacts.js"></script>
<script>
    $('#phone').mask("+7(999)-999-99-99");
</script>
<script src="../../assets/js/burger.js"></script>

</body>