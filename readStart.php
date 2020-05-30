<?php
require_once 'db.php';
require_once 'header.php';


session_start();
$username = $_SESSION['username'];
$password = $_SESSION['password'];
$email = $_SESSION['email'];
$avatar = $_SESSION['avatar'];


$sql5 = "SELECT * FROM users WHERE username = '$username' AND email = '$email' AND password = '$password'";
$stmt5 = $db->prepare($sql5);
$stmt5->execute();

while ($row5 = $stmt5->fetch(PDO::FETCH_ASSOC)) {
    $user_id = $row5['id'];
    $username = $row5['username'];
    $email = $row5['email'];
    $avatar = $row5['avatar'];
}

echo $navbar = " <nav>
                <div class='navContainer'>

                <h1 class='logoText'><span> $username </span>Trello</h1>
                <img src= $avatar class='avatar'>
                <a href='login.php'>Logout</a>

                </div>
                </nav>";


$sql1 = "SELECT * FROM task_status";
$stmt1 = $db->prepare($sql1);
$stmt1->execute();
$outputTaskBoard = "<div class='task-board'>";
echo $outputTaskBoard;

while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
    $id = $row['id'];
    $status_title = $row['status_title'];
    $task_status_id = $row['id'];
    $outputCard = "<div class='status-card'>
						<div class='firstTask'>
							<input type='hidden' value='$task_status_id'>
								<div class='card-header'>
									<span class='card-header-text'>$status_title </span>
								</div>
							<ul class='sortable ui-sortable container' value='$task_status_id' id='sort'>
								<input type='hidden' value='$task_status_id'>
						";
    echo $outputCard;

    $ulClose = "</ul></div>";
    echo $ulClose;

    echo $span = " <p class='toggle addNewTask' data-index='<?= $task_status_id; ?>' > <span> + </span> Add new task</p>";

    echo $form = "<div class='formInput' id='hide' data-index='<?= $task_status_id; ?>'>
		<form action='newTodo.php?id=$id' method='POST'>
			 <div class='errorMessage' id='$task_status_id'>Minnst 1 tecken</div>
			<input class='addNewTitle' id='$task_status_id type='text' name='title' placeholder='Task title' title='Please enter your task title!'>
			<textarea class='addNewDes' rows='4' cols='50' name='description' placeholder='Description'></textarea>
            <input type='hidden' name='status_id' value=$task_status_id>
            <input type='hidden' name='user_id' value=$user_id>
			<button class='addNewBtn' type='submit' name='add' value='Add'>Add</button>
		</form>
	</div>";

    $outputCardDiv = "</div>";
    echo $outputCardDiv;
} //Stängning för Container

$outputTaskBoard = "</div>";
echo $outputTaskBoard;
?>

<script src="trello.js"></script>
</body>

</html>