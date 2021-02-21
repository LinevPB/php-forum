<?php
  include("check_permissions.php");

  include ("../auth/neut.php");

  if ((!isset($_GET["id"])))
	{
		header("Location: users.php");
		exit();
	}

  $mysql = new mysqli($server, $db_user, $db_password, $db_name);

  if ($mysql->connect_error) {
    Header("Location: users.php");
    exit();
  }

  $id = -1;

  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = neut($_GET["id"]);
  } else {
    Header("Location: users.php");
    exit();
  }

  $mquery = "UPDATE `users` SET `blocked`='2' WHERE `id`=".$id;

  $result = $mysql->query($mquery);

  $mysql->close();

  header("Location: users.php");
  exit();
?>
