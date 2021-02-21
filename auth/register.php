<?php
  if (session_status() == PHP_SESSION_NONE)
    session_start();

  if (isset($_SESSION["logged"]) && ($_SESSION["logged"] == true)) {
    header("Location: ../index.php");
    exit();
  }

  include ("neut.php");
  include("db.php");

  if ((!isset($_POST['username'])) || (!isset($_POST['email'])) || (!isset($_POST['password'])) || (!isset($_POST['cpassword'])))
	{
		header("Location: ../register.php");
		exit();
	}

  $mysql = new mysqli($server, $db_user, $db_password, $db_name);

  if ($mysql->connect_error) {
    $_SESSION["ERROR"] = "Server connection failed! Please try again later!";
    Header("Location: ../register.php");
    exit();
  }

  $username = $password = $email = $cpassword = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = neut($_POST["username"]);
    $password = neut($_POST["password"]);
    $email = neut($_POST["email"]);
    $cpassword = neut($_POST["cpassword"]);
  } else {
    Header("Location: ../register.php");
    exit();
  }

  if (!($password == $cpassword)) {
    $_SESSION["ERROR"] = "Password are not the same!";
    Header("Location: ../register.php");
    exit();
  }

  $sql = "SELECT * FROM users WHERE (username='$username' OR email='$email')";

  $result = $mysql->query($sql);

  if (($result->num_rows > 0)) {
    $_SESSION["ERROR"] = "That account already exists!";
    Header("Location: ../register.php");
    exit();
  }

  $sql = "INSERT INTO users(username, email, password, avatar, groupID, postsCount) VALUES('$username', '$email', '$password', 'assets/images/default_avatar.jpg', 1, 0)";
  $result = $mysql->query($sql);

  $_SESSION["logged"] = true;
  $_SESSION["id"] = $mysql->insert_id;
  $_SESSION["username"] = $username;
  Header("Location: ../index.php");
  exit();

  $mysql->close();
?>
