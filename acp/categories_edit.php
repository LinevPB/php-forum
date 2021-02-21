<div class="border"></div>

<form action="categories.php" method="POST">
  <div class="option">
    <div class="title">Name</div>
    <input type="text" class="textInput" name="cat-name" value="<?php if ($isFirst) echo $firstVal["title"]; ?>">
  </div>

  <div class="option">
    <div class="title">Description</div>
    <input type="text" class="textInput" name="cat-desc" value="<?php if ($isFirst) echo $firstVal["description"]; ?>">
  </div>

  <div class="option">
    <div class="title">Color</div>
    <input type="text" class="textInput" name="cat-color" value="<?php if ($isFirst) echo $firstVal["color"]; ?>">
  </div>

  <div class="option">
    <div class="title">Icon</div>
    <input type="text" class="textInput" name="cat-icon" value="<?php if ($isFirst) echo $firstVal["icon"]; ?>">
  </div>


  <input type="submit" value="Save" name="Save" class="button">
</form>
