<?php
include("../connect.php");
if (isset($_POST['roleid'])){
    $rid = $_POST['roleid'];
$sql1 = "SELECT * FROM role_feature_mapping where r_id =$rid";
$sql1_result = $conn->query($sql1);
$featureList=[];
        if ($sql1_result == TRUE) {
            while ($row1 = $sql1_result->fetch_assoc()) {
                $featureList[]=$row1;
             }
            } else {
                $featureList=[];
        }
        echo json_encode($featureList);
}
?>
