<?php
  include("auth/db.php");
  include("auth/neut.php");

  if (session_status() == PHP_SESSION_NONE)
    session_start();

    if (!(isset($_SESSION["logged"]) && ($_SESSION["logged"] == true))) {
      header("Location: index.php");
      exit();
    }

    $mysql = new mysqli($server, $db_user, $db_password, $db_name);

    if ($mysql->connect_error) {
      Header("Location: settings.php");
      exit();
    }

    if(!(isset($_POST["oldPass"]) && isset($_POST["newPass"]) && isset($_POST["newPass2"]))) {
      $_SESSION["passChangeInfo"] = "Please fill all the boxes!";
      Header("Location: settings.php");
      exit();
    }

    $oldPass = $newPass = $newPass2 = "";

    if($_SERVER["REQUEST_METHOD"] == "POST") {
      $oldPass = neut($_POST["oldPass"]);
      $newPass = neut($_POST["newPass"]);
      $newPass2 = neut($_POST["newPass2"]);
    }

    $res = $mysql->query("SELECT password FROM users WHERE id=".$_SESSION["id"]);
    $pas = $res->fetch_assoc();

    if ($pas["password"] == $oldPass) {
      if ($newPass == $newPass2) {
        if ($newPass != "") {
          $res1 = $mysql->query("UPDATE `users` SET `password` = '".$newPass."' WHERE `users`.`id`=".$_SESSION["id"]);
        } else {
          $_SESSION["passChangeInfo"] = "Please fill all the boxes!";
          Header("Location: settings.php");
          exit();
        }
      } else {
        $_SESSION["passChangeInfo"] = "Passwords are not the same!";
        Header("Location: settings.php");
        exit();
      }
    } else {
      $_SESSION["passChangeInfo"] = "Passwords are incorrect!";
      Header("Location: settings.php");
      exit();
    }

    $_SESSION["passChangeInfo"] = "Password changed successfuly!";
    Header("Location: settings.php");
    exit();
?>
