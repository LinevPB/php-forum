<?php
  if (session_status() == PHP_SESSION_NONE)
    session_start();

  if (!(isset($_SESSION["logged"]) && ($_SESSION["logged"] == true))) {
    header("Location: index.php");
    exit();
  }

  include("auth/db.php");

  $mysql = new mysqli($server, $db_user, $db_password, $db_name);

  $date = new DateTime();
  $newdate = $date->getTimestamp();
  $targetDir = "assets/images/";
  $fileName = basename(md5($newdate.$_FILES["file"]["name"].$_SESSION["username"]).$_FILES["file"]["name"]);
  $targetFilePath = $targetDir . $fileName;
  $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

  if(isset($_POST["submit"]) && !empty($_FILES["file"]["name"])){
    $allowTypes = array('jpg','png','jpeg','gif','pdf');
        if(in_array($fileType, $allowTypes)){
            if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
                $insert = $mysql->query("INSERT into images (filename, date) VALUES ('".$fileName."', ".$newdate.")");
                if($insert){
                    $res = $mysql->query("UPDATE `users` SET `avatar` = '".$targetFilePath."' WHERE `users`.`id`=".$_SESSION["id"]);
                    $statusMsg = "The file has been uploaded successfully.";
                }else{
                    $statusMsg = "File upload failed, please try again.";
                }
            }else{
                $statusMsg = "Sorry, there was an error uploading your file.";
            }
        }else{
            $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
        }
    }else{
        $statusMsg = 'Please select a file to upload.';
    }

    $_SESSION["uploadInfo"] = $statusMsg;

    header("Location: settings.php");
    exit();
?>
