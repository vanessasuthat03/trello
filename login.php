<?php
require_once 'db.php';

session_start();
$_SESSION['message'] = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = md5($_POST['password']);

    $_SESSION['message'] = 'Incorrect username, email and / or password.';


    $sql = "SELECT * FROM users WHERE username = '$username' AND email = '$email' AND password = '$password'";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $user_id = $row['id'];
        $username = $row['username'];
        $email = $row['email'];
        $password = $row['password'];

        echo $user_id;
        echo $username;
        echo $email;
        echo $password;
        header("Location: read.php?user_id=$user_id");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./style/style.css">
    <title>My Trello</title>
</head>

<body>
    <nav>
        <div class="navContainer">

            <h1 class="logoText"><span>Vanessas</span>Trello</h1>


        </div>
    </nav>


    <section class="welcomeSection">
        <h1>Welcome to Vanessas Trello!</h1>
        <a class="logLink" href="login.php">Log in</a>
        <p class="regText">New to Trello?</p>
        <a class="logLinkReg" href="register.php">Create one for free</a>

    </section>

    <div class="register">
        <form class="login" action="login.php" method="POST" enctype="multipart/form-data" autocomplete="off" required>
            <div class="alert alert_error box"><?= $_SESSION['message'] ?></div>
            <div id="noInput"></div>
            <input class="box box_username" id="box_username" type="text" placeholder="Username" name="username" title="Please fill in your username" required>
            <div id="noMail"></div>
            <input class="box" id="box_email" type="email" placeholder="Email" name="email" required>
            <div id="noPass"></div>
            <input class="box" id="box_password" type="password" placeholder="Password" name="password" autocomplete="new_password" required>
            <input class="box box_submit" id="box_submit" type="submit" value="Login" name="login" class="loginSubBtn">
        </form>
    </div>
</body>
<script src="validateReg.js"></script>