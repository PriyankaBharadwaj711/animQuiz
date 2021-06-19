<?php
error_reporting(0);
session_start();
// include("./services/saveUserActivity.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$connType="PDO";
require("./connect.php");

  if (isset($_SESSION["pmp_id"])) {
    header("Location:./home.php");
  }
  //Check if username is empty
   if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if (empty(trim($_POST["username"]))) {
          $username_err = "Please enter username.";
          echo '<script>alert("Please enter Username");</script>';
          vardump( $_POST["password"]);
          die();
          } else if (empty(trim($_POST["password"]))) {
            $password_err = "Please enter your password.";
            echo '<script>alert("Please enter Password");</script';
          } else {
            $username = trim($_POST["username"]);
            $password = trim($_POST["password"]);
        }

        // Validate credentials
  if (empty($username_err) && empty($password_err)) {
    // Prepare a select statement 
    //for now  
    $sql = "SELECT u.id,u.fname,u.lname,u.username as username, u.password as password,u.email,ur.role_id,r.r_name,r.role_status as roleStatus FROM users u LEFT join pmp_user_role_mapping ur on u.id = ur.user_id left join pmp_role r on ur.role_id = r.role_id WHERE u.username = ?";

    //pass values to ? in sql statement to execute method
        try{
          $stmt= $conn->prepare($sql);
          
          $stmt->execute([$username]);
          //fetch the result row and put it in $result
          $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(Exception $e){
          echo $e->getMessage();
        }
        

    if ($result) {
      if ($stmt->rowCount() >= 1) {
        foreach ($result as $row) {
          // Password is correct, so start a new session
          $hashedPwd = $row["password"];
          if (password_verify($password, $hashedPwd)) {
            // Store data in session variables
            $_SESSION["loggedin"] = true;
            $_SESSION["userid"] = $row["id"];
            $_SESSION["username"] = $username;
            $_SESSION["firstname1"] = $row["fname"];
            $_SESSION["lastname2"] = $row["lname"];
            $_SESSION["rname"] = $row["r_name"];
            $_SESSION["clinicName"] = $row["clinicName"];

            $sq1_1 = "SELECT clinicName FROM users WHERE id =?;";
            $stmt_1= $conn->prepare($sql_1);
          
            $stmt_1->execute($_SESSION["userid"]);
          //fetch the result row and put it in $result
            $_SESSION['clinicName'] = $row['clinicName'];



            try{
              $_SESSION["roleId"] = $row["role_id"];
              $sql1 = "SELECT * FROM pmp_role_feature_mapping where r_id=?";

              $stmt1= $conn->prepare($sql1);
          
              $stmt1->execute([$_SESSION["roleId"]]);
              //fetch the result row and put it in $result
              $result1=$stmt1->fetchAll(PDO::FETCH_ASSOC);
              foreach ($result1 as $row1) {
                $_SESSION["f" . $row1["fid"]] = true;
              }

              // $sql1_result = $conn->query($sql1);
              // if ($sql1_result == TRUE) {
              //   while ($row1 = $sql1_result->fetch_assoc()) {
              //     $_SESSION["f" . $row1["fid"]] = true;
              //   }
              // }
              //$useractivity->saveHistory($conn, "LOGIN", "Just logged in");
  
            }
            catch(Exception $e){
              echo $e->getMessage();
            }
            

            header("Location: ./home.php");
            die('Should have redirected by now');
          } else {
            echo "<script>alert('Invalid username or password.Try again');</script>";
            //header("Location: ./pmpDisabledRole.php");
          }
        }
      } else {
        // echo "no rows";
        echo "<script>alert('Cannot Login!!Username doesnot exist in Database');</script>";
      }
    }else{
      echo "<script>alert('Username doesnot exist in Database');</script>";
    }
      
  }
}
    
?>