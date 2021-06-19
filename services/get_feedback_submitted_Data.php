<?php
$connType="PDO";
require("../connect.php");

try{
    //echo "test";
    $sql = "SELECT id,fname,email ,fb_submission_time from users where quiz_status = 1 ";
    $stmt= $conn->prepare($sql);
    $res= $stmt->execute([]);  
     if ($res){
         while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // var_dump ($row);  
         echo "<tr id='" . $row["id"] . "'> <td>". $row["id"] ."</td><td>". $row["fname"] ."</td><td>". $row["email"] ."</td><td>". $row["fb_submission_time"] ."</td></tr>";
        }
     }
}
catch(Exception $e){
    echo $e->getMessage();
}
?>