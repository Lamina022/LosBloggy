<!DOCTYPE HTML>
<html>
  <head>
    <title>Edit - Homepage</title>
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
      
      $con = $conf['db']['sql_con'];
      
      $fetch_id = $fetch_title = $fetch_content = $fetch_date = "";
      
      $updated_title = $updated_content = $updated_tags = $updated_date = $last_editor = "";
      
    ?>
  </head>
  <body>
    <!-- Navigation Bar -->
      <ul class="topbar sticky" id="">
        <li class="topbar" id=""><a class="logo logo-header" href="index.php">Home</a></li>
        <?php
          if(isset($_SESSION["username"])) {
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
      <h1><a href="index.php" style="text-decoration: none;color:white;">Edit a Blog</a></h1>
      <p></p>
    </div>
    
    
    <!-- Body -->
    <?php      
    	// if user is logged on, continue
    	if(isset($_SESSION['username'])) {
       
       // fetch infos from database about a given blog
       if(isset($_GET['id'])) {
         $result_blog_fetch = SelectQuery("blog","blog_id,blog_title,blog_preview,blog_content,create_date,last_edit","WHERE blog_id='".$_GET['id']."'"); 
          while($obj = $result_blog_fetch->fetch_object()) {
            $fetch_id = $obj->blog_id;
            $fetch_title = $obj->blog_title;
            $fetch_preview = $obj->blog_preview;
            $fetch_content = $obj->blog_content;
            $fetch_date = $obj->create_date;
            $fetch_date = $obj->last_edit;
     			}
          
            // If form submitted, insert values into the database.
            if (isset($_POST['editblog'])){
                      
      			$updated_title = $_POST['title'];
      
      			// replace one or more whitespaces with an underline and trim it
      			$updated_title = preg_replace('/\s+/', '_', trim($updated_title));
      			$updated_title = str_replace("'", "''", "$updated_title");
      
      			// blogs content does not have special restrictions
            $updated_preview = str_replace("'", "''", $_POST['preview']);
            $updated_preview = preg_replace('/</', '(', trim($updated_preview));
            $updated_preview = preg_replace('/>/', ')', trim($updated_preview));
      			$updated_content = str_replace("'", "''", $_POST['content']);
      			//$blog_content = preg_replace('/\s+/', '_', trim($blog_content));
               
      			// blog tags are saved in a separate database
      			$updated_tags = $_POST['tags'];
      			$updated_tags = preg_replace('/\s+/', ',', trim($updated_tags));
      			$updated_tags = stripslashes($updated_tags);
      
      			// blog creation date
      			$updated_date = date("Y-m-d H:i:s");
            $last_editor = $_SESSION['username'];
            
            $result_blog = UpdateQuery("blog","blog_title,blog_preview,blog_content,last_edit,last_editor","'$updated_title','$updated_preview','$updated_content','$updated_date','$last_editor'","WHERE blog_id=$fetch_id");
            //$result_tag = UpdateQuery("tag","tag","'$tag'");
    
      			if($result_blog) {
      				echo '<div style="text-align: center">
      						  <h3>Blog successfully created.</h3><br>
      						  <div style="float:right;">
                      <a href="view.php?id='.$fetch_id.'">View Blog</a>
                      <a href="index.php">Home</a>
                    </div>';
      			} else {
              echo '<h3>There was an error saving the blog.</h3><br><p>Please try again later</p>';
            }
      		} else {
      			?>
      			<form method="post" action="">
      				<div class="column">
      					<label>Blog Title: </label>
      					<input type="text" name="title" placeholder="Title" value="<?php echo $fetch_title; ?>" id="title" autofocus>
                <label>Preview Text</label>
                <textarea onkeyup="textCounter(this,'counter',255);" name="preview" id="content" rows="5" cols="20"><?php echo $fetch_preview; ?></textarea>
      					<textarea name="content" id="content" rows="20" cols="50"><?php echo $fetch_content; ?></textarea>
      					<!-- <label>Tags: </label> -->
      					<!-- <input type="text" name="tags" placeholder="#awesome,#colorful,#important" value="<?php echo $tags; ?>" id="tags"> -->
      					<input type="submit" name="editblog" value="Save" class="createbtn">
      				</div>
      			</form>
            <script>
              function textCounter(field,field2,maxlimit)
              {
               var countfield = document.getElementById(field2);
               if ( field.value.length > maxlimit ) {
                field.value = field.value.substring( 0, maxlimit );
                return false;
               } else {
                countfield.value = maxlimit - field.value.length;
               }
              }
              function WordCount(str) {
               return str.split(' ').filter(function(n) { return n != '' }).length;
              }
            </script>
      			<?php
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