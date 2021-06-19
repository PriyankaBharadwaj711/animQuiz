<?php 
//include("../connect_DB.php");
include("../connect_db_remodeled.php");
if (isset($_POST['pmp_u_id'])) {
    $pmp_userID=$_POST['pmp_u_id'];
     $sql="UPDATE pmp_users SET invite_status = 'rejected' WHERE pmp_id= $pmp_userID";
// echo $sql;

$sql_result = $conn->query($sql);
if ($sql_result == TRUE)
    {
// echo 'The '.$pmp_userID.' has been Rejected. ';
echo 'rejected';   
}
    else{
echo 'Problem in Query Syntax';
    }
}
else{
    echo "Something wrong with the data from js file for reject user";
}

?>