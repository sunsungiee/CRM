<?php
require "{$_SERVER["DOCUMENT_ROOT"]}/vendor/components/header.php";

$totalAmount = 0;
$deal_sum = $conn->query("SELECT SUM(sum) AS total FROM deals
WHERE phase_id = 4 and `user_id` = '{$_SESSION['user']['id']}'
");
if (isset($deal_sum) && $deal_sum != false) {
    $row = $deal_sum->fetch_assoc();
    $totalAmount = $row['total'] ?? 0;
}

?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="content">

    <div class="header tasks">
        <h1>Аналитика</h1>
        <a href="#" id="burger_open" class="burger_btn">
            <img src="../../assets/img/icons/burger.svg" alt="Меню">
        </a>
    </div>
    <hr>
    <section class="diagram">
        <h2>Всего сделок на </h2>
        <h1 style="font-size: 40px; border-bottom:1px solid black"><?= $totalAmount ?> руб.</h1>
    </section>
    <div class="first_diag diagram">
        <canvas class="diagramma" id="statusChart"></canvas>
        <h1>Мои выполненные <br>задачи</h1>
    </div>

    <div class="secont_diag diagram">
        <h1 style="text-align: right;">Процент завершения <br>сделок</h1>
        <canvas class="diagramma" id="myDealsChart"></canvas>
        <div id="chart-legend" style="text-align: center; margin-top: 15px;"></div>
    </div>
</div>

<script>
    // Загрузка данных с сервера
    fetch('../functions/diagram1_data.php')
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById('statusChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Выполнено', 'Провалено', 'В процессе'],
                    datasets: [{
                        data: [data.completed, data.failed, data.in_progress],
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.6)',
                            'rgba(255, 99, 132, 0.6)',
                            'rgba(255, 137, 86, 0.6)'
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgb(255, 131, 86)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const value = context.raw;
                                    const percentage = Math.round((value / total) * 100);
                                    return `${context.label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        });

    fetch('../functions/diagram2_data.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Ошибка сети');
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                console.error(data.error);
                document.getElementById('myDealsChart').parentElement.innerHTML =
                    '<p class="error">' + data.error + '</p>';
                return;
            }

            const ctx = document.getElementById('myDealsChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Завершено', 'Не завершено'],
                    datasets: [{
                        data: [data.completed_percent, data.not_completed_percent],
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.7)',
                            'rgba(255, 99, 132, 0.7)'
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 99, 132, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'right',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = data.total_deals;
                                    const count = label === 'Завершено' ? data.completed : data.not_completed;
                                    return `${label}: ${value}% (${count} из ${total})`;
                                }
                            }
                        },
                        title: {
                            display: true,
                            text: `Общее количество сделок: ${data.total_deals}`,
                            font: {
                                size: 16
                            }
                        }
                    },
                    cutout: '70%',
                    animation: {
                        animateScale: true,
                        animateRotate: true
                    }
                }
            });
        })
        .catch(error => {
            console.error('Ошибка:', error);
            document.getElementById('myDealsChart').parentElement.innerHTML =
                '<p class="error">Произошла ошибка при загрузке данных</p>';
        });
</script>
<script src="../../assets/js/burger.js"></script>


</body>

</html>