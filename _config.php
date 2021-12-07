<?php
session_start();

// report all errors except output flagged with E_NOTICE
error_reporting(E_ALL & ~E_NOTICE);

// this will directly affect the PHP config file: allow to display errors directly on-page
ini_set('display_errors', 1);

$conf['db']                 = array();
$conf['db']['host']         = "localhost";
$conf['db']['db']           = "project-wul";
$conf['db']['user']         = "root";
$conf['db']['password']     = "";
$conf['db']['conn']         = new mysqli($conf['db']['host'],$conf['db']['user'],$conf['db']['password'],$conf['db']['db']);
                              mysqli_query($conf['db']['conn'], "SET NAMES 'utf-8'");
$conf['db']['sql_con']      = mysqli_connect($conf['db']['host'],$conf['db']['user'],$conf['db']['password'],$conf['db']['db']);

$conf['paths']              = array();
$conf['paths']['functions'] = "_functions.php";
$conf['paths']['images']    = "images/";

$conf['vars']               = array();
$conf['vars']['prefix']     = "";
$conf['vars']['mailto']     = "";

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
//if($conf['db']['conn'] === false){
    //die("ERROR: Could not connect. " . mysqli_connect_error());

?>