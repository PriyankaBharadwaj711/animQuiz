<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require("../connect.php");
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["studentName"];
  $parentName =$_POST["parentName"];
  $email = $_POST["email"];
  $relationship = $_POST["relationship"];
  $order=implode(',',$_POST['order']);
  $transportation=$_POST["transportation"];
  $gender = $_POST["genderDemographic"];
    if($gender =="other"){
      if($_POST["other_reason"]){
      $gender= $_POST["other_reason"];
    }
    }
  $race = $_POST["race"];
  $age = $_POST["age"];
  $grade = $_POST["gradeLevel"];
  $childLunch = $_POST["childLunch"];
  $zipcode = $_POST["zipcode"];
  $pastmeals = $_POST["pastmeals"];
  $homeless = $_POST["homeless"];
  $payUtil = $_POST["payUtil"];
  $notWorking = $_POST["appliances"];
  $childKnows =  $_POST["childCare"];
  $clinicName = $_POST['clinicName'];
  $anything = $_POST["anythingElse"];
  $signame = $_POST["signame"];  
  // $signDate = $_POST["signDate"];  
  $findResources = $_POST["findResources"];
  $lname = "Not Applicable";
  $role_id = 2;
  print_r($_POST);
  
  try {
    $findemailsql = "SELECT * FROM users where email = '" . $email . "'";
    $findemailsql_sql_result = $conn->query($findemailsql);
    $row_cnt = 0;
    if ($findemailsql_sql_result) {
      /* determine number of rows result set */
      $row_cnt = mysqli_num_rows($findemailsql_sql_result);
      if ($row_cnt > 0) {
        while ($row = $findemailsql_sql_result->fetch_assoc()) {
          $user = $row;
          $registered  = $row['isFake'];
          // echo $registered;
        }
        //student registration
        if($registered == 1){
          $registered = 1;
          $sql2 = "INSERT INTO  users (`fname`,`lname`,`parentName`, `password`,`username`,`phnum`, `email`, `relationship`, `child`, `transportation`, `age`, `gender`, `race`,`grade`, `lunchStatus`, `zip`,`pastmeals`,`homeless`,`signature`,`payUtility`,`notWorking`,`childKnows`,`clinicName`,`anything`, `findResources`,`isFake`,`signDate`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,CURRENT_TIMESTAMP)";
          
          $stmt = $conn->prepare($sql2);
          $phoneNum = '0';
          $stmt->bind_param("sssssissssissssissssssssss",$name,$lname,$parentName,$name,$name,$phoneNum,$email,$relationship,$order,$transportation,$age,$gender,$race,$grade,$childLunch,$zipcode,$pastmeals,$homeless,$signame,$payUtil,$notWorking,$childKnows,$clinicName,$anything,$findResources,$registered);
          // var_dump($sql2);
          $isSuccessful = $stmt->execute();
          if ($isSuccessful == TRUE) {
            
            $user_id = $conn->insert_id;
            $sql_3 = " INSERT INTO `pmp_user_role_mapping` (user_id,role_id) VALUES ('$user_id','$role_id')";
            $sql_result_3 = $conn->query($sql_3);
            try {
              if ($sql_result_3) {
                $_SESSION["loggedin"] = true;
                $_SESSION["userid"] = $user_id;
                $_SESSION["username"] = $name;
                $_SESSION["firstname1"] = $name;
                $_SESSION["lastname2"] = $name;
                $_SESSION["parentName"] =$parentName;
                $_SESSION["rname"] = "Student";
                $_SESSION["quizStatus"] = 0;
                header('Location: ../home.php?version=' . $_POST["version"]);
              } else {
                header('Location: ../home.php?version=' . $_POST["version"]);
              }
            } catch (Exception $e) {
              echo $e->errorMessage();
            } //try catch ends for sqll_result3
          }
      }
      //student registration
      else if($registered == 0){
        // echo "The email is available";
        $registered = 1;
        $sql2 = "INSERT INTO  users (`fname`,`lname`,`parentName`, `password`,`username`,`phnum`, `email`, `relationship`, `child`, `transportation`, `age`, `gender`, `race`,`grade`, `lunchStatus`, `zip`,`pastmeals`,`homeless`,`signature`,`payUtility`,`notWorking`,`childKnows`,`clinicName`,`anything`, `findResources`,`isFake`,`signDate`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,CURRENT_TIMESTAMP)";
          
        $stmt = $conn->prepare($sql2);
        $phoneNum = '0';
        $stmt->bind_param("sssssissssissssissssssssss",$name,$lname,$parentName,$name,$name,$phoneNum,$email,$relationship,$order,$transportation,$age,$gender,$race,$grade,$childLunch,$zipcode,$pastmeals,$homeless,$signame,$payUtil,$notWorking,$childKnows,$clinicName,$anything,$findResources,$registered);
        // var_dump($sql2);
        $isSuccessful = $stmt->execute();
        if ($isSuccessful == TRUE) {

          $user_id = $conn->insert_id;
          $sql_3 = " INSERT INTO `pmp_user_role_mapping` (user_id,role_id) VALUES ('$user_id','$role_id')";
          $sql_result_3 = $conn->query($sql_3);
          try {
            if ($sql_result_3) {
              $_SESSION["loggedin"] = true;
              $_SESSION["userid"] = $user_id;
              $_SESSION["username"] = $name;
              $_SESSION["firstname1"] = $name;
              $_SESSION["lastname2"] = $name;
              $_SESSION["parentName"] =$parentName;
              $_SESSION["rname"] = "Student";
              $_SESSION["quizStatus"] = 0;
              header('Location: ../home.php?version=' . $_POST["version"]);
            } else {
              header('Location: ../home.php?version=' . $_POST["version"]);
            }
          } catch (Exception $e) {
            echo $e->errorMessage();
          } //try catch ends for sqll_result3
        }
      }
      }
      //student update
    else{
        $registered = 1;
        $sql2 = "INSERT INTO  users (`fname`,`lname`,`parentName`, `password`,`username`,`phnum`, `email`, `relationship`, `child`, `transportation`, `age`, `gender`, `race`,`grade`, `lunchStatus`, `zip`,`pastmeals`,`homeless`,`signature`,`payUtility`,`notWorking`,`childKnows`,`clinicName`,`anything`, `findResources`,`isFake`,`signDate`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,CURRENT_TIMESTAMP)";
          
          $stmt = $conn->prepare($sql2);
          $phoneNum = '0';
          $stmt->bind_param("sssssissssissssissssssssss",$name,$lname,$parentName,$name,$name,$phoneNum,$email,$relationship,$order,$transportation,$age,$gender,$race,$grade,$childLunch,$zipcode,$pastmeals,$homeless,$signame,$payUtil,$notWorking,$childKnows,$clinicName,$anything,$findResources,$registered);
          // var_dump($sql2);
          $isSuccessful = $stmt->execute();
        if ($isSuccessful == TRUE) {

          $user_id = $conn->insert_id;
          $sql3 = " INSERT INTO `pmp_user_role_mapping` (user_id,role_id) VALUES ('$user_id','$role_id')";
          $sql_result3 = $conn->query($sql3);
          try {
            if ($sql_result3) {
              $_SESSION["loggedin"] = true;
              $_SESSION["userid"] = $user_id;
              $_SESSION["username"] = $name;
              $_SESSION["firstname1"] = $name;
              $_SESSION["lastname2"] = $name;
              $_SESSION["parentName"] =$parentName;
              $_SESSION["rname"] = "Student";
              $_SESSION["quizStatus"] = 0;
              header('Location: ../home.php?version=' . $_POST["version"]);
            } else {
              header('Location: ../home.php?version=' . $_POST["version"]);
            }
          } catch (Exception $e) {
            echo $e->errorMessage();
          } //try catch ends for sqll_result3
        }
    }
    }
  } //end of try
  catch (Exception $e) {
    echo $e->errorMessage();
  }
}
