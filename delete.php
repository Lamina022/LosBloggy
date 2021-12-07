<!DOCTYPE HTML>
<html>
  <head>
    <title>Confirm Delete - Homepage</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="design.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    
    <!-- IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <?php
      // include our config.php file
      include("_config.php");
      include($conf['paths']['functions']);
      
      $blog_title = $blog_content = $blog_tags = $create_date = "";
      
    ?>
  </head>
  <body>
    <!-- Navigation Bar -->
      <ul class="topbar sticky" id="">
        <li class="topbar" id=""><a class="logo logo-header" href="index.php">Home</a></li>
        <?php
          if(isset($_SESSION['username'])) {
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
      <h1><a href="index.php" style="text-decoration: none;color:white;">Delete a Blog</a></h1>
      <p></p>
    </div>
    
    <!-- Body -->
    <?php
        if(isset($_SESSION['username'])) {

            $result_uid = SelectQuery("user","user_id","WHERE username='".$_SESSION['username']."'");
            while($obj = $result_uid->fetch_object()) {
                //$bloguid = GetFieldValue("blog","user_id",$obj->user_id);
                $uid = $obj->user_id;
            }
            if($uid==$_GET['uid']) {
                echo '<div >
                        <h4 style="display:flex;justify-content:center;align-self:center;">Are you sure you want to delete this blog?</h4><br>
                        <a style="margin: 10px auto;" class="buttonlnk centerbtn" href="view.php?id='.$_GET['id'].'">No</a>
                        <a style="margin: 10px auto;" class="buttonlnk centerbtn fadebtn" href="delete.php?id='.$_GET['id'].'&uid='.$_GET['uid'].'&del=true">Yes</a>
                      </div>';

                if(isset($_GET['del'])) {

                    $success = DeleteQuery("blog",$_GET['id']);
                    if($success) {
                        echo '<br><h3 style="text-align: center">Blog successfully deleted.</h2><br>
                        <p style="text-align: center"><a href="index.php">Click here</a> to return to the homepage</p>';
                    } else {
                        echo '<br><h3 style="text-align: center">There was an error deleting this blog. Please try again later.</h2><br>';
                    }
                }
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