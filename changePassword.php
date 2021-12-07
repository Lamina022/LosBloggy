<!DOCTYPE HTML>
<html>
  <head>
    <title>Sign In</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="design.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <?php
      // Include our config.php file
      include('_config.php');
      include($conf['paths']['functions']);
      
      $date = date("Y-m-d H:i:s");
  ?>
  </head>
  <body>
    <!-- Navigation Bar -->
      <ul class="topbar sticky" id="">
        <li class="topbar" id=""><a class="logo logo-header" href="index.php">Home</a></li>
        <?php
          if(isset($_SESSION["uid"])) {
            echo '<li class="dropdown" id="" style="float:right">
                    <a class="topbar dropdown" href="#"><span class="glyphicon glyphicon-user"></span> '.$_SESSION['username'].'</i></a>
                    <a class="topbar dropdown" href="logout.php">Logout</i></a>
                    <ul class="dropdown">
                      <li><a href="#">Dashboard</a></li>
                      <li><a href="logout.php">Logout</a></li>
                    </ul>
                  </li>';
          }
          else {
            echo '<li class="topbar" id="" style="float:right"><a href="login.php">Log In</a></li>
                  <li class="topbar" id="" style="float:right"><a class="active" href="register.php">Sign Up</a></li>';
          }
        ?>
      </ul>
        
    <!-- Header -->
    <div class="banner">
      <h1><a href="index.php" style="text-decoration: none;color:white;">Sign In</a></h1>
      <p></p>
    </div>
    
    <!-- Body -->
    <?php
    	// Check if user is already signed-in
    	if(isset($_SESSION['username'])) {
        $result_uid = SelectQuery("user","user_id","WHERE username='".$_SESSION['username']."'");
        while($obj = $result_uid->fetch_object()) {
            //$bloguid = GetFieldValue("blog","user_id",$obj->user_id);
            $uid = $obj->user_id;
        }
        if($uid==$_GET['uid']) {
          if(isset($_GET['changepwd'])) {
              
        		// If form submitted, insert values into the database.
        		if (isset($_POST['current_pwd']) and isset($_POST['new_pwd'])) {
        
        			// Remove backslashes
        			$current_pass = stripslashes($_POST['curent_pwd']);
              $new_pass = stripslashes($_POST['new_pwd']);
              $repeat_pass = stripslashes($_POST['repeat_pwd']);
                                 
        			//Checking if user is existing in the database or not
        			$query_result = SelectQuery("user","password","WHERE username='$username'");
        			while($obj = $query_result->fetch_object()) {
                     $pw_hash = $obj->password;
        			}
        			
      				// Ensure, that it's a new Password
      				if (password_verify($password, $pw_hash)) {
                echo "<br><h3 style='text-align: center'>Cannot use the same Password.<br>Please choose a new one.</h3>";      
      				} else {
                 // Validate password
                if(strlen(trim($password)) < 6) {
                    $err .= "<br>Password must have atleast 6 characters."; 
                    $tmp = true; // set a flag
                } else {
                    $password = stripslashes($password);
                    $password = mysqli_real_escape_string($con,$password);
                }
    
                // Validate confirm password
                if($tmp==true or ($password != trim($pw_repeat))) {
                    $err .= "<br>Password did not match or did not meet the password requirements.";
                }
    
                // write into data 
                if(empty($err) and $tmp==false) {        
                    $result = UpdateQuery("user","password,last_password_change",password_hash($password, PASSWORD_DEFAULT)."','$date'");
                    if($result) {
                    echo "<div style='text-align: center'>
                    <h3>Password successfully updated</h3>
                    <br>Click here to <a href='logout.php'>Login</a>
                    </div>";
                    }
                } else {
                  echo '<p style="text-align:center;color:red;"><br><br>'.$err.'</p><br><br>
                        <a href="modifyUser.php?uid='.$_GET['uid'].'&obj=changepwd" style="margin: 10px auto;" class="buttonlnk centerbtn">Return</a>';
                }
      				}
        		} else {
        			?>
        				<form class="box" method="post" action="">
        					<input type="password" name="current_pwd" placeholder="Current Password" autofocus required>
        					<input type="password" name="new_pwd" placeholder="New Password" required>
                  <input type="password" name="repeat_new_pwd" placeholder="Repeat Password" required>
        					<input type="submit" value="Submit" id="login_btn">
        				</form>
        			<?php 
             }
           }
         // User is requesting data from another user
    		} else {
	       echo '<h4>Access Denied.</h4>';
      }
      // user is not signed-in
    	} else {
	       echo '<h4>Access Denied.</h4>';
      }
    ?>

   <!-- Footer -->
    <div class="container"></div>
        <footer>
          <!-- Footer social -->
          <section class="ft-social">
            <ul class="ft-social-list">
              <li><h2 class="hvr-grow" style="text-shadow:2px 2px 4px #444444">Read. Write. Evolve.</h2></li>
            </ul>
          </section>
          
          <!-- Footer main -->
          <section class="ft-main">
            <div class="ft-main-item">
              <h2 class="ft-title">About</h2>
              <ul>
                <li><a href="#">About this Project</a></li>
                <li><a href="#">Portfolio</a></li>
                <li><a href="#">Sitemap</a></li>
                <li><a href="#"></a></li>
                <li><a href="#"></a></li>
              </ul>
            </div>
            <div class="ft-main-item">
              <h2 class="ft-title">Contact</h2>
              <ul>
                <li><a href="#">Contact us</a></li>
                <li><a href="https://webcoders.ch">Webcoders.ch</a></li>
                <li><a href="#"></a></li>
              </ul>
            </div>
            <div class="ft-main-item">
              <h2 class="ft-title"></h2>
              <ul>
                <li></li>
              </ul>
            </div>
            <div class="ft-main-item">
              <h2 class="ft-title">Get Started</h2>
              <p>Start writing your blog today and expense your knowledge even further.</p>
              <form method="get" action="register.php">
                <input type="email" name="email" placeholder="Enter email address">
                <input type="submit" value="Sign Up">
              </form>
            </div>
          </section>
        
          <!-- Footer legal -->
          <section class="ft-legal">
            <ul class="ft-legal-list">
              <li><a href="#">Terms &amp; Conditions</a></li>
              <li><a href="#">Privacy Policy</a></li>
              <li>&copy; 2020-<?php echo date("Y");?> Wuethrich Lisa</li>
            </ul>
      </section>
    </footer>
  </body>
</html>