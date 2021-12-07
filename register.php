<!DOCTYPE HTML>
<html>
  <head>
    <title>Sign Up</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="design.css">    
    <?php
      // Include our config.php file
      include('_config.php');
      include($conf['paths']['functions']);
      
      $username = "";
      $email = "";
      $password = "";
      $con = $conf['db']['sql_con'];
      $result = "";
  ?>
  </head>
  <body>
    <!-- Navigation Bar -->
      <ul class="topbar sticky" id="">
        <li class="topbar" id=""><a class="logo logo-header" href="index.php">Home</a></li>
        <?php
          if(isset($_SESSION["uid"])) {
            echo '<li class="topbar" id="" style="float:right"><a href="dashboard.php"><span class="glyphicon glyphicon-user"></span> '.$_SESSION['username'].'</a></li>';
          } 
          else {
            echo '<li class="topbar" id="" style="float:right"><a href="login.php">Log In</a></li>
                  <li class="topbar" id="" style="float:right"><a class="active" href="register.php">Sign Up</a></li>';
          }
        ?>
      </ul>
        
    <!-- Header -->
    <div class="banner">
      <h1><a href="index.php" style="text-decoration: none;color:white;">Sign Up</a></h1>
      <p></p>
    </div>
    
    <!-- Body -->
    <?php
    // check, that no session id is existing, if one exists, redirect to index.php
    if(!isset($_SESSION["uid"])) {     
        // If form submitted, insert values into the database.
        if (isset($_POST['uname'])) {
            $username = $_POST['uname'];
            $email = $_POST['email'];
            $password = $_POST['pwd'];
            $pw_repeat = $_POST['pwd_repeat'];
            $create_date = date("Y-m-d H:i:s");

            // store errors
            $err = '';
            $tmp = false;


            //Checking if user is existing in the database or not
            $query_result = SelectQuery("user","username","WHERE username='$username'");
            while($obj = $query_result->fetch_object()) {
                $fetch_uname = $obj->username;
            }
            if($fetch_uname==$username) {
                $err = "This username is already taken.";
            } else {
                // removes backslashes
                $username = stripslashes($_POST['uname']);

                //escapes special characters in a string
                $username = mysqli_real_escape_string($con,$username);
            }

            //Checking if email is existing in the database or not
            $query_result = SelectQuery("user","email","WHERE email='$email'");
            while($obj = $query_result->fetch_object()) {
                $fetch_email = $obj->email;
            }
            if($fetch_email==$email) {
                $err .= "<br>A user with this email already exists. Please Sign In.";
            } else {
                $email = stripslashes($email);
                $email = mysqli_real_escape_string($con,$email);
            }

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
                $result = InsertQuery("user","user_id,username,password,email,create_date,initial_ip,last_password_change","'', '$username', '".password_hash($password, PASSWORD_DEFAULT)."', '$email', '$create_date','".$_SERVER['REMOTE_ADDR']."','$create_date'");
                if($result) {
                echo "<div style='text-align: center'>
                <br><br><br><h3>Registration successful</h3>
                <br>Click here to <a href='login.php'>Login</a>
                </div>";
                } else {
                  echo '<p style="text-align:center;color:red;"><br><br>There was an error updating your password.<br>Please try again later.</p><br><br>
                        <a href="register.php" style="margin: 10px auto;" class="buttonlnk centerbtn">Return</a>';
                }
            } else {
              echo '<p style="text-align:center;color:red;"><br><br>'.$err.'</p><br><br>
                    <a href="register.php" style="margin: 10px auto;" class="buttonlnk centerbtn">Return</a>';
            }
        } else {
        ?>
<form class="box" method="post" action="">
    <h1>Register</h1>
    <p style="text-align:center;color:red;"><?php echo $err ?></span></p>
    <input type="text" name="uname" value="<?php echo $username; ?>" placeholder="Username" autofocus required>
    <input type="text" name="email" value="<?php echo $_GET['email'] ?>" placeholder="E-Mail" required>
    <input type="password" name="pwd" placeholder="Password" required>
    <input type="password" name="pwd_repeat" placeholder="Repeat Password" required>
    <input type="checkbox" name="chkbox" value="accept_terms" required>I accept the <a href="#">terms of service</a>.
    <input type="submit" value="Register" id="register_btn">
    <p>Already have an account? <a href="login.php">Login here</a>.</p>
</form>
<?php 
        }
    } else {
    echo '<h4 style="text-align:center;">You are already Signed In.</h4>';
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