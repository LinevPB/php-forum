<!DOCTYPE html>

<?php
  include("check_permissions.php");

  $isFirst = false;

  if (!isset($_POST["Edit"]) && !isset($_POST["Save"]) && !isset($_POST["Delete"]) && isset($_SESSION["category-id"])) {
    unset($_SESSION["category-id"]);
  }

  if (isset($_POST["Edit"])) {
    if (isset($_POST["category"])) {
      $isFirst = true;

      $res = $mysql->query("SELECT * FROM `categories` WHERE id=".$_POST["category"]);

      $firstVal = $res->fetch_assoc();
      $_SESSION["category-id"] = $firstVal["id"];

      unset($_POST["categories"]);
    }

    unset($_POST["Edit"]);
  }

  if (isset($_POST["Save"])) {
    if (isset($_SESSION["category-id"])) {
      $res = $mysql->query("UPDATE `categories` SET `title` = '".$_POST["cat-name"]."', `color` = '".$_POST["cat-color"]."', `icon` = '".$_POST["cat-icon"]."', `description` = '".$_POST["cat-desc"]."' WHERE `id`=".$_SESSION["category-id"]);

      $res2 = $mysql->query("SELECT * from `categories` WHERE id=".$_SESSION["category-id"]);
      $isFirst = true;
      $firstVal = $res2->fetch_assoc();

      $_SESSION["csuccess-edit"] = "<div class='success-edit'>Category has been edited successfuly.</div>";
    }
    unset($_POST["Save"]);

    Header("Location: categories.php");
    exit();
  }

  if (isset($_POST["createCategory"])) {
    if (isset($_POST["ccat-name"]) && isset($_POST["ccat-color"]) && isset($_POST["ccat-desc"]) && isset($_POST["ccat-icon"])) {
      $res = $mysql->query("INSERT INTO categories (title, `color`, icon, description) VALUES ('".$_POST["ccat-name"]."', '".$_POST["ccat-color"]."', '".$_POST["ccat-icon"]."', '".$_POST["ccat-desc"]."')");
      unset($_POST["createCategory"]);

      $_SESSION["csuccess-edit"] = "<div class='success-edit'>Category has been created successfuly.</div>";

      Header("Location: categories.php");
      exit();
    }
  }

  if (isset($_POST["Delete"])) {
    if (isset($_POST["category"])) {

      $result = $mysql->query("DELETE FROM categories WHERE id=".$_POST["category"]);

      $_SESSION["csuccess-edit"] = "<div class='success-edit'>Category has been removed successfuly.</div>";
    }

    unset($_POST["Delete"]);

    Header("Location: categories.php");
    exit();
  }

?>

<html>
<head>
  <title>Categories | Admin Control Panel</title>

  <meta charset="utf-8">
  <link href="themes/default/main.css" rel="stylesheet">
  <link href="themes/default/index.css" rel="stylesheet">
  <link href="themes/default/table.css" rel="stylesheet">
</head>

<body>
  <?php
    include("navigation.php");

    $result = $mysql->query("SELECT * FROM `categories`");
  ?>

  <div id="page-content">
    <div id="page-content-justify">
      <div id="page-header">
        Categories
      </div>
      <div class="settingsWall">
        <div class="wall-content">
          <div class="wall-title">Edit a category</div>
          <form method="post" action="categories.php">
            <select name="category" class="select-category textInput">
              <?php
                while($row = $result->fetch_assoc()) {
                  if (!$isFirst) {
                    $isFirst = true;
                    $firstVal = $row;
                  }

                  echo '<option value="'.$row["id"].'" ';

                  if ($row["id"] == $firstVal["id"])
                    echo "selected";

                  echo '>'.$row["title"].'</option>';
                }
              ?>
            </select>

            <div class="grouped-inputs">
              <input type="submit" value="Edit" name="Edit" class="button ingr-input">
              <input type="submit" id="edit-button" value="Delete" name="Delete" class="button ingr-input">
            </div>
          </form>

          <?php
            if (isset($_SESSION["csuccess-edit"])) {
              echo $_SESSION["csuccess-edit"];
              unset($_SESSION["csuccess-edit"]);

              if (isset($_SESSION["category-id"]))
                unset($_SESSION["category-id"]);
            } else {
              if (isset($_SESSION["category-id"])) {
                include("categories_edit.php");
              }
            }
          ?>
        </div>
      </div>

      <div class="settingsWall">
        <div class="wall-content">
          <div class="wall-title">Create a category</div>

          <form action="categories.php" method="post">
            <div class="option">
              <div class="title">Name</div>
              <input type="text" class="textInput" name="ccat-name" placeholder="Name of a category">
            </div>

            <div class="option">
              <div class="title">Description</div>
              <input type="text" class="textInput" name="ccat-desc" placeholder="Description of a category">
            </div>

            <div class="option">
              <div class="title">Icon</div>
              <input type="text" class="textInput" name="ccat-icon" placeholder="Path to an icon">
            </div>

            <div class="option">
              <div class="title">Color</div>
              <input type="text" class="textInput" name="ccat-color" placeholder="Color of a category in HEX value">
            </div>

            <input type="submit" name="createCategory" value="Create" class="button">
          </form>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
