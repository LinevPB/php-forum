<?php
  include("auth/db.php");

  $mysql = new mysqli($server, $db_user, $db_password, $db_name);

  if ($mysql->connect_error) {
    return;
  }

  $sql = "SELECT * FROM categories";

  $result = $mysql->query($sql);

  if ($result->num_rows == 0) {
    echo '
      <div id="page-content">
        <div class="noNothing">There are no categories.</div>
      </div>
    ';

    exit();
  }

  $lastPost = [
    "time" => 0,
  ];

  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $tsql = "SELECT id FROM threads WHERE category_id=".$row["id"];
      $tresult = $mysql->query($tsql);

      $psql = "SELECT id, thread_id, category_id, content, time, poster_id FROM posts WHERE category_id=".$row["id"];
      $presult = $mysql->query($psql);
      $userRes = [];

      if ($presult->num_rows > 0) {
        while($prow = $presult->fetch_assoc()) {
          if ($prow["time"] >= $lastPost["time"]) {
            $lastPost = $prow;

            $lastPost["content"] = removeBBCode($lastPost["content"]);
            if (strlen($lastPost["content"]) > 60) {
              $lastPost["content"] = substr($lastPost["content"], 0, 60);
            }
          }
        }

        $usql = "SELECT id, avatar, blocked from users WHERE id=".$lastPost["poster_id"];
        $uresult = $mysql->query($usql);
        $userRes = $uresult->fetch_assoc();

        if ($userRes["blocked"] == 2) {
          $userRes["avatar"] = "assets/images/default_avatar.jpg";
        }
      }

      echo '
      <div class="category">
        <div class="category-icon">
          <!--<div class="ct-icon">S</div>-->
          <img class="ct-icon" src="'.$row["icon"].'" style="background-color:#'.$row["color"].'">
        </div>

        <div class="category-content">
          <div class="category-title">
            <a href="category.php?id='.$row["id"].'">'.$row["title"].'</a>
          </div>

          <div class="category-description">
            '.$row["description"].'
          </div>
        </div>

        <div class="category-lastpost" style="border-color: #'.$row["color"].'">';
          if($presult->num_rows > 0) {
            echo '<div class="lastpost-lastuser">
              <a href="user.php?id='.$userRes["id"].'"><div class="user-avatar">
                  <img src="'.$userRes["avatar"].'">
                </div>
              </a>
            </div>

            <a href="thread.php?id='.$lastPost["thread_id"].'&category_id='.$lastPost["category_id"].'#post'.$lastPost["id"].'">
              <div class="user-when">'.transformTime($lastPost["time"]).'</div>
              <div class="lastpost-lastthread">'.$lastPost["content"].'</div>
            </a>
          ';
        } else {
          echo "<p>"."No posts yet!"."</p>";
        }
      echo '</div>
        <div class="category-statistics">
          <div class="border" style="background-color:#'.$row["color"].'">
          </div>

          <div class="stat">
            <div class="amount">'.$tresult->num_rows.'</div>
            <div class="type">THREADS</div>
          </div>

          <div class="stat">
            <div class="amount">'.$presult->num_rows.'</div>
            <div class="type">POSTS</div>
          </div>
        </div></div>';

      $lastPost["time"] = 0;
    }
  }

?>
