<?php
  include("check_permissions.php");

  include ("../auth/neut.php");

  if ((!isset($_POST["thread-name"])) || (!isset($_POST["thread-category"])))
	{
		header("Location: threads.php");
		exit();
	}

  $mysql = new mysqli($server, $db_user, $db_password, $db_name);

  if ($mysql->connect_error) {
    Header("Location: threads.php");
    exit();
  }

  $threadname = $threadCategory = $active = $id = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $threadname = neut($_POST["thread-name"]);
    $threadCategory = neut($_POST["thread-category"]);

    if (isset($_POST["blocked"]))
      $active = 1;
    else
      $active = 0;

    $id = neut($_GET["id"]);
  } else {
    Header("Location: threads.php");
    exit();
  }

  //
    $mysql->query("UPDATE `threads` SET `category_id` = '".$threadCategory."' WHERE id = ".$id);
    $mysql->query("UPDATE `posts` SET `category_id` = '".$threadCategory."' WHERE thread_id = ".$id);
  //

  $mysql->close();

  header("Location: threads.php");
  exit();
?>
