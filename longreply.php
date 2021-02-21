<!DOCTYPE html>

<html>
<head>
  <?php
    $title = "Thread reply";
    include("head.php");
  ?>

  <link href="assets/themes/default/main.css" rel="stylesheet">
  <link href="assets/themes/default/new_thread.css" rel="stylesheet">
</head>

<body>
<?php
  include("navigation.php");
  include("auth/neut.php");

  if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = neut($_GET["id"]);

    if (isset($_GET["post"]))
      $post = neut($_GET["post"]);

  } else {
    Header("Location: index.php");
    exit();
  }

  include("auth/db.php");

  $mysql = new mysqli($server, $db_user, $db_password, $db_name);
  $content = "";

  if (isset($_GET["post"])) {
    $post = $_GET["post"];

    $result = $mysql->query("SELECT poster_id, content FROM posts WHERE id = ".$post);
    $cRow = $result->fetch_assoc();
    $poster = $mysql->query("SELECT username FROM users WHERE id = ".$cRow["poster_id"]);
    $poster = $poster->fetch_assoc()["username"];

    $content = '[quote='.$poster.']'.$cRow["content"].'[/quote]
';
  }

  $res1 = $mysql->query("SELECT name, category_id FROM threads WHERE id = ".$id);
  $res1 = $res1->fetch_assoc();

  $res2 = $mysql->query("SELECT title FROM categories WHERE id=".$res1["category_id"]);
  $res2 = $res2->fetch_assoc()["title"];
?>

</body>
<div id="page-content">
  <div id="title">Posting in: <?php echo $res1["name"]; ?></div>

  <div id="category-link">
    <a href="index.php">
      <?php echo "Home " ?>
    </a>
    <div class="category-slash">
      /
    </div>

    <a href="category.php?id=<?php echo $res1["category_id"]; ?>">
      <?php echo $res2; ?>
    </a>

    <div class="category-slash">
      /
    </div>

    <a href="thread.php?id=<?php echo $id."&category_id=".$res1["category_id"]; ?>">
      <?php echo $res1["name"]; ?>
    </a>

    <div class="category-slash">
      /
    </div>

    <div id="category-link-rest">
      New post
    </div>
  </div>

  <form action="reply.php?thread_id=<?php echo $id ?>&category_id=<?php echo $res1["category_id"]; ?>" method="post">
    <div id="postInfo">Post content</div>
    <textarea name="reply-content" placeholder="Write your content here"><?php
      if (isset($_GET["post"])) {
        echo $content;
      }
    ?></textarea>

    <input type="submit" value="Reply">
  </form>
</div>
</html>
