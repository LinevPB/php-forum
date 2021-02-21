<?php
  include("check_permissions.php");

  include ("../auth/neut.php");

  if ((!isset($_POST["user-name"])) || (!isset($_POST["user-email"])) || (!isset($_POST["user-password"]))
   || (!isset($_POST["user-avatar"])) || (!isset($_POST["user-group"])) || (!isset($_POST["user-description"])))
	{
		header("Location: users.php");
		exit();
	}

  $mysql = new mysqli($server, $db_user, $db_password, $db_name);

  if ($mysql->connect_error) {
    Header("Location: users.php");
    exit();
  }

  $username = $email = $password = $avatar = $group = $desc = $blocked = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = neut($_POST["user-name"]);
    $email = neut($_POST["user-email"]);
    $password = neut($_POST["user-password"]);
    $avatar = neut($_POST["user-avatar"]);
    $group = neut($_POST["user-group"]);
    $desc = neut($_POST["user-description"]);

    if (isset($_POST["blocked"]))
      $blocked = 1;
    else
      $blocked = 0;

    $id = neut($_GET["id"]);
  } else {
    Header("Location: users.php");
    exit();
  }

  $mquery = "UPDATE `users` SET `username`='".$username."', `email`='".$email."', `avatar`='".$avatar."', `groupID`='".$group."', `description`='".$desc."', `blocked`='".$blocked."'";
  if ($password != "")
    $mquery .= ", `password`='".$password."'";

  $mquery .= " WHERE `id`=".$id;

  $result = $mysql->query($mquery);

  $mysql->close();

  header("Location: edituser.php?id=".$id);
  exit();
?>
