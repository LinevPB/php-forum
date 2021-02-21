<?php
  include("auth/db.php");

  $mysql = new mysqli($server, $db_user, $db_password, $db_name);

  $result = $mysql->query("SELECT * FROM `settings`");

  $HeadRow = $result->fetch_assoc();

  if (session_status() == PHP_SESSION_NONE)
    session_start();

  if (isset($_SESSION["id"])) {
    $date = new DateTime();
    $ls = $mysql->query("UPDATE `users` SET `lastSeen` = '".($date->getTimeStamp())."' WHERE id=".$_SESSION["id"]);
  }
?>

<meta charset="utf-8">
<title><?php echo $title." | ".$HeadRow["site-title"]." - ".$HeadRow["browser-title"]; ?></title>
<meta name="description" content="<?php echo $HeadRow["site-description"] ?>">
<meta name="keywords" content="<?php echo $HeadRow["site-keywords"] ?>">
<link rel="shortcut icon" href="<?php echo $HeadRow["favicon"]; ?>">
