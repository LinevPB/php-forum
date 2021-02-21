<?php
  if (session_status() == PHP_SESSION_NONE)
    session_start();

  if (isset($_SESSION["logged"]) && ($_SESSION["logged"] == true)) {
    header("Location: index.php");
    exit();
  }
?>

<!DOCTYPE html>

<html>
<head>
  <?php
    $title = "Login";
    include("head.php");
  ?>

  <link href="assets/themes/default/main.css" rel="stylesheet">
  <link href="assets/themes/default/auth.css" rel="stylesheet">
</head>

<body>
  <?php
    include("navigation.php");
  ?>

  <div id="page-content">
    <div id="category-link">
      <a href="index.php">
        <?php echo "Home " ?>
      </a>
      <div class="category-slash">
        /
      </div>

      <div id="category-link-rest">
        Login
      </div>
    </div>

    <form action="auth/login.php" method="post">
      <div class="element">
        <div class="info">Username / E-mail</div>
        <input name="username" type="text" placeholder="Username / E-mail">
      </div>

      <div class="element">
        <div class="info">Password</div>
        <input name="password" type="password" placeholder="Password">
      </div>

      <div class="element">
        <input type="checkbox" id="remember">
        <label for="remember">Remember me</label>
      </div>

      <?php
        if (isset($_SESSION["ERROR"])) {
          echo "<p id='error'>".$_SESSION["ERROR"]."</p>";
        }

        unset($_SESSION["ERROR"]);
      ?>

      <div class="element">
        <input type="submit">
      </div>
    </form>

    <div id="links">
      <a href="register.php">Don't have an account?</a>
      <a href="index.php">Forgot password?</a>
    </div>
  </div>
</body>
</html>
