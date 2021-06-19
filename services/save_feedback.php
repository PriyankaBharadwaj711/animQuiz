<?php
error_reporting(0);
session_start();
$connType="PDO";
require("../connect.php");

var_dump($_FILES["audio"]["tmp_name"]);
var_dump($_FILES);

try{
    $sql = "update users set feedback=? where id =?";
    $stmt= $conn->prepare($sql);
    $data= file_get_contents($_FILES['audio']["tmp_name"]);
    var_dump($data);
    $stmt->execute([$data,$_SESSION["userid"]]);
    echo "success ";
}
catch(Exception $e){
    echo $e->getMessage();
}
?>