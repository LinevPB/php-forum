<?php
  include("time.php");
  include("bbcode.php");

  $id = "";

  if (isset($_GET["id"])) {
    $id = neut($_GET["id"]);
  } else {
    return;
  }

  $sql = "SELECT * FROM threads WHERE category_id=".$id." ORDER BY `lastPostTime` DESC";

  $result = $mysql->query($sql);

  if ($result->num_rows == 0) {
    echo '
      <div id="page-content">
        <div class="noNothing">There are no threads yet.</div>
      </div>
    ';

    exit();
  }

  $lastPost = [
    "time" => 0,
  ];

  $userRes = [];

  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $sqluser = "SELECT * FROM users WHERE id=".$row["creator_id"];
      $userResult = $mysql->query($sqluser);
      $userRow = $userResult->fetch_assoc();

      if ($userRow["blocked"] == 1) {
        $userRow["username"] = "<s>".$userRow["username"]."</s>";
      }
      else if ($userRow["blocked"] == 2) {
        $userRow["username"] = "Account removed";
        $userRow["avatar"] = "assets/images/default_avatar.jpg";
      }

      $psql = "SELECT id, content, time, poster_id FROM posts WHERE thread_id=".$row["id"];
      $presult = $mysql->query($psql);

      if ($presult->num_rows > 0) {
        while($pRow = $presult->fetch_assoc()) {
          if ($pRow["time"] >= $lastPost["time"]) {
            $lastPost = $pRow;

            $lastPost["content"] = removeBBCode($lastPost["content"]);
            if (strlen($lastPost["content"]) > 60)
              $lastPost["content"] = substr($lastPost["content"], 0, 60);
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
      <div class="thread">
        <div class="creator-avatar">
          <a href="user.php?id='.$userRow["id"].'"><img src="'.$userRow["avatar"].'"></a>
        </div>

        <div class="thread-content">
          <div class="title">
            <a href="thread.php?id='.$row["id"].'&category_id='.$id.'">';

      if (!$row["active"])
        echo "[Closed] ";

      echo $row["name"] .'</a>
          </div>

          <div class="date-who">
            '.transformTime($row["date"]).' * <a href="user.php?id='.$userRow["id"].'">'.$userRow["username"].'</a>
          </div>
        </div>

        <div class="thread-lastpost">
          <div class="lastuser">
            <a href="user.php?id='.$userRes["id"].'"><div class="user-avatar">
                <img src="'.$userRes["avatar"].'">
              </div>
            </a>
          </div>

          <a href="thread.php?id='.$row["id"].'&category_id='.$id.'#post'.$lastPost["id"].'">
            <div class="user-when">'.transformTime($lastPost["time"]).'</div>
            <div class="lastpost">
              '.$lastPost["content"].'
            </div>
          </a>
        </div>

        <div class="thread-statistics">
          <div class="border">
          </div>

          <div class="stat">
            <div class="amount">'.$row["views"].'</div>
            <div class="type">Views</div>
          </div>

          <div class="stat">
            <div class="amount">'.$presult->num_rows.'</div>
            <div class="type">Posts</div>
          </div>
        </div>
      </div>
      ';

      $lastPost = [
        "time" => 0,
      ];
    }
  }
?>
