$(document).ready(function () {
    // Кэш для справочных данных
    const dictionaries = {
        priorities: [],
        statuses: [],
        contacts: []
    };

    // Текущая сортировка
    let currentSort = {
        column: 'task_date',
        order: 'ASC'
    };

    // Загрузка данных таблицы
    function loadData(sortColumn = currentSort.column, sortOrder = currentSort.order) {
        $.get('../../vendor/functions/get_tasks.php', {
            sort: sortColumn,
            order: sortOrder
        }, function (data) {
            renderTable(data);
        }).fail(function () {
            alert('Ошибка загрузки данных');
        });
    }

    // Загрузка справочников
    function loadDictionaries() {
        $.get('../../vendor/functions/get_priorities.php', function (data) {
            dictionaries.priorities = data;
        });

        $.get('../../vendor/functions/get_statuses.php', function (data) {
            dictionaries.statuses = data;
        });

        $.get('../../vendor/functions/get_contacts.php', function (data) {
            dictionaries.contacts = data;
        });
    }

    // Рендер таблицы
    function renderTable(data) {
        const tbody = $('#tasks_table tbody');
        tbody.empty();

        data.forEach(function (task) {
            const tr = $(`
                <tr>
                    <td class="editable" data-id="${task.task_id}" data-field="subject">${escapeHtml(task.task_subject)}</td>
                    <td class="editable" data-id="${task.task_id}" data-field="description">${escapeHtml(task.task_description)}</td>
                    <td class="editable-select" data-id="${task.task_id}" data-field="contact_id">${escapeHtml(task.contact_surname)}</td>
                    <td class="editable-date" data-id="${task.task_id}" data-field="date">${escapeHtml(task.task_date)}</td>
                    <td class="editable-time" data-id="${task.task_id}" data-field="time">${escapeHtml(task.task_time)}</td>
                    <td class="editable-select" data-id="${task.task_id}" data-field="priority_id">${escapeHtml(task.priority)}</td>
                    <td class="editable-select" data-id="${task.task_id}" data-field="status_id">${escapeHtml(task.status)}</td>
                </tr>
            `);
            tbody.append(tr);
        });
    }

    // Обработчик сортировки
    $('#tasks_table th[data-column]').click(function () {
        const column = $(this).data('column');

        if (currentSort.column === column) {
            currentSort.order = currentSort.order === 'ASC' ? 'DESC' : 'ASC';
        } else {
            currentSort.column = column;
            currentSort.order = 'ASC';
        }

        loadData(currentSort.column, currentSort.order);

        // Обновление UI
        $('#tasks_table th').removeClass('sorted-asc sorted-desc');
        $(this).addClass(`sorted-${currentSort.order.toLowerCase()}`);
    });

    // Редактирование текстовых полей
    $(document).on('dblclick', '.editable', function () {
        const $cell = $(this);
        const value = $cell.text().trim();
        const id = $cell.data('id');
        const field = $cell.data('field');

        $cell.html(`<input type="text" class="edit-input" value="${escapeHtml(value)}">`);
        $cell.find('input').focus().select();

        $cell.find('input').on('keydown', function (e) {
            if (e.key === 'Enter') {
                saveChanges($cell, id, field, $(this).val().trim(), value);
            } else if (e.key === 'Escape') {
                $cell.text(value);
            }
        });

        $cell.find('input').on('blur', function () {
            $cell.text(value);
        });
    });

    // Редактирование select-полей
    $(document).on('dblclick', '.editable-select', function () {
        const $cell = $(this);
        const id = $cell.data('id');
        const field = $cell.data('field');
        const currentValue = $cell.text().trim();

        let options = '';
        let currentId = '';

        // Генерация options в зависимости от типа поля
        switch (field) {
            case 'priority_id':
                dictionaries.priorities.forEach(p => {
                    const selected = p.priority === currentValue ? 'selected' : '';
                    if (selected) currentId = p.id;
                    options += `<option value="${p.id}" ${selected}>${escapeHtml(p.priority)}</option>`;
                });
                break;

            case 'status_id':
                dictionaries.statuses.forEach(s => {
                    const selected = s.status === currentValue ? 'selected' : '';
                    if (selected) currentId = s.id;
                    options += `<option value="${s.id}" ${selected}>${escapeHtml(s.status)}</option>`;
                });
                break;

            case 'contact_id':
                options = '<option value="null">Без контакта</option>';
                dictionaries.contacts.forEach(c => {
                    const selected = c.surname === currentValue ? 'selected' : '';
                    if (selected) currentId = c.id;
                    options += `<option value="${c.id}" ${selected}>${escapeHtml(c.surname)}</option>`;
                });
                break;
        }

        $cell.html(`<select class="edit-select">${options}</select>`);
        $cell.find('select').focus();

        $cell.find('select').on('change', function () {
            const newId = $(this).val();
            const newText = $(this).find('option:selected').text();
            saveChanges($cell, id, field, newId, currentValue, newText);
        });

        $cell.find('select').on('blur', function () {
            $cell.text(currentValue);
        });
    });

    // Редактирование даты
    $(document).on('dblclick', '.editable-date', function () {
        const $cell = $(this);
        const currentDate = $cell.text().trim();
        const id = $cell.data('id');
        const field = $cell.data('field');

        // Преобразуем формат даты для input[type="date"]
        const inputDate = currentDate.split('.').reverse().join('-');

        $cell.html(`<input type="date" class="edit-input" value="${inputDate}">`);
        $cell.find('input').focus();

        $cell.find('input').on('change', function () {
            const newValue = $(this).val(); // Формат: YYYY-MM-DD
            const displayValue = formatDateForDisplay(newValue);
            saveChanges($cell, id, field, newValue, currentDate, displayValue);
        });

        $cell.find('input').on('blur', function () {
            $cell.text(currentDate);
        });
    });

    // Редактирование времени
    $(document).on('dblclick', '.editable-time', function () {
        const $cell = $(this);
        const currentTime = $cell.text().trim();
        const id = $cell.data('id');
        const field = $cell.data('field');

        $cell.html(`<input type="time" class="edit-input" value="${currentTime}">`);
        $cell.find('input').focus();

        $cell.find('input').on('change', function () {
            const newValue = $(this).val(); // Формат: HH:MM
            saveChanges($cell, id, field, newValue, currentTime);
        });

        $cell.find('input').on('blur', function () {
            $cell.text(currentTime);
        });
    });

    // Форматирование даты для отображения (dd.mm.YYYY)
    function formatDateForDisplay(dateStr) {
        if (!dateStr) return '';
        const parts = dateStr.split('-');
        return `${parts[2]}.${parts[1]}.${parts[0]}`;
    }

    // Сохранение изменений
    // function saveChanges($cell, id, field, value, oldValue, displayValue = null) {
    //     $.ajax({
    //         url: '../../vendor/functions/update_task.php',
    //         type: 'POST',
    //         dataType: 'json',
    //         contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
    //         data: {
    //             id: id,
    //             field: field,
    //             value: value
    //         },
    //         success: function (response) {
    //             // Проверяем, что ответ - валидный JSON
    //             if (response && response.success) {
    //                 $cell.text(displayValue || value);
    //             } else {
    //                 const errorMsg = response?.error || 'Неизвестная ошибка сервера';
    //                 console.error('Server Error:', response);
    //                 alert(errorMsg);
    //                 $cell.text(oldValue);
    //             }
    //         },
    //         error: function (xhr, status, error) {
    //             let serverResponse = xhr.responseText;

    //             // Если сервер вернул HTML вместо JSON
    //             if (serverResponse.startsWith('<')) {
    //                 serverResponse = 'Сервер вернул HTML вместо JSON. Проверьте ошибки PHP.';
    //             }

    //             console.error('AJAX Error:', {
    //                 Status: status,
    //                 Error: error,
    //                 Response: serverResponse
    //             });

    //             alert('Ошибка соединения: ' + serverResponse);
    //             $cell.text(oldValue);
    //         }
    //     });
    // }

    function saveChanges($cell, id, field, value, oldValue, displayValue = null) {
        // Преобразуем пустые значения в 'null' для сервера
        const sendValue = (value === '' || value === null) ? 'null' : value;

        $.ajax({
            url: '../../vendor/functions/update_task.php',
            type: 'POST',
            dataType: 'json',
            contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
            data: {
                id: id,
                field: field,
                value: sendValue
            },
            success: function (response) {
                if (response?.success) {
                    // Обработка NULL от сервера
                    const display = response.updatedValue === null ? '' : (displayValue || response.updatedValue);
                    $cell.text(display);
                } else {
                    showError(response?.error || 'Ошибка обновления');
                    $cell.text(oldValue);
                }
            },
            error: function (xhr) {
                showError(xhr.responseText || 'Ошибка соединения');
                $cell.text(oldValue);
            }
        });
    }

    function showError(message) {
        console.error('Error:', message);
        alert(message.replace(/<[^>]*>?/gm, '')); // Удаляем HTML-теги из сообщения
    }

    // Экранирование HTML
    function escapeHtml(str) {
        return str ? str.toString()
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;') : '';
    }

    // Инициализация
    loadDictionaries();
    loadData();
});