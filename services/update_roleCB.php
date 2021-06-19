<?php 
//include("../connect_DB.php");
include("../connect_db_remodeled.php");

if (isset($_REQUEST['rfcb1']) && isset($_REQUEST['rfcb2']) &&  isset($_REQUEST['rfcb3']) && isset($_REQUEST['rfcb4']) && isset($_REQUEST['rfcb5'])&& isset($_REQUEST['rfcb6']) && isset($_REQUEST['rfcb7']) && isset($_REQUEST['rfcb8']) && isset($_REQUEST['rfcb9']) && isset($_REQUEST['rfcb10']) && isset($_REQUEST['rfcb11']) && isset($_REQUEST['rfcb12']) && isset($_REQUEST['rfcb13']) && isset($_REQUEST['roleid'])) {
    $rfCB[] = trim($_REQUEST['rfcb1']);
    $rfCB[] = trim($_REQUEST['rfcb2']);
    $rfCB[] = trim($_REQUEST['rfcb3']);
    $rfCB[] = trim($_REQUEST['rfcb4']);
    $rfCB[] = trim($_REQUEST['rfcb5']);
    $rfCB[] = trim($_REQUEST['rfcb6']);
    $rfCB[] = trim($_REQUEST['rfcb7']);
    $rfCB[] = trim($_REQUEST['rfcb8']);
    $rfCB[] = trim($_REQUEST['rfcb9']);
    $rfCB[] = trim($_REQUEST['rfcb10']);
    $rfCB[] = trim($_REQUEST['rfcb11']);
    $rfCB[] = trim($_REQUEST['rfcb12']);
    $rfCB[] = trim($_REQUEST['rfcb13']);
    $roleId = trim($_REQUEST['roleid']);
    
     $sql1 ="DELETE from pmp_role_feature_mapping where r_id=$roleId";
          $sql1_result = $conn->query($sql1);
        if ($sql1_result == TRUE) {
            echo "deleted";
        } else {
            echo "notAbleToDelete";
        }
     $length = count($rfCB);
     for($i=0; $i<$length; $i++)
     {
        if($rfCB[$i]!=0){
            $sql3 = "INSERT INTO `pmp_role_feature_mapping` (`rf_id`,`r_id`, `fid`) VALUES (NULL, '$roleId ', '$rfCB[$i]')";
            $sql3_result = $conn->query($sql3);
            if ($sql3_result == TRUE) {
                 echo "mapped";
            } else {
                echo "mappingError";
            }

        }
     }
    }
