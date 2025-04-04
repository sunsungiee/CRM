<?php
require "core.php";
header('Content-Type: application/json');

$priorities = $conn->query("SELECT id, priority FROM priorities");
echo json_encode($priorities->fetch_all(MYSQLI_ASSOC));
