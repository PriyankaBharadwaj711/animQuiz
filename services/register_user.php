<?php
// error_reporting(0);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// $connType="PDO";
require("../connect.php");
include("../php/class.phpmailer.php");

if (isset($_POST['fname']) && isset($_POST['lname'])&& isset($_POST['username']) &&  isset($_POST['password']) && isset($_POST['email']) && isset($_POST['roleSelect']) && isset($_POST['phnum']) && isset($_POST['gridRadios']) && isset($_POST['zipcode']) ){
	
				$first_name=$_POST['fname'];
				$last_name=$_POST['lname'];
				$pwd=password_hash($_POST['password'], PASSWORD_DEFAULT);
				$user_name=$_POST['username'];
				$useremail = $_POST['email'];
				$phnum = $_POST['phnum'];
				$age = $_POST['age'];
				$role_id = $_POST['roleSelect'];
				$gridRadio = $_POST['gridRadios'];
				
				// $org = $_POST['org'];
				// $addr1 = $_POST['addr1'];
				// $addr2 = $_POST['addr2'];
				// $city = $_POST['city'];
				// $state = $_POST['state'];
				$zipcode = $_POST['zipcode'];
				$clinic_Name  = $_POST['clinicName'];
				$registration_status = "registered";
				$first_name = $first_name." ".$last_name;
				$last_name = "Not Applicable";
				$parent_name = "Not Applicable";
				$phnum = "Not Applicable";
	// echo $clinic_Name;
	
		try{
			// echo "testting";
			$sql = "SELECT * FROM users WHERE email = '$useremail';";
			$result = $conn->query($sql);
			if($result->num_rows>0){
    			while($row = $result->fetch_assoc()){
        			$registered = $row['isFake'];
					}
					//admin update
					if($registered == 0){
						$sql_1 = "UPDATE users SET username = '$user_name', fname = '$first_name', lname = '$last_name', password = '$pwd', phnum = '$phnum', age = '$age', gender = '$gridRadio', zip = '$zipcode', clinicName = '$clinic_Name', isFake = '$registered' WHERE email = '$useremail';";
						$result_1 = $conn->query($sql_1);
						header('Location: ../index.php?regstat=registered');
					}
					//student registration
					else if($registered == 1){
						$registered = 0;
						$sql2 = "INSERT INTO  users (`fname`,`lname`,`parentName`, `password`,`username`,`phnum`, `email`, `age`, `gender`, `zip`, `clinicName`,`registration_status`, `isFake`) VALUES ('$first_name','$last_name','$parent_name','$pwd','$user_name', '$phnum' ,'$useremail',$age,'$gridRadio',$zipcode,'$clinic_Name','$registration_status','$registered')";
						$sql_result2 = $conn->query($sql2);
						header('Location: ../index.php?regstat=registered');
					}
			
				}
				//admin registration	
			else{	
				$registered = 0;	
				$sql2 = "INSERT INTO  users (`fname`,`lname`,`parentName`, `password`,`username`,`phnum`, `email`, `age`, `gender`, `zip`, `clinicName`,`registration_status`,`isFake`) VALUES ('$first_name','$last_name','$parent_name','$pwd','$user_name', '$phnum' ,'$useremail',$age,'$gridRadio',$zipcode,'$clinic_Name','$registration_status', '$registered')";
				
				$sql_result2 = $conn->query($sql2);
					if ($sql_result2 == TRUE)
					{
						$user_id = $conn->insert_id;
						$sql3 = " INSERT INTO `pmp_user_role_mapping` (user_id,role_id,user_role_status) VALUES ('$user_id','$role_id',1)";
						$sql_result3 = $conn->query($sql3);
						try {
							if ($sql_result3 == TRUE) 
							{
							header('Location: ../index.php?regstat=registered');	
							}
						}catch (Exception $e) {
							echo $e->errorMessage();
						}//try catch ends for sqll_result3

						}else{
					header('Location: ../registration.php?regstat=failed');
							
						}
					}
				}//end of try
			catch (Exception $e) {
				echo $e->errorMessage();
			}
     }
?>