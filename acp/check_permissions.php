<?php
  if (session_status() == PHP_SESSION_NONE)
    session_start();

  if(!isset($_SESSION["logged"])) {
    Header("Location ../index.php");
    exit();
  }

  if (!isset($_SESSION["id"])) {
    header("Location: ../index.php");
    exit();
  }

  include("../auth/db.php");

  $mysql = new mysqli($server, $db_user, $db_password, $db_name);

  if ($mysql->connect_error) {
    Header("Location: ../index.php");
    exit();
  }

  $PERMISSIONS = $mysql->query("SELECT groupID FROM users WHERE id=".$_SESSION["id"]);

  if ($PERMISSIONS->num_rows == 0) {
    Header("Location: ../index.php");
    exit();
  }

  $PERMISSIONS = $PERMISSIONS->fetch_assoc()["groupID"];

  $PERMISSION = $mysql->query("SELECT permissions FROM groups WHERE id=".$PERMISSIONS);

  if ($PERMISSION->num_rows == 0) {
    Header("Location: ../index.php");
    exit();
  }

  $PERMISSION = $PERMISSION->fetch_assoc()["permissions"];

  if ($PERMISSION < 5) {
    Header("Location: ../index.php");
    exit();
  }
?>
