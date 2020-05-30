<?php
require_once 'db.php';


$requestPayload = file_get_contents("php://input");
$object = json_decode($requestPayload, true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $from = $object['fromContainer_id'] . PHP_EOL;
    $to = $object['toContainer_id'] . PHP_EOL;
    $id = $object['task_id'] . PHP_EOL;

    $sql = "UPDATE tasks SET status_id = $to WHERE id = $id";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    // header('Location: read.php');
}
