<!DOCTYPE html>

<?php
  include("check_permissions.php");

  $isFirst = false;

  if (!isset($_POST["Edit"]) && !isset($_POST["Save"]) && !isset($_POST["Delete"]) && isset($_SESSION["group-id"])) {
    unset($_SESSION["group-id"]);
  }

  if (isset($_POST["Edit"])) {
    if (isset($_POST["group"])) {
      $isFirst = true;

      $res = $mysql->query("SELECT * FROM `groups` WHERE id=".$_POST["group"]);

      $firstVal = $res->fetch_assoc();
      $_SESSION["group-id"] = $firstVal["id"];

      unset($_POST["group"]);
    }

    unset($_POST["Edit"]);
  }

  if (isset($_POST["Save"])) {
    if (isset($_SESSION["group-id"])) {
      $res = $mysql->query("UPDATE `groups` SET `name` = '".$_POST['group-name']."', `background-color` = '".$_POST['group-bgcolor']."', `color` = '".$_POST['group-color']."', `special` = '".$_POST['group-special']."' WHERE `id`=".$_SESSION["group-id"]);

      $res2 = $mysql->query("SELECT * from `groups` WHERE id=".$_SESSION["group-id"]);
      $isFirst = true;
      $firstVal = $res2->fetch_assoc();

      $_SESSION["success-edit"] = "<div class='success-edit'>Group has been edited successfuly.</div>";
    }
    unset($_POST["Save"]);
  }

  if (isset($_POST["createGroup"])) {
    if (isset($_POST["cgroup-name"]) && isset($_POST["cgroup-bgcolor"]) && isset($_POST["cgroup-color"]) && isset($_POST["cgroup-special"])) {
      $res = $mysql->query("INSERT INTO groups (name, `background-color`, color, special) VALUES ('".$_POST["cgroup-name"]."', '".$_POST["cgroup-bgcolor"]."', '".$_POST["cgroup-color"]."', '".$_POST["cgroup-special"]."')");
      unset($_POST["createGroup"]);

      $_SESSION["success-edit"] = "<div class='success-edit'>Group has been created successfuly.</div>";
    }
  }

  if (isset($_POST["Delete"])) {
    if (isset($_POST["group"])) {

      $result = $mysql->query("DELETE FROM groups WHERE id=".$_POST["group"]);

      $_SESSION["success-edit"] = "<div class='success-edit'>Group has been removed successfuly.</div>";
    }

    unset($_POST["Delete"]);

    Header("Location: groups.php");
    exit();
  }
?>

<html>
<head>
  <title>Groups | Admin Control Panel</title>

  <meta charset="utf-8">
  <link href="themes/default/main.css" rel="stylesheet">
  <link href="themes/default/index.css" rel="stylesheet">
  <link href="themes/default/table.css" rel="stylesheet">
</head>

<body>
  <?php
    include("navigation.php");

    $result = $mysql->query("SELECT * FROM `groups`");
  ?>

  <div id="page-content">
    <div id="page-content-justify">
      <div id="page-header">
        Groups
      </div>
      <div class="settingsWall">
        <div class="wall-content">
          <div class="wall-title">Edit a group</div>
          <form method="post" action="groups.php">
            <select name="group" class="select-group textInput">
              <?php
                while($row = $result->fetch_assoc()) {
                  if (!$isFirst) {
                    $isFirst = true;
                    $firstVal = $row;
                  }

                  echo '<option value="'.$row["id"].'" ';

                  if ($row["id"] == $firstVal["id"])
                    echo "selected";

                  echo '>'.$row["name"].'</option>';
                }
              ?>
            </select>

            <div class="grouped-inputs">
              <input type="submit" value="Edit" name="Edit" class="button ingr-input">
              <input type="submit" id="edit-button" value="Delete" name="Delete" class="button ingr-input">
            </div>
          </form>

          <?php
            if (isset($_SESSION["success-edit"])) {
              echo $_SESSION["success-edit"];
              unset($_SESSION["success-edit"]);

              if (isset($_SESSION["group-id"]))
                unset($_SESSION["group-id"]);
            } else {
              if (isset($_SESSION["group-id"])) {
                include("groups_edit.php");
              }
            }
          ?>
        </div>
      </div>

      <div class="settingsWall">
        <div class="wall-content">
          <div class="wall-title">Create a group</div>

          <form action="groups.php" method="post">
            <div class="option">
              <div class="title">Name</div>
              <input type="text" class="textInput" name="cgroup-name" placeholder="Name of a group">
            </div>

            <div class="option">
              <div class="title">Background color</div>
              <input type="text" class="textInput" name="cgroup-bgcolor" placeholder="Color in HEX value">
            </div>

            <div class="option">
              <div class="title">Color</div>
              <input type="text" class="textInput" name="cgroup-color" placeholder="Font color in HEX value">
            </div>

            <div class="option">
              <div class="title">Special</div>
              <select name="cgroup-special" class="special textInput">
                <option value="0">No</option>
                <option value="1">Yes</option>
              </select>
            </div>

            <input type="submit" name="createGroup" value="Create" class="button">
          </form>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
