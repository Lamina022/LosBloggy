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
      
      $username = "";
      $password = "";
      $con = $conf['db']['sql_con'];
      $date = date("Y-m-d H:i:s");
      $result = "";
      $num_failed_logins = 0;
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
      <h1><a href="index.php" style="text-decoration: none;color:white;">Sign In</a></h1>
      <p></p>
    </div>
    
    <!-- Body -->
    <?php
    	// Check if user is already signed-in
    	if(isset($_SESSION['username'])) {
          
    		// User is signed-in -> redirect them to the index.php if they are trying to access login.php and skip the code below
    		echo '<h4 class="comment-text">You are currently logged-in.<br><a href=index.php>Return to Home</a></h4>';
            
    		// user is not signed-in
    	} else {
    
    		// If form submitted, insert values into the database.
    		if (isset($_POST['uname'])) {
    
    			// Remove backslashes
    			$username = stripslashes($_POST['uname']);
               
    			// Escape special characters in a string
    			$username = mysqli_real_escape_string($con,$username);
    			$password = stripslashes($_POST['pwd']);
    			$password = mysqli_real_escape_string($con,$password);
               
    			//Checking if user is existing in the database or not
    			$query_result = SelectQuery("user","password","WHERE username='$username'");
    			$rows = mysqli_num_rows($query_result);
    			while($obj = $query_result->fetch_object()) {
                 $pw_hash = $obj->password;
    			}
    			
    			if($rows==1) {
    				// Verify stored hash against plain-text password
    				if (password_verify($password, $pw_hash)) {
    					
    					// Check if a newer hashing algorithm is available
    					// or the cost has changed
    					if (password_needs_rehash($pw_hash, PASSWORD_DEFAULT)) {
    						
    					  // If so, create a new hash, and replace the old one
    					  $new_hash = password_hash($password, PASSWORD_DEFAULT);
                UpdateQuery("user","password","'$new_hash'");
    					}
    					// --- Log user in ---
    					// There was one row found with that username
    						
    					// Create a browser session for the user
    					$result = UpdateQuery("user","last_login,last_login_ip,amnt_failed_login","'$date','".$_SERVER['REMOTE_ADDR']."',$num_failed_logins"," WHERE username='$username'");
              if($result) {
                $_SESSION['username'] = $username;
      				   
      					// Redirect user to index.php
      					header("Location: index.php");
              } else {
                echo "<div style='text-align: center'><br><h3>There was an error logging you in.</h3><br>Click here to <a href='login.php'>Try again</a></div>";
              }
    
    					// There was no user found with given username and password
    				} else {
               echo "<div style='text-align: center'><br><h3>Username and/or password is incorrect.</h3><br>Click here to <a href='login.php'>Login</a></div>";
               $num_failed_logins += 1;
    				}
    			} else {
    				echo "<div style='text-align: center'><br><h3>We're sorry but we found another user with the same username. A report has already been sent to the site's owner.<br></h3></div>";
    			}
    		} else {
    			?>
    				<form class="box" method="post" action="">
    					<input type="text" name="uname" placeholder="Username" autofocus required>
    					<input type="password" name="pwd" placeholder="Password" required>
    					<input type="submit" value="Login" id="login_btn">
    					<p>Not registered yet? <a href='register.php'>Register Here</a></p>
    				</form>
    			<?php echo "failed logins: ".$num_failed_logins; 
    		}
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