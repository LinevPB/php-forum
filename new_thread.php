<!DOCTYPE html>

<html>
<head>
  <?php
    $title = "New thread";
    include("head.php");
  ?>

  <link href="assets/themes/default/main.css" rel="stylesheet">
  <link href="assets/themes/default/new_thread.css" rel="stylesheet">
</head>

<body>
<?php
  include("navigation.php");
  include("auth/neut.php");

  $catid = 0;

  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $catid = neut($_GET["category_id"]);

  } else {
    Header("Location: index.php");
    exit();
  }

  include("auth/db.php");

  $mysql = new mysqli($server, $db_user, $db_password, $db_name);

  $result = $mysql->query("SELECT title FROM categories WHERE id = ".$catid);
  $cRow = $result->fetch_assoc();
?>

</body>
<div id="page-content">
  <div id="title">New thread</div>

  <div id="category-link">
    <a href="index.php">
      <?php echo "Home " ?>
    </a>
    <div class="category-slash">
      /
    </div>

    <a href="category.php?id=<?php echo $catid; ?>">
      <?php echo $cRow["title"]; ?>
    </a>

    <div class="category-slash">
      /
    </div>

    <div id="category-link-rest">
      New thread
    </div>
  </div>

  <form action="createthread.php?category_id=<?php echo $catid ?>" method="post">
    <div id="titleInfo">Title</div>
    <input name="thread-title" type="text" placeholder="Write your title here">

    <div id="postInfo">Content</div>
    <textarea name="thread-content" placeholder="Write your content here"></textarea>

    <input type="submit" value="Create thread">
  </form>
</div>
</html>
