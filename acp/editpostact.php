<?php
  include("check_permissions.php");

  include ("../auth/neut.php");

  if ((!isset($_POST["post-content"])) || (!isset($_GET["id"])))
	{
		header("Location: posts.php");
		exit();
	}

  $mysql = new mysqli($server, $db_user, $db_password, $db_name);

  if ($mysql->connect_error) {
    Header("Location: posts.php");
    exit();
  }

  $content = $id = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $content = neut($_POST["post-content"]);
    $id = neut($_GET["id"]);
  } else {
    Header("Location: posts.php");
    exit();
  }

  //
    $mysql->query("UPDATE `posts` SET `content` = '".$content."' WHERE id = ".$id);
  //

  $mysql->close();

  header("Location: posts.php");
  exit();
?>
