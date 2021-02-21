<?php
  $ronl = $mysql->query("SELECT avatar, id, lastSeen FROM users");
?>

<link href="assets/themes/default/online.css" rel="stylesheet">

<div id="online-list">
  <div id="online-header">
    Online users
  </div>
  <div id="online-users-list">
    <?php
      $time = new DateTime();
      $time = $time->getTimeStamp();

      while($Ronl = $ronl->fetch_assoc()) {
        if ($time - $Ronl["lastSeen"] <= 120) {
          echo '
            <a href="user.php?id='.$Ronl["id"].'"><img src="'.$Ronl["avatar"].'"></a>
          ';
        }
      }
    ?>
  </div>
</div>
