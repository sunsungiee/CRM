$(document).ready(function () {
    let currentSort = {
        column: 'task_date',
        order: 'ASC'
    };

    function loadData(sortColumn = currentSort.column, sortOrder = currentSort.order) {
        $.get('../../vendor/functions/get_archive.php', {
            sort: sortColumn,
            order: sortOrder
        }, function (data) {
            renderTable(data);
        }).fail(function () {
            alert('Ошибка загрузки данных');
        });
    }

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
});