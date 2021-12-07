<?php
  // include our config.php file
  include("_config.php");
  include($conf['paths']['functions']);
  
  $vorname = "";
  $nachname = "";
  
  if($_POST['f']=="add"){ InsertQuery("daten","id,vorname,nachname","'','".$_POST['forename']."','".$_POST['name']."'"); }
  if($_POST['f']=="save"){ UpdateQuery("daten","vorname,nachname","'".$_POST['forename']."','".$_POST['name']."'","WHERE ID=".$_POST['id']); }
  
  if($_GET['f']=="del" and $_GET['id']!=""){ DeleteQuery("daten",$_GET['id']); }
  if($_GET['f']=="edit" and $_GET['id']!="")
  {
    $result = SelectQuery("daten","vorname,nachname","WHERE ID=".$_GET['id']);
    while($obj=$result->fetch_object())
    {
      $vorname = $obj->vorname;
      $nachname = $obj->nachname;
    }
  }
  
  
?>

<DOCTYPE HTML>
<html>
  <head>
    <title>Meine Datenbankanwendung</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="design.css">
    <style>
      body {
    	font-family: 'Arial', sans-serif;
    	font-size: 12pt;
    }
    
    table {
    	border-collapse: collapse;
    }
    
    	table tr:nth-child(even) {
    		background-color: #f2f2f2;
    	}
    
    	th, td {
    		padding: 8px 12px;
    	}
    
    	th {
    		border: 1px #000 solid;
    		background-color: #000;
    		color: #fff;
    		text-align: left;
    	}
    
    	td {
    		border: 1px #ddd solid;
    	}
    </style>
  </head>
  <body>
    <form method="post" action="" id="form">
        <?php
          if($_GET['f']=="edit")
          {
            echo '<input type="hidden" name="f" value="save">';
            echo '<input type="hidden" name="id" value="'.$_GET['id'].'">';
          }
          else
          {
            echo '<input type="hidden" name="f" value="add">';
          }
        ?>
        <input type="text" name="forename" placeholder="Forename" value="<?php echo $vorname; ?>" autofocus required><br>
        <input type="text" name="name" placeholder="Name" value="<?php echo $nachname; ?>" required><br>
        <input type="submit" value="Submit"><br><br>
    </form>
    <?php
      $result = SelectQuery("blog","*","");
      echo "<table>";
      echo "<tr><th>ID</th><th>Vorname</th><th>Nachname</th><th>Edit</th><th>Delete</th></tr>";
      while($obj=$result->fetch_object())
      {
        echo "<tr><td>".$obj->id."</td><td>".$obj->vorname."</td><td>".$obj->nachname."</td><td><a href='index.php?f=edit&id=".$obj->id."'>Edit</a></td><td><a href='index.php?f=del&id=".$obj->id."'>Delete</a></td></tr>";
      }
      echo "</table>";
    ?>
  </body>
</html>