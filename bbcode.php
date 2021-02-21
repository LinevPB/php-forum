<?php
  $codes = array(
    '~\[b\](.*?)\[/b\]~s',
    '~\[i\](.*?)\[/i\]~s',
    '~\[u\](.*?)\[/u\]~s',
    '~\[center\](.*?)\[/center\]~s',
    '~\[quote\](.*?)\[/quote\]~s',
    '~\[quote=([^"><]*?)\](.*?)\[/quote\]~s',
    '~\[size=([^"><]*?)\](.*?)\[/size\]~s',
    '~\[color=([^"><]*?)\](.*?)\[/color\]~s',
    '~\[url\]((?:ftp|https?)://[^"><]*?)\[/url\]~s',
    '~\[img\](https?://[^"><]*?\.(?:jpg|jpeg|gif|png|bmp))\[/img\]~s',
    '~\[video\](.*?)\[/video\]~s',
    "/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i"
  );

  function transformBBCode($text)
  {
    $text = strip_tags($text);
    $find = $GLOBALS["codes"];

    $replace = array(
      '<b>$1</b>',
      '<i>$1</i>',
      '<span style="text-decoration:underline;">$1</span>',
      '<center>$1</center>',
      '<div class="quote">$1</div>',
      '<div class="who">@$1</div><div class="quote">$2</div>',
      '<span style="font-size:$1px;">$2</span>',
      '<span style="color:$1;">$2</span>',
      '<a href="$1">$1</a>',
      '<img src="$1" alt="" />',
      '<iframe width="480px" height="320px" src="$1" allowfullscreen></iframe>',
      "<iframe width='480px' height='320px' src=\"//www.youtube.com/embed/$2\" allowfullscreen></iframe>"
    );

    $replaced = $text;
    $count = 0;

    do {
      $replaced = preg_replace($find, $replace, $replaced, -1, $count);
    } while($count != 0);

    return $replaced;
  }

  function removeBBCode($text)
  {
    $text = strip_tags($text);
    $find = $GLOBALS["codes"];

    $replace = array(
      '$1',
      '$1',
      '$1',
      '$1',
      '',
      '',
      '$2',
      '$2',
      '$1',
      '(IMAGE)',
      '(VIDEO)',
      '(VIDEO)'
    );

    $replaced = $text;
    $count = 0;

    do {
      $replaced = preg_replace($find, $replace, $replaced, -1, $count);
    } while($count != 0);

    return $replaced;
  }
?>
