$(document).ready(function () {
    // Инициализация маски для телефона
    $('body').on('focus', '.edit-phone', function () {
        $(this).mask("+7(999)-999-99-99");
    });

    // Сортировка таблицы
    $('#contacts_table th[data-column]').click(function () {
        const column = $(this).data('column');
        let sortOrder = $(this).data('sort') === 'asc' ? 'desc' : 'asc';

        // Сбрасываем сортировку для всех заголовков
        $('#contacts_table th').each(function () {
            $(this).data('sort', '').find('span').remove();
        });

        // Устанавливаем новую сортировку
        $(this).data('sort', sortOrder);
        $(this).append(` <span>${sortOrder === 'asc' ? '▲' : '▼'}</span>`);

        // Отправляем запрос на сервер
        $.get('../../vendor/functions/get_all_contacts.php', {
            sort: column,
            order: sortOrder
        }, function (data) {
            renderContactsTable(data);
        }, 'json');
    });

    // Редактирование ячеек
    $('body').on('dblclick', '.editable', function () {
        const $cell = $(this);
        const id = $cell.closest('tr').data('id');
        const field = $cell.data('field');
        const value = $cell.text().trim();

        // Создаем input для редактирования
        if (field === 'phone') {
            $cell.html(`<input type="text" class="edit-phone" value="${value}">`);
        } else {
            $cell.html(`<input type="text" value="${value}">`);
        }

        const $input = $cell.find('input');
        $input.focus();

        // Сохранение при нажатии Enter или потере фокуса
        $input.on('keyup blur', function (e) {
            if (e.type === 'keyup' && e.key !== 'Enter') return;

            const newValue = $(this).val().trim();
            if (newValue !== value) {
                updateContact(id, field, newValue, $cell);
            } else {
                $cell.text(value);
            }
        });
    });
});

function renderContactsTable(data) {
    const $tbody = $('#contacts_table tbody');
    $tbody.empty();

    data.forEach(contact => {
        $tbody.append(`
            <tr data-id="${contact.id}">
                <td class="editable" data-field="surname">${contact.surname || ''}</td>
                <td class="editable" data-field="name">${contact.name || ''}</td>
                <td class="editable" data-field="phone">${contact.phone || ''}</td>
                <td class="editable" data-field="email">${contact.email || ''}</td>
                <td class="editable" data-field="firm">${contact.firm || ''}</td>
                <td class="actions">
                    <form action="" method="post">
                        <button class="btn-delete" name="contact_id" value="<?= $contact['id']; ?>">
                            <i class="fas fa-trash-alt"></i> Удалить
                        </button>
                    </form>
                </td>
            </tr>
        `);
    });
}

function updateContact(id, field, value, $cell) {
    $.post('../../vendor/functions/update_contacts.php', {
        id: id,
        field: field,
        value: value
    }, function (response) {
        if (response.success) {
            $cell.text(value);
        } else {
            alert(response.error || 'Ошибка обновления');
            $cell.text($cell.data('original-value'));
        }
    }, 'json').fail(function () {
        alert('Ошибка соединения');
        $cell.text($cell.data('original-value'));
    });
}

function escapeHtml(str) {
    return str ? str.toString()
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;') : '';
}