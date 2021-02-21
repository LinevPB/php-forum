<div class="border"></div>

<form action="groups.php" method="POST">
  <div class="option">
    <div class="title">Name</div>
    <input type="text" class="textInput" name="group-name" value="<?php if ($isFirst) echo $firstVal["name"]; ?>">
  </div>

  <div class="option">
    <div class="title">Background color</div>
    <input type="text" class="textInput" name="group-bgcolor" value="<?php if ($isFirst) echo $firstVal["background-color"]; ?>">
  </div>

  <div class="option">
    <div class="title">Color</div>
    <input type="text" class="textInput" name="group-color" value="<?php if ($isFirst) echo $firstVal["color"]; ?>">
  </div>

  <div class="option">
    <div class="title">Special</div>
    <select name="group-special" class="special textInput">
      <option value="0">No</option>
      <option value="1" <?php if ($isFirst) {
        if ($firstVal["special"] == 1)
          echo "selected";
      } ?>>Yes</option>
    </select>
  </div>

  <input type="submit" value="Save" name="Save" class="button">
</form>
