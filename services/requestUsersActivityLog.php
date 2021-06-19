<?php
                    $connType="PDO";
                    require("../connect.php");
                    $sql = "SELECT uah.*,u.email,u.phnum,u.fname,u.id,r.r_name FROM `user_activity_history` uah left join users u on uah.user_id=u.id left join pmp_user_role_mapping rm on rm.user_id=u.id left join pmp_role r on r.role_id=rm.role_id";

                    //SELECT uah.*,u.email,r.r_name FROM `user_activity_history` uah left join users u on uah.user_id=u.id left join pmp_user_role_mapping rm on rm.user_id=u.id left join pmp_role r on r.role_id=rm.role_id
                    //echo $sql;

                        $stmt= $conn->prepare($sql);
                        $result=$stmt->execute([]);
                        if($result){
                           echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
                          //while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                           //echo json_encode($row);  
                          //  echo "tr id='" . $row["id"] . "'> td>". $row["user_id"] ."</td><td>". $row["type"] ."</td><td>". $row["description"] ."</td><td>". $row["creation_date"] ."</td></tr>";
//                           }
                        }
                        
                        else{
                          echo $e->getMessage();
                        }
                    ?>