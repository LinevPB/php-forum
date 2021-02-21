<?php
  if (session_status() == PHP_SESSION_NONE)
    session_start();

  include("auth/db.php");
  include("auth/neut.php");

  $mysql = new mysqli($server, $db_user, $db_password, $db_name);

  if ((!isset($_POST["post-content"])) && (!isset($_GET["id"]))) {
    header("Location: index.php");
    exit();
  }

  $content = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $content = neut($_POST["post-content"]);
    $id = $_GET["id"];
  } else {
    header("Location: index.php");
    exit();
  }

  $mysql->query("UPDATE `posts` SET `content` = '".$content."' WHERE id=".$id);
  $res = $mysql->query("SELECT thread_id, category_id from posts WHERE id=".$id);
  $res = $res->fetch_assoc();

  $mysql->close();

  Header("Location: thread.php?id=".$res["thread_id"]."&category_id=".$res["category_id"]."#post".$id);
  exit();
?>
