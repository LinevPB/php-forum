<?php
  if (session_status() == PHP_SESSION_NONE)
    session_start();

  if (!(isset($_SESSION["logged"]) && ($_SESSION["logged"] == true))) {
    header("Location: login.php");
    exit();
  }

  include ("auth/neut.php");
  include("auth/db.php");

  if ((!isset($_POST['thread-title'])) || (!isset($_POST['thread-content'])))
  {
    header("Location: new_thread.php");
    exit();
  }

  $title = "";
  $content = "";
  $catid = "";

  $date = new DateTime();

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = neut($_POST["thread-title"]);
    $content = neut($_POST["thread-content"]);
    $catid = neut($_GET["category_id"]);

  } else {
    Header("Location: new_thread.php");
    exit();
  }

  $mysql = new mysqli($server, $db_user, $db_password, $db_name);

  if (!($mysql->connect_error == 0)) {
    Header("Location: index.php");
    exit();
  }

  $result = $mysql->query('INSERT INTO threads(category_id, name, creator_id, date, views, lastPostTime)
   VALUES("'.$catid.'", "'.$title.'", "'.$_SESSION["id"].'", "'.$date->getTimestamp().'", "0", '.$date->getTimeStamp().')');

   $lastId = $mysql->insert_id;

  $result = $mysql->query('INSERT INTO posts(category_id, thread_id, poster_id, content, time)
   VALUES("'.$catid.'", "'.$lastId.'", "'.$_SESSION["id"].'", "'.$content.'", "'.$date->getTimestamp().'")');

  $mysql->query("UPDATE `threads` SET `creator_post` = '".$mysql->insert_id."' WHERE id=".$lastId);

  Header("Location: thread.php?id=".$lastId."&category_id=".$catid);

  echo $catid;
  echo $title."<br>";
  echo $content;
?>
