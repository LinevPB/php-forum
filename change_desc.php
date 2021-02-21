<?php
  if (session_status() == PHP_SESSION_NONE)
    session_start();

  if (!(isset($_SESSION["logged"]) && ($_SESSION["logged"] == true))) {
    header("Location: index.php");
    exit();
  }

  include("auth/db.php");

  $mysql = new mysqli($server, $db_user, $db_password, $db_name);

  if (($mysql->connect_error)) {
    Header("Location: settings.php");
    exit();
  }

  include("auth/neut.php");

  $desc = "";

  if (isset($_POST["AccountDescription"])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $desc = neut($_POST["AccountDescription"]);
    }
  }

  $res = $mysql->query("UPDATE `users` SET `description` = '".$desc."' WHERE `users`.`id`=".$_SESSION["id"]);
  $_SESSION["descInfo"] = "Successfuly changed description!";

  Header("Location: settings.php");
  exit();
?>
