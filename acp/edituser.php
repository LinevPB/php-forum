<!DOCTYPE html>

<?php
  include("check_permissions.php");
?>

<html>
<head>
  <title>Edit User | Admin Control Panel</title>

  <meta charset="utf-8">
  <link href="themes/default/main.css" rel="stylesheet">
  <link href="themes/default/index.css" rel="stylesheet">
  <link href="themes/default/table.css" rel="stylesheet">
</head>

<body>
  <?php
    include("navigation.php");

    $result = $mysql->query("SELECT * FROM `users` WHERE id=".$_GET["id"]);
    $row = $result->fetch_assoc();

    $result2 = $mysql->query("SELECT id, name FROM `groups`");
  ?>

  <div id="page-content">
    <div id="page-content-justify">
      <div id="page-header">
        Edit User
      </div>

      <div class="settingsWall">
        <div class="wall-content">
          <div class="wall-title">Editing: <?php echo $row["username"]; ?></div>

          <form method="post" action="edituseract.php?id=<?php echo $row["id"]; ?>">
            <div class="option">
              <div class="title">Username</div>
              <input type="text" class="textInput" name="user-name" value="<?php echo $row["username"]; ?>">
            </div>

            <div class="option">
              <div class="title">E-mail</div>
              <input type="text" class="textInput" name="user-email" value="<?php echo $row["email"]; ?>">
            </div>

            <div class="option">
              <div class="title">Password</div>
              <input type="password" class="textInput" name="user-password" value="" placeholder="Password is not shown">
            </div>

            <div class="option">
              <div class="title">Avatar</div>
              <input type="text" class="textInput" name="user-avatar" value="<?php echo $row["avatar"]; ?>">
            </div>

            <div class="option">
              <div class="title">Group</div>
              <select name="user-group" class="special textInput">
                <?php
                  while($gRow = $result2->fetch_assoc()) {
                    echo '
                      <option value="'.$gRow["id"].'"';
                      if ($gRow["id"] == $row["groupID"])
                        echo 'selected';
                      echo '>'.$gRow["name"].'</option>
                    ';
                  }
                ?>
              </select>
            </div>

            <div class="option">
              <div class="title">Description</div>
              <input type="text" class="textInput" name="user-description" value="<?php echo $row["description"]; ?>">
            </div>

            <div class="option checkbox-label">
              <input id="blocked" name="blocked" class="checkbox" type="checkbox" <?php if ($row["blocked"] == 1) echo 'checked'; ?>>
              <label for="blocked" class="Label">Blocked</label>
            </div>

            <div class="grouped-inputs">
              <input type="submit" value="Save" name="Save" class="button ingr-input">
              <a href="users.php" class="ingr-input"><div class="button">Cancel</div></a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
