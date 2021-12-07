<!DOCTYPE HTML>
<html>

<head>
    <title>Homepage</title>
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
      
      $blog_id = $blog_title = $blog_content = $blog_tags = "";
      $create_date = "";
      $tags = "";
      $comments = $comment_content = $comment_id = "";
      
      $uid = "";
      $bloguid = "";
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
          } else {
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
    <?php      
    // If form submitted, insert values into the database.
    if (isset($_GET['id'])) {
        $blogid = $_GET['id'];
                    
        $result_blog = SelectQuery("blog","blog_title, blog_preview, blog_content, create_date","WHERE blog_id='".$blogid."'");
        while($obj = $result_blog->fetch_object()) {
            $blog_title = $obj->blog_title;
            $blog_preview = $obj->blog_preview;
            $blog_content = $obj->blog_content;
            $create_date = $obj->create_date;
     	  }
        //$blog_title = preg_replace('_', ' ', trim($blog_title));
        $blog_title = str_replace("''", "'", "$blog_title");
        $blog_preview = str_replace("''", "'", $blog_preview);
        $blog_content = str_replace("''", "'", $blog_content);
         
        // make our queries
	      $result_right_panel = SelectQuery("blog","blog_id,blog_title, blog_preview, create_date, user_id","ORDER BY create_date DESC");
                  
		?>
		<div class="row">
			<div class="leftcolumn" style="background-color:white;">
				<h1 style="margin:50px 100px;"><?php echo $blog_title ?></h1>
				<h4 style="margin:5px 100px;float:right;"><?php echo $create_date ?></h4><br><br>
        <p style="margin:30px 100px;"><b><?php echo $blog_preview ?></b></p><br>
				<p style="margin:30px 100px;"><?php echo $blog_content ?></p>
				<?php
				// if user is logged on, continue
				if(isset($_SESSION['username'])) {
							
					$con = $conf['db']['sql_con'];
						  
					$result_uid = SelectQuery("user","user_id,admin","WHERE username='".$_SESSION['username']."'");
					while($obj = $result_uid->fetch_object()) {
						$uid = $obj->user_id;
            $is_admin = $obj->admin;
					}
							
					$result_bloguid = SelectQuery("blog","user_id,is_locked","WHERE blog_id='".$blogid."'");
					while($obj = $result_bloguid->fetch_object()) {
						$bloguid = $obj->user_id;
            $is_locked = $obj->is_locked;
					}
							 
					if($uid==$bloguid or $is_admin==1) {
							echo '<div><a class="buttonlnk" style="margin-left: 100px;" href="edit.php?id='.$blogid.'">Edit</a>
						        <a class="buttonlnk" href="delete.php?id='.$blogid.'&uid='.$uid.'">Delete</a>';
              if($is_locked==0) {
                echo '<a class="buttonlnk" style="margin-left: 4px;" href="view.php?id='.$blogid.'&lock=1">Disable Comments</a></div>';
              } else {
                echo '<a class="buttonlnk" style="margin-left: 4px;" href="view.php?id='.$blogid.'&lock=0">Enable Comments</a></div>';
              }
              if(isset($_GET['lock'])) {
                if($_GET['lock']==1) {
                  $result_lock = UpdateQuery("blog","is_locked","1", "WHERE blog_id='".$blogid."'");
                } 
                if($_GET['lock']==0) {
                  $result_unlock = UpdateQuery("blog","is_locked","0", "WHERE blog_id='".$blogid."'");
                }
                if($result_lock or $result_unlock) { echo '<h4 class="comment-text">Action completed successfully<br><a href=view.php?id='.$blogid.'>Refresh</a></h4>'; }
                else { echo '<h4 class="comment-text">There was an error while completing the requested action.<br>Please try again later.<br><a href=view.php?id='.$blogid.'>Refresh</a></h4>'; }
              }
  					}
           
           // COMMENTS
           if($is_locked==0) {
    				if (isset($_POST['comment_content'])) {
    					$comment_content = str_replace("'", "''", $_POST['comment_content']);
    					$comment_content = stripslashes($comment_content);
    					
    					// comment creation date
    					$create_date = date("Y-m-d H:i:s");
    					
    					$result_insert_comment = InsertQuery("comment","comment_id,blog_id,user_id,comment,create_date","'','$blogid','$uid','$comment_content','$create_date'");
    					
    					
    					if($result_insert_comment) {
    						//header("Refresh:0"); // just refresh the page to show the new comment
    					} else {
    						echo '<br><h4 style="text-align:center;">There was an error adding the comment. Please try again later.</h4>';
    					}
    				} else {
    					echo '<form method="post" action="">
    							    <div class="comment-text">
    								    <label style="margin: 0px 20px;">Add Comment: </label>
    								    <textarea name="comment_content" id="content" rows="5" cols="5"></textarea>
    								    <input type="submit" value="Submit">
    							    </div>
    						    </form>';
    				}
				} else { echo '<h4 class="comment-text">Comments are disabled for this Blog.</h4>'; }
        } else { echo '<h4 class="comment-text"><a href="login.php">Please Sign In to comment.</a></h4>'; }
				?>
				<?php
				  // COMMENT
				  $result_comment = SelectQuery("comment","comment, user_id, create_date","WHERE blog_id='".$blogid."' ORDER BY create_date DESC");
				  while($obj = $result_comment->fetch_object()) {
            $username = GetFieldValue("user","username",$obj->user_id);
            $comment_date = $obj->create_date;
				    echo '<div class="comment"><label>'.$username.', '.$comment_date.' wrote:</label><br><p>'.str_replace("''", "'", $obj->comment).'</p></div>';
			  }
         //echo "username: ".$username;
				?>
			</div>
		
        <div class="rightcolumn" style="background-color:white;float:right">
            <div class="recents" style="box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.2), 0 3px 10px 0 rgba(0, 0, 0, 0.19);">
                <h3>Latest Posts</h3>
                <?php
          $i = 0;
  				while($obj=$result_right_panel->fetch_object() and $i <= 4) {
            $blog_id = $obj->blog_id;
            // prepare username
            $username = GetFieldValue("user","username",$obj->user_id);
            if(empty($username)) { $username = '<em>Deleted User</em>'; }
  					echo '<div class="card hvr-grow">
        						<div class="previewimg" style="height:200px;">Image</div>
        						<div class="card-content">
        							<h2><a href="view.php?id='.$blog_id.'" style="text-decoration: none;color:black;">'.$obj->blog_title.'</a></h2>
        							<h5>'.$username.', '.$obj->create_date.'</h5>
        							<p>'.$obj->blog_preview.'</p>
        						</div>
      					</div>';
                $i=$i+1;  
    			}
				?>
            </div>
        </div>
        <?php 
    } else {
        echo '<h2>Blog not found.</h2>';
    }
    ?></div>

    <!-- Footer -->
    <div class="container"></div>
    <footer>
        <!-- Footer social -->
        <section class="ft-social">
            <ul class="ft-social-list">
                <li>
                    <li><h2 class="hvr-grow" style="text-shadow:2px 2px 4px #444444">Read. Write. Evolve.</h2></li>
                </li>
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
                <li>&copy; 2020 Wuethrich Lisa</li>
            </ul>
        </section>
    </footer>
</body>

</html>