<!DOCTYPE HTML>
<html>
  <head>
    <title>Dashboard</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="design.css"> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>table {margin: auto;width: 100%;}table tr:nth-child(even) {background-color: #f2f2f2;}th, td {padding: 16px 40px;}</style>
    <?php
    // include our config.php file
    include("_config.php");
    include($conf['paths']['functions']);
      
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
      <h1><a href="index.php" style="text-decoration: none;color:white;">Dashboard</a></h1>
      <p></p>
    </div>
    
    
    <!-- Body -->
    <?php
      // Check if user is already signed-in
    	if(isset($_SESSION['username'])) {
        $result_uid = SelectQuery("user","user_id","WHERE username='".$_SESSION['username']."'");
        while($obj = $result_uid->fetch_object()) { $uid = $obj->user_id; }
       
       $result = SelectQuery("user","*","WHERE user_id=".$uid);
        while($obj = $result->fetch_object()) {
          $user_id = $obj->user_id;
          $username = $obj->username;
          $email = $obj->email;
          $password = $obj->password;
          $create_date = $obj->create_date;
          $last_login = $obj->last_login;
          $init_ip = $obj->initial_ip;
          $login_ip = $obj->last_login_ip;
          $failed_logins = $obj->amnt_failed_login;
          $last_pw_change = $obj->last_password_change;
   			}
        echo "<table style='margin: 50px auto;'>
                <tr><td>User ID</td><td>".$user_id."</td><td></td></tr>
                <tr><td>Username</td><td>".$username."</td><td><a class='buttonlnk' href='modifyUser.php?uid=".$user_id."&action=changeusername'>Change</a></td></tr>
                <tr><td>E-Mail</td><td>".$email."</td><td><a class='buttonlnk' href='modifyUser.php?uid=".$user_id."&action=changeemail'>Change</a></td></tr>
                <tr><td>Password</td><td style='color:green;'>Set, last updated: $last_pw_change</td><td><a class='buttonlnk' href='modifyUser.php?uid=".$user_id."&action=changepwd'>Update</a></td></tr>
                <tr><td>Account Created On</td><td>".$create_date."</td><td></td></tr>
                <tr><td>Registration IP-Address</td><td>".$init_ip."</td><td></td></tr>
                <tr><td>Last Successful Login</td><td>".$last_login."</td><td></td></tr>
                <tr><td>Last Logged-In IP</td><td>".$login_ip."</td><td></td></tr>
                <tr><td><b>Close Account</b></td><td></td><td><a class='buttonlnk fadebtn' href='modifyUser.php?uid=".$user_id."&action=delacc'>Delete</a></td></tr>
             </table>";
            
   		// user is not signed-in
    	} else {
         // User is signed-in -> redirect them to the index.php if they are trying to access login.php and skip the code below
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