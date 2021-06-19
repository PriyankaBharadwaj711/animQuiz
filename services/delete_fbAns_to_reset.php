<?php
error_reporting(0);
session_start();
$connType="PDO";
require("../connect.php");
try{
    //echo "test";
    $resetID = $_POST['idtoReset']; 
    $sql = "DELETE FROM fb_ans WHERE user_id = ?";
    $stmt= $conn->prepare($sql);
    $stmt->execute([$resetID]);  
     if ($stmt){
        $sql1 = "UPDATE users SET quiz_status = 0,feedback ='' WHERE id = ?";
        $stmt1= $conn->prepare($sql1);
        // $stmt1->execute([$_SESSION["userid"]]);
        $stmt1->execute([$resetID]);
        if($stmt->rowCount() > 0){
            echo "true";
        }
     }
}
catch(Exception $e){
    echo $e->getMessage();
}
?>