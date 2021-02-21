<?php
  include("auth/db.php");
  include("time.php");
  include ("bbcode.php");

  if (session_status() == PHP_SESSION_NONE)
    session_start();

  $mysql = new mysqli($server, $db_user, $db_password, $db_name);

  if ($mysql->connect_error) {
    header("Location: index.php");
    exit();
  }

  $POSTS_PER_PAGE = 10;
  $id = "";

  if (isset($_GET["id"])) {
    $id = neut($_GET["id"]);
  } else {
    header("Location: index.php");
    exit();
}

  $updateViews = $mysql->query("UPDATE `threads` SET `views`=`views` + 1 WHERE id=".$id);

  $sql = "SELECT * FROM posts WHERE thread_id=".$id;

  $result = $mysql->query($sql);

  if ($result->num_rows > 0) {
    $pages = ceil(($result->num_rows / $POSTS_PER_PAGE));

    if (isset($_GET["page"])) {
      $page = $_GET["page"];
    } else {
      $page = $pages;
    }

    $start = (($page - 1) * $POSTS_PER_PAGE);
    $end = $start + $POSTS_PER_PAGE;
    $count = 0;

    while($row = $result->fetch_assoc()) {
      $count++;

      if ($count <= $start)
        continue;

      if ($count > $end)
        break;

      $sqluser = "SELECT * FROM users WHERE id=".$row["poster_id"];
      $userResult = $mysql->query($sqluser);
      $userRow = $userResult->fetch_assoc();

      $groupResult = $mysql->query("SELECT * FROM groups WHERE id=".$userRow["groupID"]);
      $gp = $groupResult->fetch_assoc();

      if ($userRow["blocked"] == 2) {
        $userRow["username"] = "Account removed";
        $userRow["avatar"] = "assets/images/default_avatar.jpg";
      }

      echo '
        <div class="post" id="post'.$row["id"].'">
          <div class="user-avatar">
            <a href="user.php?id='.$userRow["id"].'"><img src="'.$userRow["avatar"].'"></a>
          </div>
          <div class="post-info-justify">
            <div class="post-user-info">
                <div class="who-post"><a href="user.php?id='.$userRow["id"].'">';

      if ($userRow["blocked"] == 1)
        echo "<s>".$userRow["username"]."</s>";
      else
        echo $userRow["username"];

        echo '</a>
          </div>';
          if ($gp["special"] == true) {
            echo '
              <div class="rank rankPost" style="background-color: '.$gp["background-color"].'; color: '.$gp["color"].'">'.$gp["name"].'</div>
            ';
          }
          echo '
          <div class="when-post">'.transformTime($row["time"]).'</div>
        </div>
    </div>

    <div class="post-content">';

    if (!$row["active"]) {
      echo nl2br(transformBBCode($row["content"]));
    } else {
      echo "<div class='postRemoved'>This post has been removed.</div>";
    }

    echo '</div>';

    echo '<div class="postAction">';
        if (isset($_SESSION["id"])) {
          if ($row["poster_id"] == $_SESSION["id"])
            echo '<a href="editpost.php?id='.$row["id"].'" class="actionmethod">Edit</a>';
        }

            echo '
            <a href="longreply.php?id='.$row["thread_id"].'&post='.$row["id"].'" class="actionmethod">Quote</a>
          </div>';

    if ($userRow["description"] != "") {
      echo '
        <div class="justify-signature">
          <div class="user-signature">
            '.$userRow["description"].'
          </div>
        </div>';
    }

    echo '</div>';

    }

    if ($pages > 1) {
      $pre_ur = 'href="thread.php?id='.$id.'&category_id='.$catid.'&page=';

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
