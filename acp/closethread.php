<?php
  include("check_permissions.php");

  include ("../auth/neut.php");

  if ((!isset($_GET["id"])))
	{
		header("Location: threads.php");
		exit();
	}

  $mysql = new mysqli($server, $db_user, $db_password, $db_name);

  if ($mysql->connect_error) {
    Header("Location: threads.php");
    exit();
  }

  $id = -1;

  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = neut($_GET["id"]);
  } else {
    Header("Location: threads.php");
    exit();
  }

  $mquery = "UPDATE `threads` SET `active`='";

  $results = $mysql->query("SELECT active FROM threads WHERE id=".$id);
  $result2 = $results->fetch_assoc();

  if ($result2["active"] == 0) {
    $mquery .= "1";
  } else {
    $mquery .= "0";
  }

  $mquery .= "' WHERE `id`=".$id;

  $result = $mysql->query($mquery);

  $mysql->close();

  header("Location: threads.php");
  exit();
?>
