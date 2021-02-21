<!DOCTYPE html>

<?php
  include("check_permissions.php");

  $mysql = new mysqli($server, $db_user, $db_password, $db_name);
?>

<html>
<head>
  <title>Edit Thread | Admin Control Panel</title>

  <meta charset="utf-8">
  <link href="themes/default/main.css" rel="stylesheet">
  <link href="themes/default/index.css" rel="stylesheet">
  <link href="themes/default/table.css" rel="stylesheet">
</head>

<body>
  <?php
    include("navigation.php");

    $result = $mysql->query("SELECT * FROM `threads` WHERE id=".$_GET["id"]);
    $row = $result->fetch_assoc();

    $result2 = $mysql->query("SELECT * FROM `categories`");
  ?>

  <div id="page-content">
    <div id="page-content-justify">
      <div id="page-header">
        Edit Thread
      </div>

      <div class="settingsWall">
        <div class="wall-content">
          <div class="wall-title">Editing: <?php echo $row["name"]; ?></div>

          <form method="post" action="editthreadact.php?id=<?php echo $row["id"]; ?>">
            <div class="option">
              <div class="title">Title</div>
              <input type="text" class="textInput" name="thread-name" value="<?php echo $row["name"]; ?>">
            </div>

            <div class="option">
              <div class="title">Category</div>
              <select name="thread-category" class="special textInput">
                <?php
                  while($gRow = $result2->fetch_assoc()) {
                    echo '
                      <option value="'.$gRow["id"].'"';
                      if ($gRow["id"] == $row["category_id"])
                        echo 'selected';
                      echo '>'.$gRow["title"].'</option>
                    ';
                  }
                ?>
              </select>
            </div>

            <div class="option checkbox-label">
              <input id="blocked" name="blocked" class="checkbox" type="checkbox" <?php if ($row["active"] == 0) echo 'checked'; ?>>
              <label for="blocked" class="Label">Closed</label>
            </div>

            <div class="grouped-inputs">
              <input type="submit" value="Save" name="Save" class="button ingr-input">
              <a href="threads.php" class="ingr-input"><div class="button">Cancel</div></a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
