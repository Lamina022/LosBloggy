<!DOCTYPE HTML>
<html>
  <head>
    <title>Create - Homepage</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="design.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://cdn.tinymce.com/4/tinymce.min.js"></script>
    
    <!-- IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <?php
      // include our config.php file
      include("_config.php");
      include($conf['paths']['functions']);
      
      $blog_title = $blog_content = $blog_preview = $blog_tags = $create_date = "";
      
    ?>
    <script>
      function addtxt(input) {
        var obj=document.getElementById(input)
        var txt=document.createTextNode(<?php echo $target_file; ?>)
        obj.appendChild(txt)
      }
    </script>
    <script type="text/javascript">
     // Editor (Textarea)
     tinymce.init({
       forced_root_block: "",
       force_br_newlines: true,
       force_p_newlines: false,
       selector: '#tinymce-editor',
       skin: (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'oxide-dark' : ''), // base the skin version on the user’s preference as specified in their operating system
       content_css: (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : ''),
       height: 500,
       plugins: [
              'advlist autolink lists link image',
              'searchreplace visualblocks',
              'table paste textcolor code'
       ],
       statusbar: false,
       toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | code image visualblocks table | searchreplace advlist autolink',
       menubar: false,
       // without images_upload_url set, Upload tab won't show up
        images_upload_url: 'imageHandler.php',
        
        // override default upload handler to simulate successful upload
        images_upload_handler: function (blobInfo, success, failure) {
            var xhr, formData;
          
            xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', 'imageHandler.php');
          
            xhr.onload = function() {
                var json;
            
                if (xhr.status != 200) {
                    failure('HTTP Error: ' + xhr.status);
                    return;
                }
            
                json = JSON.parse(xhr.responseText);
            
                if (!json || typeof json.location != 'string') {
                    failure('Invalid JSON: ' + xhr.responseText);
                    return;
                }
            
                success(json.location);
            };
          
            formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());
          
            xhr.send(formData);
        },
     });
  </script>

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
      <h1><a href="index.php" style="text-decoration: none;color:white;">Create a new Blog</a></h1>
      <p></p>
    </div>
    
    <!-- Body -->
<?php      
	// if user is logged on, continue
	if(isset($_SESSION['username'])) {
		
		// If form submitted, insert values into the database.
		if (isset($_POST['title'])) {
			$blog_title = $_POST['title'];

			// replace one or more whitespaces with an underline and trim it
			$blog_title = preg_replace('/\s+/', '_', trim($blog_title));
			$blog_title = str_replace("'", "''", "$blog_title");
      $blog_title = preg_replace('/</', '(', trim($blog_title));
      $blog_title = preg_replace('/>/', ')', trim($blog_title));

			// blogs content does not have special restrictions
      $blog_preview = str_replace("'", "''", $_POST['preview']);
      $updated_preview = preg_replace('/</', '(', trim($updated_preview));
      $updated_preview = preg_replace('/>/', ')', trim($updated_preview));
			$blog_content = str_replace("'", "''", $_POST['content']);
			//$blog_content = preg_replace('/\s+/', '_', trim($blog_content));
         
			// blog tags are saved in a separate database
			$blog_tags = $_POST['tags'];
			$blog_tags = preg_replace('/\s+/', ',', trim($blog_tags));
			$blog_tags = stripslashes($blog_tags);

			// blog creation date
			$create_date = date("Y-m-d H:i:s");
      
      $result_uid = SelectQuery("user","user_id","WHERE username='".$_SESSION['username']."'");
      while($obj = $result_uid->fetch_object()) {
        $uid = $obj->user_id;
			}
      
      $fetch_id_query = 'SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = "project-wul" AND TABLE_NAME = "blog"';
      $fetch_id_result = mysqli_query($conf['db']['sql_con'],$fetch_id_query);
      while($obj = $fetch_id_result->fetch_object()) {
        $fetch_id = $obj->AUTO_INCREMENT;
			}
         
			$query_blog = InsertQuery("blog", "blog_id,blog_title,blog_preview,blog_content,create_date,user_id",
                                "'','$blog_title','$blog_preview','$blog_content','$create_date',$uid");
			//$query_tag = InsertQuery("tag", "tag_id,blog_tag_id,tag", "'','','$tag'");

			if($query_blog) {
			  echo '<div style="text-align: center">
			        <h3>Blog successfully created.</h3><br>
			        <div>
                 <a style="margin: 10px auto;" class="buttonlnk centerbtn showbtn" href="view.php?id='.$fetch_id.'">View Blog</a>
                 <a style="margin: 10px auto;" class="buttonlnk centerbtn" href="index.php">Home</a>
                 <a style="margin: 10px auto;" class="buttonlnk centerbtn" href="create-new.php">Create a new Blog</a>
               </div>';
			} else {
       echo '<h3>There was an error saving the blog.</h3><br><p>Please try again later</p>';
      }
      
      if(isset($_POST['uploadImg'])) {
      
        $target_dir = "images/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
          $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
          if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
          } else {
            echo "File is not an image.";
            $uploadOk = 0;
          }
        }
        /***************************************************
         * Only these origins are allowed to upload images *
         ***************************************************/
        $accepted_origins = array("http://localhost");
        reset ($_FILES);
        $temp = current($_FILES);
        if (isset($_SERVER['HTTP_ORIGIN'])) {
          // same-origin requests won't set an origin. If the origin is set, it must be valid.
          if (in_array($_SERVER['HTTP_ORIGIN'], $accepted_origins)) {
            header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
          } else {
            header("HTTP/1.1 403 Origin Denied");
            return;
          }
        }
        
        // Sanitize input
        if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])) {
            header("HTTP/1.1 400 Invalid file name.");
            return;
        }
        
        // Check if file already exists
        if (file_exists($target_file)) {
          echo "File already exists.";
          $uploadOk = 0;
        }
        
        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000) {
          echo "File is too large.";
          $uploadOk = 0;
        }
        
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
          echo "Only JPG, JPEG, PNG & GIF files are allowed.";
          $uploadOk = 0;
        }
        
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
          echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
          if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
              
              // Respond to the successful upload with JSON.
              // Use a location key to specify the path to the saved image resource.
              // { location : '/your/uploaded/image/file'}
              echo json_encode(array('location' => $target_file));
            
              $fetch_medium_id_query = 'SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = "project-wul" AND TABLE_NAME = "medium"';
              $fetch_medium_id_result = mysqli_query($conf['db']['sql_con'],$fetch_medium_id_query);
              while($obj = $fetch_medium_id_result->fetch_object()) {
                $medium_id = $obj->AUTO_INCREMENT;
        			}
              
              $fetch_medium_blog_id_query = 'SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = "project-wul" AND TABLE_NAME = "blog_medium"';
              $fetch_medium_blog_id_result = mysqli_query($conf['db']['sql_con'],$fetch_medium_blog_id_query);
              while($obj = $fetch_medium_blog_id_result->fetch_object()) {
                $medium_blog_id = $obj->AUTO_INCREMENT;
        			}
              
              $query_medium = InsertQuery("medium", "medium_id, blog_medium_id, path_to_media", "'','$medium_blog_id','$target_file'");
              $query_blog_medium = InsertQuery("blog_medium", "blog_medium_id, medium_id, blog_id", "'','$medium_id','$fetch_id'");
              
              if($query_medium and $query_blog_medium) {
                echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
              }
          } else {
            echo "Sorry, there was an error uploading your file.";
            // Notify editor that the upload failed
            header("HTTP/1.1 500 Server Error");
          }
        }
      }
		} else {
			?>
			<form method="post" action="">
				<div class="column">
					<label>Blog Title</label>
					<input type="text" name="title" placeholder="Title" value="" id="title" autofocus required>
          <label>Preview Text</label>
          <textarea onkeyup="textCounter(this,'counter',255);" name="preview" id="content" rows="5" cols="20"></textarea>
          <p id="remaining_words"></p>
					<textarea name="content" id="tinymce-editor" rows="20" cols="50"></textarea>
					<!-- <label>Tags: </label> -->
					<!-- <input type="text" name="tags" placeholder="#awesome,#colorful,#important" value="<?php echo $tags; ?>" id="tags"> -->
					<input type="submit" name="addblog" value="Create" class="createbtn">
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
	} else {
     header("Location: login.php");
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