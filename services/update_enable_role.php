
<?php 
//include("../connect_DB.php");

include("../connect_db_remodeled.php");
if (isset($_POST['role_ID'])) {
    $r_ID=$_POST['role_ID'];
    //echo "fff";
     $sql="UPDATE pmp_role SET role_status = '1' WHERE role_id= $r_ID";
 echo $sql;        
 $sql_result = $conn->query($sql);
if ($sql_result == TRUE)
    {
    echo 'enabledRole';
}
    else{
    echo 'Problem in Query Syntax';
    }
}
else{
    echo "Something wrong with the data from js file";
}
?> 