<?php
// $servername = "localhost";
// $username = "root";
// $password = "12345678";
// $dbname = "animationDemo";


  // Dev
$servername = "agitechsample.clbifhef4gsa.us-east-2.rds.amazonaws.com";
$username = "handson";
$password = "handsonhandson";
$dbname = "Animation_Quiz";

// PROD
// $servername = "handson-mysql";
// 	$username = "kumar";
// 	$password = "kumar";
// 	$dbname = "animationDemo";

if(isset($connType) && $connType=="PDO"){
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $conn->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, false);
  $conn->setAttribute(PDO::ATTR_PERSISTENT, true);
  $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
}else{
  	//Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	//Check connection
	if ($conn->connect_error) {
    	die("Hi there is some problem in Connection for Please contact Technical Team: " . $conn->connect_error);
	}
}
?>