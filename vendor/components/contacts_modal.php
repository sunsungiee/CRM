<div class="modal" id="modal">
    <div class="modal_content">
        <form action="../functions/contact_handler.php" method="post" class="add_form">
            <div class="modal_header">
                <p id="modal_header_title">Новый контакт</p>
                <button class="close_btn" type="reset"><img src="../../assets/img/icons/close.png" alt="" id="close_modal"></button>
            </div>
            <hr style="width: 70%; margin:10px 0">

            <fieldset>
                <legend>Фамилия</legend>
                <input type="text" name="contact_surname" class="add_input add" required>
            </fieldset>

            <fieldset>
                <legend>Имя</legend>
                <input type="text" name="contact_name" class="add_input add" required>
            </fieldset>

            <fieldset>
                <legend>Номер телефона</legend>
                <input type="text" name="contact_phone" id="phone" class="add_input add" required>
            </fieldset>

            <fieldset>
                <legend>Эл. почта</legend>
                <input type="email" name="contact_email" class="add_input add" required>
            </fieldset>

            <fieldset>
                <legend>Организация</legend>
                <input type="text" name="contact_firm" class="add_input add" required>
            </fieldset>
            <button class="add_btn" type="submit">Добавить</button>
        </form>
    </div>
</div>