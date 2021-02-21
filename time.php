<?php
  function transformTime($date) {
    $ndate = new DateTime();

    $result = (($ndate->getTimestamp()) - $date);

    if ($result < 1) {
      return "Just now";
    }
    else if ($result > 1 && $result < 60) {
      return floor($result)." sec ago";
    }

    $result = $result / 60;

    if ($result >= 1 && $result < 60) {
      return floor($result)." min ago";
    }

    $result = $result / 60;

    if ($result >= 1 && $result < 24) {
      return floor($result)." hours ago";
    }
    else if ($result >= 24 && $result < 48) {
      return "Yesterday at ".gmdate("G:i", $date);
    }

    return gmdate("d M Y, G:i", $date);
  }
?>
