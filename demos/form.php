<?php

  session_start();

  

?>
<html>
  <head>
    <title>Form</title>
    <link rel="stylesheet" type="text/css" href="./design.css">
  </head>
  <body>
    <form method="post" action="" id="form1">
      <input type="hidden" name="hidden_value" value="sent">
      <input type="text" name="text" placeholder="username" required>
      <input type="password" name="pass" placeholder="password" required>
      <input type="number" name="num">
      <input type="color" name="color">
      <input type="radio" name="radio1" value="green"> green
      <input type="radio" name="radio1" value="blue"> blue
      <input type="radio" name="radio2" value="water"> water
      <input type="radio" name="radio2" value="leaf"> leaf
      <input type="checkbox" name="chkbox" value="test" required> accept terms of service?
      <textarea name="index" placeholder="ein Text"></textarea>
      <!-- HTML Forms -->
      <input type="submit" value="Submit">
    </form>
    
  <?php
    echo "hidden_value: ".$_POST['hidden_value']."<br>";
    echo 'text: '.$_POST['text']."<br>";
    echo 'pass: '.$_POST['pass']."<br>";
    echo 'num: '.$_POST['num']."<br>";
    echo '<span style="color:'.$_POST['color'].'">color: </span>'.$_POST['color']."<br>";
    echo 'radio1: '.$_POST['radio1']."<br>";
    echo 'radio2: '.$_POST['radio2']."<br>";
    echo 'chkbox: '.$_POST['chkbox']."<br>";
    echo 'index: '.$_POST['index']."<br>";
  ?>
  </body>
</html>