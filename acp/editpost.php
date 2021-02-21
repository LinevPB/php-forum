<!DOCTYPE html>

<?php
  include("check_permissions.php");

  $mysql = new mysqli($server, $db_user, $db_password, $db_name);
?>

<html>
<head>
  <title>Edit Post | Admin Control Panel</title>

  <meta charset="utf-8">
  <link href="themes/default/main.css" rel="stylesheet">
  <link href="themes/default/index.css" rel="stylesheet">
  <link href="themes/default/table.css" rel="stylesheet">
</head>

<body>
  <?php
    include("navigation.php");

    $result = $mysql->query("SELECT * FROM `posts` WHERE id=".$_GET["id"]);
    $row = $result->fetch_assoc();
  ?>

  <div id="page-content">
    <div id="page-content-justify">
      <div id="page-header">
        Edit Post
      </div>

      <div class="settingsWall">
        <div class="wall-content">
          <div class="wall-title">Editing: Post #<?php echo $row["id"]; ?></div>

          <form method="post" action="editpostact.php?id=<?php echo $row["id"]; ?>">
            <div class="option">
              <div class="title">Content</div>
              <textarea class="textInput" name="post-content"><?php echo $row["content"]; ?></textarea>
            </div>

            <div class="grouped-inputs">
              <input type="submit" value="Save" name="Save" class="button ingr-input">
              <a href="posts.php" class="ingr-input"><div class="button">Cancel</div></a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
