<!DOCTYPE html>

<html>
<head>
  <?php
    $title = "Edit post";
    include("head.php");
  ?>

  <link href="assets/themes/default/main.css" rel="stylesheet">
  <link href="assets/themes/default/new_thread.css" rel="stylesheet">
</head>

<body>
<?php
  include("navigation.php");
  include("auth/neut.php");

  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = neut($_GET["id"]);

  } else {
    Header("Location: index.php");
    exit();
  }

  include("auth/db.php");

  $mysql = new mysqli($server, $db_user, $db_password, $db_name);

  $result = $mysql->query("SELECT category_id, thread_id, content FROM posts WHERE id = ".$id);
  $cRow = $result->fetch_assoc();

  $res1 = $mysql->query("SELECT name FROM threads WHERE id = ".$cRow["thread_id"]);
  $res1 = $res1->fetch_assoc()["name"];

  $res2 = $mysql->query("SELECT title FROM categories WHERE id=".$cRow["category_id"]);
  $res2 = $res2->fetch_assoc()["title"];
?>

</body>
<div id="page-content">
  <div id="title">Edit: Post #<?php echo $id; ?></div>

  <div id="category-link">
    <a href="index.php">
      <?php echo "Home " ?>
    </a>
    <div class="category-slash">
      /
    </div>

    <a href="category.php?id=<?php echo $cRow["category_id"]; ?>">
      <?php echo $res2; ?>
    </a>

    <div class="category-slash">
      /
    </div>

    <a href="thread.php?id=<?php echo $cRow["thread_id"]."&category_id=".$cRow["category_id"]; ?>">
      <?php echo $res1; ?>
    </a>

    <div class="category-slash">
      /
    </div>

    <div id="category-link-rest">
      Post #<?php echo $id; ?>
    </div>
  </div>

  <form action="editpost_act.php?id=<?php echo $id ?>" method="post">
    <div id="postInfo">Post content</div>
    <textarea name="post-content" placeholder="Write your content here"><?php echo $cRow["content"]; ?></textarea>

    <input type="submit" value="Save post">
  </form>
</div>
</html>
