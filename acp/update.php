<?php
  include("check_permissions.php");

  if (isset($_POST["site-title"])) {
    $mysql->query("UPDATE `settings` SET `site-title` = '".$_POST["site-title"]."' WHERE id=1");
  }

  if (isset($_POST["browser-title"])) {
    $mysql->query("UPDATE `settings` SET `browser-title` = '".$_POST["browser-title"]."' WHERE id=1");
  }

  if (isset($_POST["site-description"])) {
    $mysql->query("UPDATE `settings` SET `site-description` = '".$_POST["site-description"]."' WHERE id=1");
  }

  if (isset($_POST["site-keywords"])) {
    $mysql->query("UPDATE `settings` SET `site-keywords` = '".$_POST["site-keywords"]."' WHERE id=1");
  }

  if (isset($_POST["site-logo"])) {
    $mysql->query("UPDATE `settings` SET `site-logo` = '".$_POST["site-logo"]."' WHERE id=1");
  }

  if (isset($_POST["favicon"])) {
    $mysql->query("UPDATE `settings` SET `favicon` = '".$_POST["favicon"]."' WHERE id=1");
  }

  if(isset($_SERVER['HTTP_REFERER'])) {
    header("Location: ".$_SERVER['HTTP_REFERER']);
  } else {
    header("Location: settings.php");
  }

  exit();
?>
