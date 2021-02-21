<!DOCTYPE html>

<?php

  include("check_permissions.php");

?>

<html>
<head>
  <title>Threads | Admin Control Panel</title>

  <meta charset="utf-8">
  <link href="themes/default/main.css" rel="stylesheet">
  <link href="themes/default/index.css" rel="stylesheet">
  <link href="themes/default/table.css" rel="stylesheet">
</head>

<body>
  <?php
    include("navigation.php");

    $result = $mysql->query("SELECT * FROM `threads`");
  ?>

  <div id="page-content">
    <div id="page-content-justify">
      <div id="page-header">
        Threads
      </div>
      <div class="settingsWall">
        <div class="wall-content">
          <table>
            <tr>
              <th class="userID">ID</th>
              <th class="userID">Category ID</th>
              <th>Author Name</th>
              <th>Title</th>
              <th style="text-align: center">Actions</th>
            </tr>

            <?php
              while($row = $result->fetch_assoc()) {
                $res = $mysql->query("SELECT username, blocked FROM users WHERE id=".$row["creator_id"]);
                $fetchUser = $res->fetch_assoc();
                $name = $fetchUser["username"];
                $option = "Block";
                $status = "Close";

                if ($fetchUser["blocked"]) {
                  $name = "<s>".$name."</s>";
                  $option = "Unblock";
                }

                if (!$row["active"]) {
                  $status="Open";
                  $row["name"] = "[C] ".$row["name"];
                }


                echo '
                  <tr>
                    <th class="userID">'.$row["id"].'</th>
                    <th class="userID">'.$row["category_id"].'</th>
                    <th>'.$name.'</th>
                    <th>'.$row["name"].'</th>
                    <th id="user'.$row["creator_id"].'" class="userActions">[<a href="editthread.php?id='.$row["id"].'">Edit</a>] [<a href="closethread.php?id='.$row["id"].'">'.$status.'</a>] [<a href="block.php?id='.$row["creator_id"].'&act=thread">'.$option.' Author</a>]</th>
                  </tr>';
              }
            ?>
          </table>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
