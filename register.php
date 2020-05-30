<?php
require_once 'db.php';
session_start();
$_SESSION['message'] = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($_POST['password'] == $_POST['confirmpassword']) {
        print_r($_FILES);
        die;
        $username = htmlspecialchars($_POST['username']);
        $email = htmlspecialchars($_POST['email']);
        $password = md5($_POST['password']);
        $avatar_path = htmlspecialchars('image/' . $_FILES['avatar']['name']);


        if (preg_match("!image!", $_FILES['avatar']['type'])) {

            if (copy($_FILES['avatar']['tmp_name'], $avatar_path)) {

                $_SESSION['username'] = $username;
                $_SESSION['avatar'] = $avatar_path;
                $_SESSION['password'] = $password;
                $_SESSION['email'] = $email;

                $sql = "INSERT INTO users (username, email, password, avatar)"
                    . "VALUES ('$username', '$email', '$password', '$avatar_path')";

                $stmt = $db->prepare($sql);
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':avatar', $avatar_path);
                $stmt->execute();


                header('Location:readStart.php');
            } else {
                $_SESSION['message'] = "File upload failed";
            }
        } else {
            $_SESSION['message'] = "Please only upload GIF, JPG, JPEG or PNG 
            image that does not exceed 4MB !";
        }
    } else {
        $_SESSION['message'] = "Password do not match!";
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
        <a class="regLink" href="register.php">Create one for free</a>
        <p class="regText">If you already have an account, just log in </p>
        <a class="logLinkReg" href="login.php"> here </a>

    </section>

    <div class="register">
        <form class="login" action="register.php" method="POST" enctype="multipart/form-data" autocomplete="off">
            <div class="alert alert_error"><?= $_SESSION['message'] ?></div>
            <div id="noInput"></div>
            <input class="box box_username" id="box_username" type="text" placeholder="Username" name="username" required>
            <div id="noMail"></div>
            <input class="box" id="box_email" type="email" placeholder="Email" name="email" required>
            <div id="noPass"></div>
            <input class="box" id="box_password" type="password" placeholder="Password" name="password" autocomplete="new_password" required>
            <input class="box" type="password" placeholder="Confirm Password" name="confirmpassword" autocomplete="new_password" required>
            <div class="avatar box"><label>Select your image: </label><input type="file" name="avatar" accept="image/*" required></div>
            <input class="box box_submit" id="box_submit" type="submit" value="Register" name="register">
        </form>
    </div>

    <script src="validateReg.js"></script>