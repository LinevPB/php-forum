<?php
  if (session_status() == PHP_SESSION_NONE)
    session_start();

  if (!(isset($_SESSION["logged"]) && ($_SESSION["logged"] == true))) {
    header("Location: login.php");
    exit();
  }

  include ("auth/neut.php");
  include("auth/db.php");

  if (!(isset($_POST["reply-content"]) && (isset($_GET["category_id"])) && (isset($_GET["thread_id"]))))
  {
    header("Location: index.php");
    exit();
  }

  $title = "";
  $content = "";
  $catid = "";
  $pid = "";

  $date = new DateTime();

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $content = neut($_POST["reply-content"]);
    $catid = neut($_GET["category_id"]);
    $pid = neut($_GET["thread_id"]);

  } else {
    Header("Location: index.php");
    exit();
  }

  //$content = transformBBCode($content);

  $mysql = new mysqli($server, $db_user, $db_password, $db_name);

  if (!($mysql->connect_error == 0)) {
    Header("Location: index.php");
    exit();
  }

  $result = $mysql->query('INSERT INTO posts(category_id, thread_id, poster_id, content, time)
   VALUES("'.$catid.'", "'.$pid.'", "'.$_SESSION["id"].'", "'.$content.'", "'.$date->getTimestamp().'")');

  Header("Location: thread.php?id=".$pid."&category_id=".$catid."#post".$mysql->insert_id);

  $result2 = $mysql->query("UPDATE `threads` SET `lastPostTime` = '".$date->getTimestamp()."' WHERE `threads`.`id` = ".$pid);
  $result3 = $mysql->query("UPDATE `users` SET `postsCount` = `postsCount` + 1 WHERE `users`.`id` = ".$_SESSION["id"]);

  exit();
?>
