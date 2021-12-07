<!DOCTYPE HTML>
<html>
  <head>
    <title>Modify Account</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="design.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <?php
      // Include our config.php file
      include('_config.php');
      include($conf['paths']['functions']);
      
      $con = $conf['db']['sql_con'];
      $date = date("Y-m-d H:i:s");
      $new_pass = $current_pass = $repeat_pass = $err = "";
  ?>
  </head>
  <body>
    <!-- Navigation Bar -->
      <ul class="topbar sticky" id="">
        <li class="topbar" id=""><a class="logo logo-header" href="index.php">Home</a></li>
        <?php
          if(isset($_SESSION['username'])) {
            echo '<li class="dropdown" id="" style="float:right">
                    <a class="topbar dropdown" href="dashboard.php"><span class="glyphicon glyphicon-user"></span> '.$_SESSION['username'].'</i></a>
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
      <h1><a href="index.php" style="text-decoration: none;color:white;">Modify your account</a></h1>
      <p></p>
    </div>
    
    <!-- Body -->
    <?php
    	// Check if user is already signed-in
    	if(isset($_SESSION['username'])) {
        $result_uid = SelectQuery("user","user_id","WHERE username='".$_SESSION['username']."'");
        while($obj = $result_uid->fetch_object()) {
            $uid = $obj->user_id;
        }
        if($uid==$_GET['uid']) {
          if($_GET['action']=='changepwd') {
              
        		// If form submitted, insert values into the database.
        		if (isset($_POST['current_pwd']) and isset($_POST['new_pwd'])) {
        
        			// Remove backslashes
        			$current_pass = stripslashes(trim($_POST['curent_pwd']));
              $new_pass = stripslashes(trim($_POST['new_pwd']));
              $repeat_pass = stripslashes(trim($_POST['repeat_pwd']));
                                 
        			//Checking if user is existing in the database or not
        			$query_result = SelectQuery("user","password","WHERE username='".$_SESSION['username']."'");
        			while($obj = $query_result->fetch_object()) {
                     $pw_hash = $obj->password;
        			}
        			
      				// Ensure, that it's a new Password
      				if (password_verify($new_pass, $pw_hash)) {
                $err .= "<br><h3 style='text-align: center'>Cannot use the same Password.<br>Please choose a new one.</h3>";
                $tmp = true;      
      				}
              
              // Validate password
              if(strlen(trim($new_pass)) < 6) {
                  $err .= "<br>Password must have atleast 6 characters.";
                  $tmp = true;  
              }
              
              // Validate confirm password 
              /*if($new_pass != $repeat_pass) {
                  $err .= "<br>Password did not match.";
                  $tmp = true;
              }*/
              
              // write into data 
              if(empty($err) or $tmp == false) { 
                  $new_pass = stripslashes($new_pass);
                  $new_pass = mysqli_real_escape_string($con,$new_pass);       
                  $result = UpdateQuery("user","password,last_password_change","'".password_hash($new_pass, PASSWORD_DEFAULT)."','$date'","WHERE user_id=$uid");
                  
              } else {
                echo '<p style="text-align:center;color:red;"><br><br>'.$err.'</p><br><br>
                      <a href="modifyUser.php?uid='.$_GET['uid'].'&action=changepwd" style="margin: 10px auto;" class="buttonlnk centerbtn">Return</a>';
              }
              if($result) {
                session_destroy();
                echo "<div style='text-align: center'>
                        <h3>Password successfully updated</h3>
                        <br>Click here to <a href='login.php'>Login</a>
                      </div>";
              } else {
                  echo '<p style="text-align:center;color:red;"><br><br>There was an error updating your password.<br>Please try again later.</p><br><br>
                        <a href="dashboard.php" style="margin: 10px auto;" class="buttonlnk centerbtn">Return to Dashboard</a>';
              }
             } else {
             ?>
        				<form class="box" method="post" action="">
        					<h2>Change Password</h2>
                  <input type="password" name="current_pwd" placeholder="Current Password" autofocus required>
        					<input type="password" name="new_pwd" placeholder="New Password" required>
                  <input type="password" name="repeat_new_pwd" placeholder="Repeat Password" required>
        					<input type="submit" value="Submit" id="login_btn">
        				</form>
        			<?php
             }
           } elseif($_GET['action']=='changeusername') {
             if (isset($_POST['new_uname'])) {
                // Remove backslashes
          			$new_username = stripslashes(trim($_POST['new_uname']));
                                   
          			//Checking if user is existing in the database or not
                $query_result = SelectQuery("user","username","WHERE username='$new_username'");
                while($obj = $query_result->fetch_object()) {
                    $current_username = $obj->username;
                }
                if($current_username==$new_username) {
                    $err = "This username is already taken.";
                    $tmp = true;
                } 
                
                // write into data 
                if(empty($err) or $tmp == false) { 
                    $new_username = stripslashes($new_username);
                    $new_username = mysqli_real_escape_string($con,$new_username);       
                    $result = UpdateQuery("user","username","'$new_username'","WHERE user_id=$uid");
                    
                } else {
                  echo '<p style="text-align:center;color:red;"><br><br>'.$err.'</p><br><br>
                        <a href="modifyUser.php?uid='.$_GET['uid'].'&action=changeusername" style="margin: 10px auto;" class="buttonlnk centerbtn">Return</a>';
                }
                if($result) {
                  session_destroy();
                  echo "<div style='text-align: center'>
                          <h3>Username successfully updated</h3>
                          <br>Click here to <a href='login.php'>Login</a>
                        </div>";
                } else {
                    echo '<p style="text-align:center;color:red;"><br><br>There was an error updating your username.<br>Please try again later.</p><br><br>
                          <a href="dashboard.php" style="margin: 10px auto;" class="buttonlnk centerbtn">Return to Dashboard</a>';
                }
               } else {
               echo '<form class="box" method="post" action="">
            					<h2>Change Username</h2>
                      <input type="text" name="new_uname" placeholder="New Username" autofocus required>
            					<input type="submit" value="Submit" id="login_btn">
            				</form>';
             }
           } elseif($_GET['action']=='changeemail') {
             if (isset($_POST['new_email_in'])) {
                // Remove backslashes
          			$new_email = stripslashes(trim($_POST['new_email_in']));
                                   
          			//Checking if user is existing in the database or not
                $query_result = SelectQuery("user","email","WHERE username='".$_SESSION['username']."'");
                while($obj = $query_result->fetch_object()) {
                    $current_email = $obj->email;
                }
                if($current_email==$new_email) {
                    $err = "An account with this email already exists.<br><a href='login.php'>Login</a> instead?";
                    $tmp = true;
                } 
                
                // write into data 
                if(empty($err) or $tmp == false) { 
                    $new_email = stripslashes($new_email);
                    $new_email = mysqli_real_escape_string($con,$new_email);       
                    $result = UpdateQuery("user","email","'$new_email'","WHERE user_id=$uid");
                    
                } else {
                  echo '<p style="text-align:center;color:red;"><br><br>'.$err.'</p><br><br>
                        <a href="modifyUser.php?uid='.$_GET['uid'].'&action=changeemail" style="margin: 10px auto;" class="buttonlnk centerbtn">Return</a>';
                }
                if($result) {
                  echo "<div style='text-align: center'>
                          <h3>E-Mail successfully updated</h3>
                          <br>Click here to <a href='dashboard.php'>Return to Dashboard</a>
                        </div>";
                } else {
                    echo '<p style="text-align:center;color:red;"><br><br>There was an error updating your email.<br>Please try again later.</p><br><br>
                          <a href="dashboard.php" style="margin: 10px auto;" class="buttonlnk centerbtn">Return to Dashboard</a>';
                }
               } else {
               echo '<form class="box" method="post" action="">
            					<h2>Change E-Mail</h2>
                      <input type="text" name="new_email_in" placeholder="New E-Mail" autofocus required>
            					<input type="submit" value="Submit" id="login_btn">
            				</form>';
             }
           } elseif($_GET['action']=='delacc') {
              if (isset($_POST['delconfirm'])) {
                  // Remove backslashes
                  $password = stripslashes(trim($_POST['delconfirm']));
          
                  //Checking if user is existing in the database or not
                  $query_result = SelectQuery("user","password","WHERE username='".$_SESSION['username']."'");
                  while($obj = $query_result->fetch_object()) {
                    $pw_hash = $obj->password;
                  }
          
                  // Ensure password match
                  if (!password_verify($password, $pw_hash)) {
                      $err .= '<div style="text-align: center"><br><h3>The password is incorrect.</h3>';
                      $tmp = true;      
                  }
          
                  // delete account
                  if(empty($err) or $tmp == false) {
                      $result = DeleteQuery("user","$uid");
          
                  } else {
                      echo '<p style="text-align:center;color:red;"><br><br>'.$err.'</p><br><br>
                      <a href="modifyUser.php?uid='.$_GET['uid'].'&action=delacc" style="margin: 10px auto;" class="buttonlnk centerbtn">Return</a>';
                  }
                  if($result) {
                      session_destroy();
                      echo "<div style='text-align: center'>
                      <h3>Account successfully deleted.</h3>
                      </div>";
                  } else {
                      echo '<p style="text-align:center;color:red;"><br><br>There was an error deleting your account.<br>Please try again later.</p><br><br>
                      <a href="dashboard.php" style="margin: 10px auto;" class="buttonlnk centerbtn">Return to Dashboard</a>';
                  }
              } else {
                  echo '<form class="box" method="post" action="">
                  <h2>Delete Account</h2>
                  <p style="color:red;">WARNING: You are about to DELETE your account. All Data will be lost, however your blogs and comments will stay.<br>Please enter your password to proceed.</p>
                  <input type="password" name="delconfirm" placeholder="Enter your password" autofocus required>
                  <input type="submit" style="background-color:red;" value="Delete my Account" id="login_btn">
                  </form>';
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