<!DOCTYPE html>

<?php
  include("check_permissions.php");
?>

<html>
<head>
  <title>Posts | Admin Control Panel</title>

  <meta charset="utf-8">
  <link href="themes/default/main.css" rel="stylesheet">
  <link href="themes/default/index.css" rel="stylesheet">
  <link href="themes/default/table.css" rel="stylesheet">
</head>

<body>
  <?php
    include("navigation.php");

    $result = $mysql->query("SELECT * FROM `posts`");
  ?>

  <div id="page-content">
    <div id="page-content-justify">
      <div id="page-header">
        Posts
      </div>
      <div class="settingsWall">
        <div class="wall-content">
          <table>
            <tr>
              <th class="userID">ID</th>
              <th class="userID">Category ID</th>
              <th class="userID">Thread ID</th>
              <th class="posterName">Poster Name</th>
              <th>Content</th>
              <th style="text-align: center">Actions</th>
            </tr>

            <?php
              while($row = $result->fetch_assoc()) {
                $res = $mysql->query("SELECT id, username, blocked FROM users WHERE id=".$row["poster_id"]);
                $fetchRes = $res->fetch_assoc();
                $name = $fetchRes["username"];
                $option = "Block";
                $status = "Remove";

                if ($fetchRes["blocked"]) {
                  $name = "<s>".$name."</s>";
                  $option = "Unblock";
                }

                if (!$row["active"]) {
                  $status = "Undo";
                }

                echo '
                  <tr>
                    <th class="userID">'.$row["id"].'</th>
                    <th class="userID">'.$row["category_id"].'</th>
                    <th class="userID">'.$row["thread_id"].'</th>
                    <th>'.$name.'</th>';

                    if (strlen($row["content"]) > 200) {
                      echo '<th class="postContent">'.substr($row["content"], 0, 200).'...</th>';
                    } else {
                      echo '<th class="postContent">'.$row["content"].'</th>';
                    }
                    echo '<th id="user'.$fetchRes["id"].'" class="userActions">[<a href="editpost.php?id='.$row["id"].'">Edit</a>] [<a href="removepost.php?id='.$row["id"].'">'.$status.'</a>] [<a href="block.php?id='.$row["poster_id"].'&act=post">'.$option.' Author</a>]</th></tr>';
              }
            ?>
          </table>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
