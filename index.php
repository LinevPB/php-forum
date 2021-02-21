<!DOCTYPE html>

<html>
<head>
  <?php
    $title = "Home";
    include("head.php");
    include("bbcode.php");
    include("time.php");
  ?>

  <link href="assets/themes/default/main.css" rel="stylesheet">
  <link href="assets/themes/default/index.css" rel="stylesheet">
</head>

<body>
  <?php
    include("navigation.php");
  ?>

  <?php
    include("announcements.php");
  ?>

  <div id="page-content">
    <?php
      include("displaycat.php");
    ?>
  </div>

  <?php
    include("online.php");
    include("footer.php");
  ?>

</body>
</html>
