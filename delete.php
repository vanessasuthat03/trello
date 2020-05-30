<?php
require_once 'db.php';

if (isset($_GET['id'])) {

    $id = $_GET['id'];
    echo $id;
    $user_id = $_GET['user_id'];
    echo $user_id;

    $sql = "DELETE FROM tasks WHERE id = $id";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    header("Location: read.php?user_id=$user_id");
}
