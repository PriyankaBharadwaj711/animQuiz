<?php
// $servername = "mariadb";
// $username = "root";
// $password = "tiger";
// $dbname = "animationDemo";

// Dev
	$servername = "handson-mysql";
	$username = "kumar";
	$password = "kumar";
	$dbname = "animationDemo_dev";

// 	//PROD
// 	$servername = "handson-mysql";
// 		$username = "kumar";
// 		$password = "kumar";
// 		$dbname = "animationDemo";

	//Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	//Check connection
	if ($conn->connect_error) {
    	die("Hi there is some problem in Connection for Please contact Technical Team: " . $conn->connect_error);
	} 
?>