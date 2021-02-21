<!DOCTYPE html>

<html>
<head>
  <?php
    $title = "Members";
    include("head.php");
  ?>

  <link href="assets/themes/default/main.css" rel="stylesheet">
  <link href="assets/themes/default/members.css" rel="stylesheet">
</head>

<body>
  <div id="page-content">
    <div id="title">Members</div>
  <?php
    include("navigation.php");

    include("auth/db.php");

    $mysql = new mysqli($server, $db_user, $db_password, $db_name);

    $res = $mysql->query("SELECT id, username, avatar FROM users");

    while($row = $res->fetch_assoc()) {
      echo '
        <div class="user-container">
          <div class="user-avatar"><img src="'.$row["avatar"].'"></div>
          <div class="user-name"><a href="user.php?id='.$row["id"].'">'.$row["username"].'</a></div>
        </div>
      ';
    }
  ?>
  </div>

</body>
</html>
