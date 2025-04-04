<div class="modal" id="modal">
    <div class="modal_content">
        <form action="../functions/deal_handler.php" method="post" class="add_form">
            <div class="modal_header">
                <p id="modal_header_title">Новая сделка</p>
                <button class="close_btn" type="reset"><img src="../../assets/img/icons/close.png" alt="" id="close_modal"></button>
            </div>
            <hr style="width: 70%; margin:10px 0">

            <fieldset>
                <legend>Клиент</legend>
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
                <legend>Тема сделки</legend>
                <input type="text" name="subject" class="add_input add" required>
            </fieldset>

            <fieldset>
                <legend>Дата совершения</legend>
                <input type="date" name="end_date" id="deal_date" class="add_input add" required>
            </fieldset>

            <fieldset>
                <legend>Время совершения</legend>
                <input type="time" name="end_time" id="deal_time" class="add_input add" required>
            </fieldset>

            <fieldset>
                <legend>Сумма сделки</legend>
                <input type="text" name="deal_sum" class="add_input add" required>
            </fieldset>
            <button class="add_btn" type="submit">Добавить</button>
        </form>
    </div>
</div>