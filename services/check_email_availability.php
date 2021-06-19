<?php
//include("../connect_DB.php");
include("../connect_db_remodeled.php");
 $CGemail = $_POST['CGemail'];
// $CGemail = 'anusha.m21@gmail.com';
 
echo $CGemail;
 
$sql1 = "SELECT email FROM pmp_users where email = '$CGemail'";
$sql_result1 = $conn->query($sql1);
if ($sql_result1 == TRUE && $sql_result1->num_rows > 0) {
    echo "failure";
} else {
    echo "success";
}
