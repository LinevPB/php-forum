<?php
  include("check_permissions.php");

  include ("../auth/neut.php");

  if ((!isset($_GET["id"])))
	{
		header("Location: users.php");
		exit();
	}

  $id = -1;

  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = neut($_GET["id"]);
  } else {
    Header("Location: users.php");
    exit();
  }

  $mquery = "UPDATE `users` SET `blocked`='";

  $results = $mysql->query("SELECT blocked FROM users WHERE id=".$id);
  $result2 = $results->fetch_assoc();

  if ($result2["blocked"] == 0) {
    $mquery .= "1";
  } else {
    $mquery .= "0";
  }

  $mquery .= "' WHERE `id`=".$id;

  $result = $mysql->query($mquery);

  $mysql->close();

  if(isset($_GET["act"])) {

    if ($_GET["act"] == "thread")
      header("Location: threads.php");
    else if ($_GET["act"] == "post")
      header("Location: posts.php");

    exit();
  }

  header("Location: users.php");
  exit();
?>
