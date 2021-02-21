<?php
  if (session_status() == PHP_SESSION_NONE)
    session_start();

  if (isset($_SESSION["logged"]) && ($_SESSION["logged"] == true)) {
    header("Location: ../index.php");
    exit();
  }

  include ("neut.php");
  include("db.php");

  if ((!isset($_POST['username'])) || (!isset($_POST['password'])))
	{
		header("Location: ../login.php");
		exit();
	}

  $mysql = new mysqli($server, $db_user, $db_password, $db_name);

  if ($mysql->connect_error) {
    $_SESSION["ERROR"] = "Server connection failed! Please try again later!";
    Header("Location: ../login.php");
    exit();
  }

  $username = $password = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = neut($_POST["username"]);
    $password = neut($_POST["password"]);
  } else {
    Header("Location: ../login.php");
    exit();
  }

  $sql = "SELECT * FROM users WHERE username='$username'";

  $result = $mysql->query($sql);

  if (!($result->num_rows > 0)) {
    $_SESSION["ERROR"] = "Login or password is incorrect!";
    Header("Location: ../login.php");
    exit();
  }

  $row = $result->fetch_assoc();

  if ($row["password"] == $password) {
    $_SESSION["logged"] = true;
    $_SESSION["id"] = $row["id"];
    $_SESSION["username"] = $row["username"];
    Header("Location: ../index.php");
    exit();
  } else {
    $_SESSION["ERROR"] = "Login or password is incorrect!";
    Header("Location: ../login.php");
    exit();
  }

  $mysql->close();
?>
