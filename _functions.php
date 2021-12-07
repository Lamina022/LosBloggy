<?php

  
  function checkDBConnection($db_name)
  {
    if(!$db_name)
      echo "Debug-Error-Connection: ",mysqli_connect_error();
      exit;
  }
  
  
  // Selects data from a MySQL-Database
  // *********************************************
  function SelectQuery($table,$field,$extension)
  {
    // fetch data from other PHP files
    global $conf;
    
    $query="SELECT ".$field." FROM ".$table." ".$extension;
    $result=$conf['db']['conn']->query($query);
    
    if(!$result){ echo "Error on query"; }
    
    return $result;
  }
  
  // Selects a single object from a MySQL-Database
  // *********************************************
  function GetFieldValue($table,$field,$id)
  {
    global $conf;
        
    $query = SelectQuery($table,$field,' WHERE '.$table.'_id='.$id);
    while($obj = $query->fetch_object()) {
  		$result = $obj->$field;
    }
    
    return $result;
  }
  
  // Creates a new Record in a MySQL-Database
  // ********************************************
  function InsertQuery($table,$field,$value)
  {
    global $conf;
    
    $query="INSERT INTO ".$table." (".$field.") VALUES (".$value.")";
    $result=$conf['db']['conn']->query($query);
    
    if(!$result){ echo "Error on inserting<br>".$conf->error; }
    
    return $result;
  }
  
  // Delete a Record from a MySQL-Database
  // *******************************************
  function DeleteQuery($table,$id)
  {
    global $conf;
    
    $query="DELETE FROM ".$table." WHERE ".$table."_id= ".$id;
    $result=$conf['db']['conn']->query($query);
    
    if(!$result){ echo "Error on deleting<br>".$conf->error; }
    
    return $result;
  }
  
  // Updates a new Record in a MySQL-Database
  // ********************************************
  function UpdateQuery($table,$field,$value,$extension)
  {
    global $conf;
    
    $fields_array = explode(",", $field);
    $val = explode(",", $value);
    
    $query = "UPDATE ".$conf['vars']['prefix'].$table." SET ";
    for($i=0; $i<count($fields_array); $i++)
    {
  	  if($i==0)
      {
  		  $query .= $fields_array[$i]." = ".$val[$i];
  	  }
      else
      {
  		  $query .= ", ".$fields_array[$i]." = ".$val[$i];
  	  }
    }
    $query .= " ".$extension; 
    
    $result=$conf['db']['conn']->query($query);
    
    if(!$result){ echo "Error on updating<br>".$conf->error; }
    
    return $query;
  }
  
?>