<!DOCTYPE HTML>
<html>
  <head>
    <title>Homepage</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="design.css">
    <link rel="stylesheet" type="text/css" href="hover.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    
    <!-- IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <?php
      // include our config.php file
      include("_config.php");
      include($conf['paths']['functions']);
    ?>
  </head>
  <body style="background-color:#f1f1f1;">
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
      <h1><a href="index.php" style="text-decoration: none;color:white;">Los Bloggy</a></h1>
      <p>A project from Lisa Wuethrich</p>
    </div>
    
    <!-- Body -->
    <a href="create-new.php" class="create buttonlnk showbtn"><span class="glyphicon glyphicon-plus-sign">&nbsp</span>Create Blog</a>
<?php

	// make our queries
	$result_left_panel = SelectQuery("blog","blog_id,blog_title, blog_preview, create_date, user_id","");
	$result_right_panel = SelectQuery("blog","blog_id,blog_title, blog_preview, create_date, user_id","ORDER BY create_date DESC");
	
echo '<div class="row">
      <div class="leftcolumn">';
    $i=0; 
    while($obj=$result_left_panel->fetch_object()) {
      // prepare username
      $username = GetFieldValue("user","username",$obj->user_id);
      if(empty($username)) { $username = '<em>Deleted User</em>'; }
      $blog_id = $obj->blog_id; echo '
    	
    		<div class="card hvr-grow">
    		<div class="previewimg" style="height:200px;">Image</div>
    			<div class="card-content">
    				<h2><a href="view.php?id='.$blog_id.' "style="text-decoration:none;color:black;">'.$obj->blog_title.'</a></h2>
    				<h5>'.$username.', '.$obj->create_date.'</h5>
    				<p>'.$obj->blog_preview.'</p>
    			</div>
    		</div>'; } ?>
    	</div>
    	<div class="rightcolumn">
    		<div class="card">
  				<h2 class="quote">It is not death we wish to avoid but life to live.</h2>
    		</div>
    		<div class="recents">
    			<h3>Latest Posts</h3>
    			<?php while($obj=$result_right_panel->fetch_object() and $i <= 4 ) { echo '
    					<div class="card hvr-grow" style="box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.2), 0 3px 10px 0 rgba(0, 0, 0, 0.19);">
    						<div class="previewimg" style="height:200px;">Image</div>
    						<div class="card-content">
    							<h2><a href="view.php?id='.$blog_id.' "style="text-decoration: none;color:black;">'.$obj->blog_title.'</a></h2>
    							<h5>'.$username.', '.$obj->create_date.'</h5>
    							<p>'.$obj->blog_preview.'</p>
    						</div>
    					</div>';
              $i=$i+1; 
    			} ?>
    		</div>
    	</div>
    </div></div>


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