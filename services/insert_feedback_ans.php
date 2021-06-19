<?php
error_reporting(0);
session_start();
// include("./services/saveUserActivity.php");
$connType="PDO";
require("../connect.php");
$quesID = $_POST['questionID'];
$_SESSION["userid"];
$answer_val = $_POST['selectedAns'];


try{
    $sql = "INSERT INTO fb_ans (`q_id`, `user_id`, `ans_value`, `ans_flag`) VALUES (?,?,?,?)";
    $stmt= $conn->prepare($sql);
    $stmt->execute([$quesID,$_SESSION["userid"],$answer_val,1]);
        echo "Inserted Question id" .$quesID." with answer value as" .$answer_val;

}
catch(Exception $e){
    echo $e->getMessage();
}


?>