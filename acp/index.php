<!DOCTYPE html>

<?php

  include("check_permissions.php");

?>

<html>
<head>
  <title>Home | Admin Control Panel</title>

  <meta charset="utf-8">
  <link href="themes/default/main.css" rel="stylesheet">
  <link href="themes/default/index.css" rel="stylesheet">
  <link href="themes/default/table.css" rel="stylesheet">
</head>

<body>
  <?php
    include("navigation.php");
  ?>

  <div id="page-content">
    <div id="page-content-justify">
      <div id="page-header">
        Home
      </div>
      <div class="settingsWall">
        <div class="wall-content">
          <div class="wall-title">General settings</div>

          <div class="option">
            <div class="option checkbox-label">
              <input type="checkbox" name="maintenance" class="checkbox">
              <label for="maintenance" class="Label"> Enable maintance work</label>
            </div>
          </div>

          <input type="submit" value="Save" class="button">
        </div>
      </div>
    </div>
  </div>

</body>
</html>
