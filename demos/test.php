<?php

session_start();

$lisa = "10.26.40.10";
echo '<a href="http://'.$lisa.'/index.php">Website</a><br>';	

echo 'Hello<br>';

$_POST['post'];
$_SET['set'];

// $_SESSION is a preset array
// if that is commented out when it was previously set, it will still be there. for the session to kill, we need 'unset'
$_SESSION['session_test'] = "Session1";

// is session set
//if(isset($_SESSION['session_test']))
//{
  if($_SESSION['session_test'] == "Session1")
  {
		echo 'session var set';
  }
  else
  {
    echo "session var not set";
  }
//}

// unset a session var
unset($_SESSION['session_test']);

// is session set
//if(isset($_SESSION['session_test']))
//{
  if($_SESSION['session_test'] == "Session1")
  {
		echo 'session var set';
  }
  else
  {
    echo "session var not set";
  }
//}


?>
