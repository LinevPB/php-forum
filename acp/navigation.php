<?php
  include("check_permissions.php");

  $result = $mysql->query("SELECT * FROM users WHERE id=".$_SESSION["id"]);
  $row = $result->fetch_assoc();
?>

<link href="themes/default/navigation.css" rel="stylesheet">

<div id="navigation">
  <div id="left-navigation">
    <a href="index.php"><div id="title">
      <b>Admin</b>CP
    </div></a>
    <div id="user-info">
      <?php
        echo '
          <div id="user-avatar">
            <img src="../'.$row["avatar"].'">
          </div>

          <div id="myName">'.$row["username"].'</div>
        ';
      ?>
    </div>

    <input type="text" id="search" placeholder="Search...">

    <div class="section-title">
      Main navigation
    </div>

    <ul>
      <?php
        $pages = array(
          "index.php" => "Home",
          "categories.php" => "Categories",
          "threads.php" => "Threads",
          "posts.php" => "Posts",
          "users.php" => "Users",
          "groups.php" => "Groups",
          "settings.php" => "Settings"
        );

        foreach($pages as $k => $v) {
          echo '<a href="'.$k.'"><li id="';

          if($k == (substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1))) {
            echo "currentPage";
          }

          echo '">'.$v.'</li></a>';
        }
      ?>
    </ul>
  </div>

  <div id="top-navigation">
    <div id="user">
      <div id="userJustify">
        <?php
          echo '
            <div id="topNav-avatar">
              <img src="../'.$row["avatar"].'">
            </div>

            <div id="topNav-name">'.$row["username"].'</div>
          ';
        ?>
      </div>
      <ol>
        <a href="../index.php">
          <li>
            Exit ACP
          </li>
        </a>
        <a href="../logout.php">
          <li>
            Logout
          </li>
        </a>
      </ol>
    </div>
  </div>
</div>
