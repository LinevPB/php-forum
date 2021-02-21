<?php
  $anr = $mysql->query("SELECT id, name, creator_id, creator_post, `date`, category_id FROM `threads` ORDER BY `date` DESC");
  $amount = ($anr->num_rows >= 3) ? 3 : ($anr->num_rows);
?>


<link href="assets/themes/default/announcements.css" rel="stylesheet">

<div id="announcements">
  <?php
    for($i = 0; $i < $amount; $i++) {
      $anRow = $anr->fetch_assoc();
      $anpRow = $mysql->query("SELECT content FROM posts WHERE id=".$anRow["creator_post"]);
      $anpRow = $anpRow->fetch_assoc()["content"];
      $ancRow = $mysql->query("SELECT title, icon, color FROM categories WHERE id=".$anRow["category_id"]);
      $ancRow = $ancRow->fetch_assoc();
      $anuRow = $mysql->query("SELECT avatar FROM users WHERE id=".$anRow["creator_id"]);
      $anuRow = $anuRow->fetch_assoc()["avatar"];

      echo '
        <div class="announce">
          <div class="threadName">
            <a href="thread.php?id='.$anRow["id"].'&category_id='.$anRow["category_id"].'">'.$anRow["name"].'</a>
          </div>
          <div class="announceContent">
            <div class="authorAvatar">
              <a href="user.php?id='.$anRow["creator_id"].'"><img src="'.$anuRow.'"></a>
            </div>
            <div class="threadContent">
              '.nl2br(transformBBCode($anpRow)).'
            </div>
            <div class="threadInfo">
              <div class="threadIcon" style="background-color: #'.$ancRow["color"].'">
                <img src="'.$ancRow["icon"].'">
              </div>
              <div class="categoryName">
                <a href="category.php?id='.$anRow["category_id"].'">'.$ancRow["title"].'</a>
              </div>
              <div class="whenThread">
                '.transformTime($anRow["date"]).'
              </div>
            </div>
          </div>
        </div>
      ';
    }
  ?>
</div>
