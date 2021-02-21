<?php
  if (session_status() == PHP_SESSION_NONE)
    session_start();

  include("auth/db.php");
  $mysql = new mysqli($server, $db_user, $db_password, $db_name);

  if ($mysql->connect_error) {
    echo "Blad z polaczeniem!";
  }

  $result = $mysql->query("SELECT * FROM `settings`");
  $tRow = $result->fetch_assoc();
?>

<link href="assets/themes/default/navigation.css" rel="stylesheet">

<div id="navigation">
  <div id="container">
    <div id="nav-page-name">
      <a href="index.php">
        <?php echo $tRow["site-logo"]; ?>
      </a>
    </div>

    <ul id="nav-dropdown">
      <a href="index.php">
        <li>
          Home
        </li>
      </a>
      <a href="members.php">
        <li>
          Members
        </li>
      </a>
    </ul>

    <ul id="nav-auth">
      <?php
        if (session_status() == PHP_SESSION_NONE)
          session_start();

        if(!isset($_SESSION["logged"])) {
          echo '<a href="register.php">
            <li id="register">
              Register
            </li>
          </a>
          <a href="login.php">
            <li id="login">
              Login
            </li>
          </a>';
        } else {
          $res = $mysql->query("SELECT avatar, groupID FROM users WHERE id=".$_SESSION["id"]);
          $avatar = $res->fetch_assoc();

          $permission = $mysql->query("SELECT permissions FROM groups WHERE id=".$avatar["groupID"]);
          $permission = $permission->fetch_assoc()["permissions"];

          echo '<li id="account-menu">Hello, '.$_SESSION["username"].' <img src="'.$avatar["avatar"].'">
            <ol id="account-bar">
              <a href="user.php?id='.$_SESSION["id"].'"><li>
                My account
              </li></a>';

              if ($permission >= 5) {
                echo '
                  <a href="acp/index.php"><li>
                    Admin Control Panel
                  </li></a>
                ';
              }

              echo '<a href="settings.php"><li>
                Settings
              </li></a>

              <a href="logout.php"><li>
                Logout
              </li></a>
            </ol>
            </li>
          ';
        }
      ?>

    </ul>
  </div>
</div>
