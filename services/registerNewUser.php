<?php
error_reporting(0);

$connType="PDO";
 require("../connect.php");


class User{
    
    public function registerUser($conn,$request){
        try{
            $sql = "INSERT INTO users (`fname`,`lname`, `password`,`username`,`phnum`, `email`, `age`, `gender`, `org`,`addr1`, `addr2`, `city`, `state`, `zip`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt= $conn->prepare($sql);
            $stmt->execute([$request['fname'],$request['lname'],$request['password'],$request['username'],$request['phnum'],$request['email'],$request['age'],$request['gridRadios'],$request['org'],$request['addr1'],$request['addr2'],$request['city'],$request['state'],$request['zipcode']]);
            if($stmt){
            //   echo '<script>alert("Successfully Registered");</script>';
              header('Location: ../index.php');
              die();

            } else {
                echo '<script>alert("insert failed");</script>';
            }
            $id = $conn->lastInsertId();
        }
        catch(Exception $e){
            //http_response_code(500);
            // var_dump($e);
            if($e->errorInfo[0]=="23000" && $e->errorInfo[2]=="Duplicate entry '' for key 'username'"){
                echo '<script> alert("username duplicated");</script>';
                header ('Location: ../registration.php');
                die();
            }else{
                //echo json_encode(new HttpException("500",$e->getMessage()));
                echo $e->getMessage();

            }
        }  
    }
}
$user=new User();
if($_SERVER["REQUEST_METHOD"]=="POST"){
    // $user->registerUser($conn,$_POST);

}


?>