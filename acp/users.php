<!DOCTYPE html>

<?php

  include("check_permissions.php");

?>

<html>
<head>
  <title>Users | Admin Control Panel</title>

  <meta charset="utf-8">
  <link href="themes/default/main.css" rel="stylesheet">
  <link href="themes/default/index.css" rel="stylesheet">
  <link href="themes/default/table.css" rel="stylesheet">
</head>

<body>
  <?php
    include("navigation.php");

    $result = $mysql->query("SELECT * FROM `users`");
  ?>

  <div id="page-content">
    <div id="page-content-justify">
      <div id="page-header">
        Users
      </div>
      <div class="settingsWall">
        <div class="wall-content">
          <table>
            <tr>
              <th style="text-align: center">ID</th>
              <th>Username</th>
              <th style="text-align: center">Actions</th>
            </tr>
            <?php
              while($row = $result->fetch_assoc()) {
                echo '
                  <tr>
                    <th style="text-align: center" class="userID">'.$row["id"].'</th><th>';
                    if ($row["blocked"] != 0) {
                      echo '<s>'.$row["username"].'</s>';
                    } else {
                      echo $row["username"];
                    }
                    if ($row["blocked"] != 2) {
                      echo '</th><th class="userActions">'.'[<a href="edituser.php?id='.$row["id"].'">Edit</a>]
                       [<a href="block.php?id='.$row["id"].'">';
                      if ($row["blocked"] == 1)
                        echo "Unblock";
                      else
                        echo "Block";
                      echo '</a>]
                           [<a href="delete.php?id='.$row["id"].'">Delete</a>]'.'</th>
                        </tr>
                      ';
                    } else {
                      echo '</th><th class="userActions deletedAccount">[DELETED ACCOUNT]</th></tr>';
                    }
              }
            ?>
          </table>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
