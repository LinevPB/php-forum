<!DOCTYPE html>

<?php
  include ("auth/neut.php");
  include("navigation.php");

  include("auth/db.php");

  $mysql = new mysqli($server, $db_user, $db_password, $db_name);

  if ($mysql->connect_error) {
    return;
  }

  $catid = "";

  if (isset($_GET["id"])) {
    $catid = neut($_GET["id"]);
  } else {
    return;
  }

  $sql = "SELECT * FROM categories WHERE id=".$catid;

  $result = $mysql->query($sql);

  $row = $result->fetch_assoc();
?>

<head>
  <?php
    $title = $row["title"];
    include("head.php");
  ?>

  <link href="assets/themes/default/main.css" rel="stylesheet">
  <link href="assets/themes/default/category.css" rel="stylesheet">
</head>
<body>

  <div id="page-content">
    <div id="category-link">
      <a href="index.php">
        <?php echo "Home " ?>
      </a>
      <div class="category-slash">
        /
      </div>

      <div id="category-link-rest">
        <?php
          echo $row["title"];
        ?>
      </div>
    </div>

    <?php
      echo '<a href="new_thread.php?category_id='.$catid.'">
        <div id="input">+ New Thread</div>
      </a>';
    ?>

    <div id="category-name">
      <?php
        echo $row["title"];
      ?>
    </div>

    <?php
      include("displaythread.php");
    ?>
  </div>
</body>
</html>
