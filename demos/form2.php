<?php
  session_start();
  
  // logout
  if(isset($_GET['logout'])=="1"){unset($_SESSION['samurai']); }
  
  $user = "lisa";
  $pass = "test";
?>
<html>
  <head>
    <title>Form</title>
  </head>
  <body>
    <?php
      if(!isset($_SESSION['samurai'])){
    ?>
  <!-- HTML Forms -->
    <form method="post" action="" id="form2">
      <input type="hidden" name="status" value="sent">
      <input type="text" name="user" placeholder="username" required><br>
      <input type="password" name="pass" placeholder="password" required><br>
      <input type="submit" value="Submit">
    </form>
    
  <?php
    
    }else{
      echo 'you are logged in<br>';
      echo '<a href="form2.php?logout=1">Logout</a>';
    }
  
    if($_POST['status']=='sent'){
      if($_POST['user']==$user and $_POST['pass']==$pass){
        echo 'hurra';
        $_SESSION['samurai']=true;
      }
      else{
        echo "wrong user or pass";
        unset($_SESSION['samurai']);
      }
    }
  ?>
  </body>
</html>