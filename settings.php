<!DOCTYPE html>

<?php
  $bckg = "assets/images/account-background.jpg";

  if (session_status() == PHP_SESSION_NONE)
    session_start();

    if (!(isset($_SESSION["logged"]) && ($_SESSION["logged"] == true))) {
      header("Location: index.php");
      exit();
    }

    include ("auth/neut.php");
    include("auth/db.php");

    $mysql = new mysqli($server, $db_user, $db_password, $db_name);

    if ($mysql->connect_error) {
      $_SESSION["ERROR"] = "Server connection failed! Please try again later!";
      Header("Location: index.php");
      exit();
    }

    $sql = "SELECT * FROM users WHERE id=".$_SESSION["id"];

    $result = $mysql->query($sql);

    if (!($result->num_rows > 0)) {
      Header("Location: index.php");
      exit();
    }

    $row = $result->fetch_assoc();
?>

<html>
<head>
  <?php
    $title = "User Settings";
    include("head.php");
  ?>

  <link href="assets/themes/default/main.css" rel="stylesheet">
  <link href="assets/themes/default/user.css" rel="stylesheet">
</head>

<body>
  <?php
    include("navigation.php");
    echo '
      <div id="background-image" style="background-image: url('.$bckg.')">
      </div>
    ';
  ?>
  </div>

  <div id="user-avatar">
    <img src="<?php echo $row["avatar"]; ?>">
  </div>

  <div id="page-content">
    <div id="category-link">
      <a href="index.php">
        <?php echo "Home " ?>
      </a>
      <div class="category-slash">
        /
      </div>

      <a href="user.php?id=<?php echo $_SESSION['id']; ?>">
        <?php
          echo $row["username"];
        ?>
      </a>
      <div class="category-slash">
        /
      </div>

      <div id="category-link-rest">
        Settings
      </div>
    </div>

    <form class="settings-form" action="upload.php" enctype="multipart/form-data" method="POST">
      <div class="title">
        Change picture
      </div>

      <div class="wall">
        <input type="file" name="file">

        <?php
          if (isset($_SESSION["uploadInfo"])) {
            echo '<div class="desc">'.$_SESSION["uploadInfo"].'</div>';
            unset($_SESSION["uploadInfo"]);
          }
        ?>

        <input type="submit" class="submit-button" name="submit" value="Upload">
      </div>
    </form>

    <form class="settings-form" action="change_desc.php" method="POST">
      <div class="title">
        Description
      </div>

      <div class="wall">
        <input type="text" name="AccountDescription" value="<?php echo $row["description"]; ?>">

        <div class="desc">
          <?php
            if (isset($_SESSION["descInfo"])) {
              echo $_SESSION["descInfo"];
              unset($_SESSION["descInfo"]);
            } else {
              echo "Choose a description that will be shown on your profile.";
            }
          ?>
        </div>

        <input type="submit" class="submit-button" name="submit" value="Update">
      </div>
    </form>

    <form class="settings-form" action="change_pass.php" method="POST">
      <div class="title">
        Change password
      </div>

      <div class="wall">
        <input type="text" name="oldPass" placeholder="Old password">
        <input type="password" name="newPass" placeholder="New password">
        <input type="password" name="newPass2" placeholder="Repeat new password">

        <div class="desc">
          <?php
            if (isset($_SESSION["passChangeInfo"])) {
              echo $_SESSION["passChangeInfo"];
              unset($_SESSION["passChangeInfo"]);
            } else {
              echo "You can change your password.";
            }
          ?>
        </div>

        <input type="submit" class="submit-button" name="submit" value="Save">
      </div>
    </form>
  </div>
</body>
</html>
