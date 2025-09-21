<!DOCTYPE html>

<html>
<head>
  <?php
    $title = "Register";
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
        Register
      </div>
    </div>

    <form action="auth/register.php" method="POST">
      <div class="element">
        <div class="info">Username</div>
        <input name="username" type="text" placeholder="Username">
      </div>

      <div class="element">
        <div class="info">E-mail</div>
        <input name="email" type="text" placeholder="E-mail">
      </div>

      <div class="element">
        <div class="info">Password</div>
        <input name="password" type="password" placeholder="Password">
      </div>

      <div class="element">
        <div class="info">Confirm password</div>
        <input name="cpassword" type="password" placeholder="Confirm password">
      </div>

      <div class="element">
        <input type="checkbox" id="remember">
        <label for="remember">I accept TOS.</label>
      </div>

      <?php
        if (session_status() == PHP_SESSION_NONE)
          session_start();

        if (isset($_SESSION["ERROR"])) {
          echo "<span id='error'>".$_SESSION["ERROR"]."</span>";
        }
      ?>

      <div class="element">
        <input type="submit">
      </div>
    </form>

    <div id="links">
      <a href="login.php">You have an account?</a>
      <a href="index.php">Forgot password?</a>
    </div>
  </div>
</body>
</html>
