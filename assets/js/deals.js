
$(document).ready(function () {
    // Инициализация данных
    if (typeof window.phasesData !== 'undefined') {
        phasesData = window.phasesData;
    }

    if (typeof window.contactsData !== 'undefined') {
        contactsData = window.contactsData;
    }

    // Сортировка таблицы
    $('#deals_table th[data-column]').click(function () {
        const column = $(this).data('column');
        const sortOrder = $(this).data('sort') === 'asc' ? 'desc' : 'asc';

        $('#deals_table th').removeClass('sorted-asc sorted-desc');
        $(this).addClass('sorted-' + sortOrder);
        $(this).data('sort', sortOrder);

        loadDeals(column, sortOrder);
    });

    initEditableFields();
});

function loadDeals(sortColumn = 'end_date', sortOrder = 'desc') {
    $.ajax({
        url: '../../vendor/functions/get_deals.php',
        type: 'GET',
        dataType: 'json',
        data: {
            sort: sortColumn,
            order: sortOrder
        },
        success: function (response) {
            if (Array.isArray(response)) {
                renderDealsTable(response);
            } else {
                console.error('Некорректный формат данных:', response);
                alert('Ошибка при загрузке данных');
            }
        },
        error: function (xhr) {
            console.error('AJAX Error:', xhr.responseText);
            alert('Ошибка соединения с сервером');
        }
    });
}

function renderDealsTable(deals) {
    const $tbody = $('#deals_table tbody');
    $tbody.empty();

    if (!deals || deals.length === 0) {
        $tbody.append('<tr><td colspan="6">Нет данных для отображения</td></tr>');
        return;
    }

    deals.forEach(deal => {
        const row = `
            <tr data-id="${deal.id}">
                <td class="editable-client" data-field="client" data-current-id="${escapeHtml(deal.client)}">${escapeHtml(deal.client)}</td>
                <td class="editable" data-field="subject">${escapeHtml(deal.subject)}</td>
                <td class="editable-date" data-field="end_date">${escapeHtml(deal.end_date)}</td>
                <td class="editable-time" data-field="end_time">${escapeHtml(deal.end_time)}</td>
                <td class="editable-select" data-field="phase">${escapeHtml(deal.phase)}</td>
                <td class="editable" data-field="deal_sum">${escapeHtml(deal.sum)}</td>
                <td class="actions">
                                    <button class="btn-delete" data-id="<?= $deal['id'] ?>">
                                        <i class="fas fa-trash-alt"></i> Удалить
                                    </button>
                                </td>
            </tr>
        `;
        $tbody.append(row);
    });

    initEditableFields();
}

function initEditableFields() {
    // Текстовые поля
    $('.editable').off('dblclick').on('dblclick', function () {
        const $cell = $(this);
        const value = $cell.text().trim();
        const field = $cell.data('field');

        $cell.html(`<input type="text" value="${escapeHtml(value)}">`);
        $cell.find('input').focus().select();

        setupInputHandlers($cell, field);
    });

    // Поля даты
    $('.editable-date').off('dblclick').on('dblclick', function () {
        const $cell = $(this);
        const dateValue = $cell.text().trim().split('.').reverse().join('-');
        const field = $cell.data('field');

        $cell.html(`<input type="date" value="${dateValue}">`);
        $cell.find('input').focus();

        setupInputHandlers($cell, field, true, 'date');
    });

    // Поля времени
    $('.editable-time').off('dblclick').on('dblclick', function () {
        const $cell = $(this);
        const timeValue = $cell.text().trim();
        const field = $cell.data('field');

        $cell.html(`<input type="time" value="${timeValue}">`);
        $cell.find('input').focus();

        setupInputHandlers($cell, field, true, 'time');
    });

    $(document).on('dblclick', '.editable-client', function () {
        const $cell = $(this);
        const currentValue = $cell.data('current-id'); // ID текущего клиента
        const currentText = $cell.text().trim();

        let options = '<option value="">Выберите клиента</option>';
        contactsData.forEach(contact => {
            const selected = contact.id == currentValue ? 'selected' : '';
            options += `<option value="${contact.id}" ${selected}>${escapeHtml(contact.surname)}</option>`;
        });

        $cell.html(`<select class="form-control">${options}</select>`);
        const $select = $cell.find('select');
        $select.focus();

        setupSelectHandler($select, $cell, 'client_id', currentText);
    });

    // Select для стадий
    $(document).on('dblclick', '.editable-phase', function () {
        const $cell = $(this);
        const currentValue = $cell.data('current-id'); // ID текущей стадии
        const currentText = $cell.text().trim();

        let options = '';
        phasesData.forEach(phase => {
            const selected = phase.id == currentValue ? 'selected' : '';
            options += `<option value="${phase.id}" ${selected}>${escapeHtml(phase.phase)}</option>`;
        });

        $cell.html(`<select class="form-control">${options}</select>`);
        const $select = $cell.find('select');
        $select.focus();

        setupSelectHandler($select, $cell, 'phase_id', currentText);
    });
}

function setupInputHandlers($cell, field, isDate = false, type = 'text') {
    const $input = $cell.find('input');
    const oldValue = $cell.data('original-value') || $cell.text().trim();

    $input.on('keydown', function (e) {
        if (e.key === 'Enter') {
            saveChanges($cell, field, $(this).val(), oldValue, isDate, type);
        } else if (e.key === 'Escape') {
            $cell.text(oldValue);
        }
    });

    $input.on('blur', function () {
        saveChanges($cell, field, $(this).val(), oldValue, isDate, type);
    });
}

function setupSelectHandler($select, $cell, field, oldText) {
    $select.on('blur', function () {
        $cell.text(oldText);
    });

    $select.on('change', function () {
        const newId = $(this).val();
        const newText = $(this).find('option:selected').text();

        if (!newId) {
            $cell.text(oldText);
            return;
        }

        saveChanges($cell, field, newId, oldText, newText);
    });
}

function saveChanges($cell, field, value, oldText, displayText) {
    const id = $cell.closest('tr').data('id');

    $.ajax({
        url: '../../vendor/functions/update_deal.php',
        type: 'POST',
        dataType: 'json',
        data: {
            id: id,
            field: field,
            value: value
        },
        success: function (response) {
            if (response.success) {
                $cell.text(displayText);
                $cell.data('current-id', value); // Обновляем ID
            } else {
                alert(response.error || 'Ошибка сохранения');
                $cell.text(oldText);
            }
        },
        error: function () {
            // alert('Ошибка соединения');
            $cell.text(oldText);
        }
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