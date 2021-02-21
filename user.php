<!DOCTYPE html>

<?php
  include("bbcode.php");
  include("time.php");

  $bckg = "assets/images/account-background.jpg";
  if (session_status() == PHP_SESSION_NONE)
    session_start();

    include ("auth/neut.php");
    include("auth/db.php");

    if (!(isset($_GET['id'])))
  	{
  		header("Location: index.php");
  		exit();
  	}

    $POSTS_PER_PAGE = 5;

    $mysql = new mysqli($server, $db_user, $db_password, $db_name);

    if ($mysql->connect_error) {
      $_SESSION["ERROR"] = "Server connection failed! Please try again later!";
      Header("Location: index.php");
      exit();
    }

    $userid = 0;

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
      $userid = neut($_GET["id"]);
    } else {
      Header("Location: index.php");
      exit();
    }

    $sql = "SELECT * FROM users WHERE id='$userid'";

    $result = $mysql->query($sql);

    if (!($result->num_rows > 0)) {
      Header("Location: index.php");
      exit();
    }

    $row = $result->fetch_assoc();
?>

<html>
<head>
  <?php
    if ($row["blocked"] == 2) {
      $row["username"] = "Account removed";
      $row["avatar"] = "assets/images/default_avatar.jpg";
    }

    $title = $row["username"];

    if ($row["blocked"] == 1)
      $row["username"] = "<s>".$row["username"]."</s>";

    include("head.php");
  ?>

  <link href="assets/themes/default/main.css" rel="stylesheet">
  <link href="assets/themes/default/user.css" rel="stylesheet">
  <link href="assets/themes/default/pages.css" rel="stylesheet">
</head>

<body>
  <?php
    include("navigation.php");
    echo '
      <div id="background-image" style="background-image: url('.$bckg.')">
      </div>
    ';
  ?>
  </div>

  <div id="user-avatar">
    <img src="<?php echo $row["avatar"]; ?>">
  </div>

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
          echo $row["username"];
        ?>
      </div>
    </div>

    <div id="user-name">
      <?php
        if ($row["blocked"] == 1)
          echo "<s>".$row["username"]."</s>";
        else
          echo $row["username"];
      ?>
    </div>

    <?php
      if ($row["blocked"] == 2)
        exit();

      $gres = $mysql->query("SELECT * from groups WHERE id=".$row["groupID"]);
      $gp = $gres->fetch_assoc();

      if ($gp["special"] == true) {
        echo '
          <div class="rank" id="rankUser" style="background-color:'.$gp["background-color"].'; color:'.$gp["color"].'">
            '.$gp["name"].'
          </div>
        ';
      }
    ?>

    <div id="email">
      <?php echo $row["email"]; ?>
    </div>

    <div id="description">
      <?php
        echo $row["description"];
      ?>
    </div>

    <div id="posts">
      <div id="info">
        Posts made by <?php echo $row["username"]; ?>
      </div>

      <?php
          $res2 = $mysql->query("SELECT * FROM posts WHERE poster_id=".$row["id"]." ORDER BY `time` DESC");

          if ($res2->num_rows > 0) {
            $pages = ceil(($res2->num_rows / $POSTS_PER_PAGE));

            if (isset($_GET["page"])) {
              $page = $_GET["page"];
            } else {
              $page = 1;
            }

            $start = (($page - 1) * $POSTS_PER_PAGE);
            $end = $start + $POSTS_PER_PAGE;
            $count = 0;

          while($ps = $res2->fetch_assoc()) {
            $count++;

            if ($count <= $start)
              continue;

            if ($count > $end)
              break;

            $res3 = $mysql->query("SELECT * FROM threads WHERE id=".$ps["thread_id"]);
            $ts = $res3->fetch_assoc();

            $res4 = $mysql->query("SELECT * FROM categories WHERE id=".$ts["category_id"]);
            $rs = $res4->fetch_assoc();

            echo '
              <div class="creation">
                <div class="when">
                  <a href="user?id='.$row["id"].'">'.$row["username"].'</a><br>
                  '.transformTime($ps["time"]).'
                </div>
                <div class="post">
                  <div class="title">
                    <a href="thread.php?id='.$ps["thread_id"].'&category_id='.$rs["id"].'">'.$ts["name"].'</a>
                  </div>

                  <div class="content">';

                  if ($ps["active"])
                    echo nl2br(transformBBCode($ps["content"]));
                  else
                    echo "<div class='postRemoved'>This post has been removed.</div>";

                  echo '</div>

                  <div class="where">
                    <a href="category.php?id='.$rs["id"].'">Posted in '.$rs["title"].'</a>
                  </div>
                </div>
              </div>
            ';
          }
        } else {
          echo '<div class="noPosts">'."This user hasn't posted anything yet.".'</div>';
        }
      ?>
    </div>

  <?php
    if ($res2->num_rows > 0) {
      if ($pages > 1) {
        $pre_ur = 'href="user.php?id='.$userid.'&page=';

        echo "<div id='pages'>
          <a class='page operator";

        if ($page > 1) {
          echo " active' ";
          $tempPg = $page - 1;
          echo $pre_ur.$tempPg.'">';
        }
        else
          echo "'>";

        echo "<</a>";

        for($i = 1; $i <= $pages; $i++) {
          if ((($page >= $i - 2) && ($page <= $i + 2)) || ($i == 1) || ($i == $pages)
          || ($page >= 1 && $page < 5 && $i >= 1 && $i <= 5)
          || ($page - $i >= 1 && $page - $i <= 4 && $i <= $pages && $i >= $pages - 4)) {
            echo '<a class="page active" id="';

            if ($page == $i)
              echo 'currentPage';

            echo '"'.$pre_ur.$i.'">'.$i.'</a>';
          } else {
            if ($pages > 7 && ($i == 2 || $i == $pages - 1)) {
              echo '<a class="page operator">...</a>';
            }
          }
        }

        echo "<a class='page operator";

        if ($page < $pages) {
          echo " active' ";
          $tempPg = $page + 1;
          echo $pre_ur.$tempPg.'">';
        }
        else
          echo "'>";

        echo "></a></div>";
      }
    }
  ?>

    <div id="bottom"></div>
  </div>
</body>
</html>
