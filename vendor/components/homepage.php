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

<div class="content">
    <div class="header tasks">
        <h1>Рабочий стол</h1>
    </div>
    <hr>

    <?php
    ?>
    <section>
        <h2>Всего сделок на </h2>
        <h1><?= $totalAmount ?> руб.</h1>
    </section>
</div>
</main>
</body>