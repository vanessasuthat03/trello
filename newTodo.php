<?php
require_once 'db.php';

if (isset($_POST['add'])) {

    $insert_todo = trim($_POST['title']);
    $insert_todo_script = $_POST['description'];
    $insert_todo_status_id = $_POST['status_id'];
    $user_id = $_POST['user_id'];

    echo $insert_todo;
    echo $insert_todo_script;
    echo $insert_todo_status_id;
    echo $user_id;

    if ($insert_todo == null || $insert_todo == '') {

        header('Location:' . $_SERVER['HTTP_REFERER']);
    } else {
        $sql = "INSERT INTO tasks(title, description, status_id, user_id)
        VALUES (:title, :description, :status_id, :user_id)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':title', $insert_todo);
        $stmt->bindParam(':description', $insert_todo_script);
        $stmt->bindParam(':status_id', $insert_todo_status_id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        header("Location: read.php?user_id=$user_id");
    }
}
