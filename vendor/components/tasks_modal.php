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