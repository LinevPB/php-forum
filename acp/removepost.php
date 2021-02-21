<?php
  include("check_permissions.php");

  include ("../auth/neut.php");

  if (!(isset($_GET["id"])))
	{
		header("Location: posts.php");
		exit();
	}

  $mysql = new mysqli($server, $db_user, $db_password, $db_name);

  if ($mysql->connect_error) {
    Header("Location: posts.php");
    exit();
  }

  $id = "";

  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = neut($_GET["id"]);
  } else {
    Header("Location: posts.php");
    exit();
  }

  //
    $mysql->query("UPDATE `posts` SET `active` = NOT `active` WHERE id = ".$id);
  //

  $mysql->close();

  header("Location: posts.php");
  exit();
?>
