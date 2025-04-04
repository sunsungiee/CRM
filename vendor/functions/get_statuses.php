<?php
require "core.php";
header('Content-Type: application/json');

$statuses = $conn->query("SELECT id, status FROM statuses");
echo json_encode($statuses->fetch_all(MYSQLI_ASSOC));
