<!DOCTYPE html>

<?php

  include("check_permissions.php");

?>

<html>
<head>
  <title>Settings | Admin Control Panel</title>

  <meta charset="utf-8">

  <link href="themes/default/main.css" rel="stylesheet">
  <link href="themes/default/index.css" rel="stylesheet">
</head>

<body>
  <?php
    include("navigation.php");

    $result = $mysql->query("SELECT * FROM `settings`");
    $row = $result->fetch_assoc();
  ?>

  <div id="page-content">
    <div id="page-content-justify">
      <div id="page-header">
        Settings
      </div>
      <div class="settingsWall">
        <form class="wall-content" action="update.php" method="POST">
          <div class="option">
            <div class="title">Site Title</div>
            <input type="text" class="textInput" name="site-title" value="<?php echo htmlspecialchars($row["site-title"]); ?>">
          </div>

          <div class="option">
            <div class="title">Browser Title</div>
            <input type="text" class="textInput" name="browser-title" value="<?php echo $row["browser-title"]; ?>">
          </div>

          <div class="option">
            <div class="title">Site Description</div>
            <input type="text" class="textInput" name="site-description" value="<?php echo $row["site-description"]; ?>">
          </div>

          <div class="option">
            <div class="title">Site Keywords</div>
            <input type="text" class="textInput" name="site-keywords" placeholder="Keywords describing your community, comma-separated"
              value="<?php echo $row["site-keywords"]; ?>">
          </div>

          <div class="option">
            <div class="title">Site Logo</div>
            <input type="text" class="textInput"  name="site-logo" value="<?php echo htmlspecialchars($row["site-logo"]); ?>">
          </div>

          <div class="option">
            <div class="title">Favicon</div>
            <input type="text" class="textInput"  name="favicon" value="<?php echo $row["favicon"]; ?>">
          </div>

          <input type="submit" value="Save" class="button">
        </form>
      </div>
    </div>
  </div>
</body>
</html>
