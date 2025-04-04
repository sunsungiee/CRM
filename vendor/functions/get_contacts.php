<?php
require "core.php";
header('Content-Type: application/json');

$contacts = $conn->query("SELECT id, surname FROM contacts ORDER BY surname");
echo json_encode($contacts->fetch_all(MYSQLI_ASSOC));
?>