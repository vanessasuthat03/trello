<?php
require_once 'db.php';


if (isset($_POST['submitModal'])) {

    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $id = htmlspecialchars($_POST['id']);
    $user_id = htmlspecialchars(($_POST['user_id']));


    $sql = "UPDATE tasks SET title = :title, description = :description WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':id', $id);

    $stmt->execute();
    header("Location: read.php?user_id=$user_id");
}
