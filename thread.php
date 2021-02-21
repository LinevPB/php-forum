<!DOCTYPE html>

<?php
  include ("auth/neut.php");
  $id = "";

  if (isset($_GET["id"])) {
    $id = neut($_GET["id"]);
  } else {
    Header("Location: index.php");
    exit();
  }

  include("auth/db.php");

  $mysql = new mysqli($server, $db_user, $db_password, $db_name);

  if ($mysql->connect_error) {
    Header("Location: index.php");
    exit();
  }

  $catid = "";

  if (isset($_GET["category_id"])) {
    $catid = neut($_GET["category_id"]);
  } else {
    Header("Location: index.php");
    exit();
  }

  $res = $mysql->query("SELECT name, active FROM threads WHERE id=".$id);
  $fetch = $res->fetch_assoc();
  $name = $fetch["name"];
  $active = $fetch["active"];

  $res1 = $mysql->query("SELECT title FROM categories WHERE id=".$catid);
  $catName = $res1->fetch_assoc()["title"];
?>

<html>
<head>
  <?php
    $title = $name;
    include("head.php");
  ?>

  <link href="assets/themes/default/main.css" rel="stylesheet">
  <link href="assets/themes/default/thread.css" rel="stylesheet">
  <link href="assets/themes/default/pages.css" rel="stylesheet">
</head>

<body>
  <?php
    include("navigation.php");
  ?>

  <div id="thread-header">
    <div id="thread-title">
      <?php
        if (!$active)
          echo "[Closed] ";

        echo $name;
      ?>
    </div>

    <div id="thread-nav-bar">
      <div id="category-justify">
        <div id="category-link">
          <a href="index.php">
            <?php echo "Home " ?>
          </a>
          <div class="category-slash">
            /
          </div>

          <a href="<?php echo 'category.php?id='.$catid; ?>">
            <?php echo $catName; ?>
          </a>

          <div class="category-slash">
            /
          </div>

          <div id="category-link-rest">
            <?php
              echo $name;
            ?>
          </div>
        </div>
      </div>

      <?php
        if ($active)
          echo '<a href="longreply.php?id='.$id.'" id="buttonReplyLink"><div id="reply-button">Reply</div></a>';
        else
          echo '<a id="buttonReplyLink"><div id="reply-button-closed">Closed</div></a>';
      ?>
    </div>
  </div>

  <div id="page-content">
    <?php
      include("displaypost.php");
    ?>

    <?php
      if ($active) {
        echo '<form id="replyForm" action="reply.php?category_id='.$catid.'&thread_id='.$id.'" method="post">
          <div id="reply-info">Quick reply</div>
          <textarea name="reply-content" placeholder="Write anything you want here"></textarea>
          <div id="textarea-input-space"></div>
          <input type="submit" value="Reply">
        </form>';
      } else {
        echo "<div id='thread-closed'>This thread is closed.</div>";
      }
    ?>


  </div>
</body>
</html>
