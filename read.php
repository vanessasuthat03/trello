<?php
require_once 'db.php';
require_once 'header.php';



// tar bort notice för $id som finns i form action
error_reporting(E_ALL ^ E_NOTICE);
//
if (isset($_GET['user_id'])) {

	$user_id = $_GET['user_id'];
}


$sql5 = "SELECT * FROM users WHERE id = $user_id ";
$stmt5 = $db->prepare($sql5);
$stmt5->execute();

while ($row5 = $stmt5->fetch(PDO::FETCH_ASSOC)) {
	$username = $row5['username'];
	$avatar = $row5['avatar'];
}

echo $ReadNav = " <nav>
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
$idArr = [];
while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
	$idArr[] = $row['id'];
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


	$sql2 = "SELECT * FROM tasks WHERE status_id = :id AND user_id = '$user_id'";
	$stmt2 = $db->prepare($sql2);
	$stmt2->bindParam(":id", $row['id']);
	$stmt2->execute();

	while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {

		$id = $row2['id'];
		$titles = htmlspecialchars($row2['title']);
		$title = ucfirst($titles);
		$descriptions = htmlspecialchars($row2['description']);
		$description = ucfirst($descriptions);
		$status_id = $row2['status_id'];
		$created_at = $row2['created_at'];


		$outputTask = "<li class='list__card draggable' draggable='true' value='$id' >
							<input type='hidden' value='$status_id'>
							<p class='text-row'> $title </p>
							<p class='desText'> $description </p>
							<p> Created at $created_at </p>
							
							<a id='$id' class='updateBtn' href='#' value='$id'>Update</a>
							<a id='$id' class='deleteBtn' href='#' value='$id'>Delete</a>
							
						  </li>";
		echo $outputTask;

		$modal = "<div id='$id' class='bg_modal'>
						<div class='modal_content'>
							<div id='$id' class='close'>+</div>
							<img src='$avatar'>
							<form action='updateFromModal.php' method='POST' >
								<input type='text' class='modalInput' name='title' value='$title'>
								<textarea class='modalInput modalTextarea' rows='4' cols='50' name='description'>$description</textarea>
								<input type='hidden' name='id' value=$id>
								<input type='hidden' name='user_id' value=$user_id>
								<button class='modalBtn' type='submit' name='submitModal'>Update task</button>
							</form>
						</div>
					  </div>";

		echo $modal;

		$modalDelete = "<div id='$id' class='bg_modal_delete'>
		<div class='modal_content'>
			<div id='$id' class='closeDelete'>+</div>
			<img src='$avatar'>
				<p class='modalInput deleteModalInput' name='title' value='$title'>$title</p>
				<p class='modalInput modalTextarea deleteModalText' name='description'>$description</p>
				<input type='hidden' name='id' value=$id>
				<input type='hidden' name='user_id' value=$user_id>
				<a id='$id' class='deleteBtn deleteModelBtn' href='delete.php?id=$id&user_id=$user_id'>Delete</a>
		
		</div>
	  </div>";

		echo $modalDelete;
	} // SlutBracket för Kort


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