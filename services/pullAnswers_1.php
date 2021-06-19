<?php
session_start();
$connType = "PDO";
require("../connect.php");
?>


              <!-- Nav tabs -->
  <!-- <ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" href="#home">Demographic</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#menu1">Feedback</a>
    </li>
   
  </ul> -->

  <!-- Tab panes -->
  <div>
        <div id="home" class="container-fluid tab-pane active"><br>
            <!-- <h3>Dmographic Form Submission Data </h3> -->
            <form>
                    <div class="form-group row">
                        <div class="col-sm-12 col-md-12">
                        <table id="tbl1" class="table tabresponsive demographic">
                                <tr style="background-color: #4CAF50; color: white; font-weight: bold;"><th colspan="21">Demographic Form Submission Data</th>
                                <th colspan="3">Quiz Submission Data</th></tr>
                                <!-- <tbody id="pullquizans"> -->
                                    <?php 
                                    // $uid = $_POST["userid"];
                                    $sql = "SELECT username, fname, parentName, phnum,email,id,relationship,child,age,gender,race,grade,lunchStatus,zip,pastmeals,homeless,payUtility,notWorking,childknows,findResources,anything,signature,signDate,clinicName FROM `users`";
                                    $stmt= $conn->prepare($sql);
                                    $stmt->execute();
                                    $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
                                    if($result){
                                        echo '<tr><th>Child Name</th>';
                                        echo '<th>Parent Name</th>';
                                        echo '<th>Phone Number</th>';
                                        echo '<th>Email</th>';
                                        echo '<th>Age</th>';
                                        echo '<th>Relationship to child:</th>';
                                        echo '<th>Does your child have any of the following? (Check all that apply)</th>';
                                        echo '<th>Gender</th>';
                                        echo '<th>Race</th>';
                                        echo '<th>Child\'s Grade</th>';
                                        if($row["lunchStatus"]==""){
                                            echo '<th>Child\'s Lunch Status</th>';
                                        } else {
                                        echo '<th>Child\'s Lunch Status</th>';
                                       }
                                        if($row["zip"]==""){
                                                echo '<th>Zipcode</th>';
                                            } else {
                                                echo '<th>Zipcode</th>';
                                        }
                                        if($row["pastmeals"]==""){
                                            echo '<th>Smaller Meals</th>';
                                        } else {
                                            echo '<th>Smaller Meals</th>';
                                      }
                                      if($row["homeless"]==""){
                                        echo '<th>Are you homeless or worried that you might be in the future?</th>';
                                        } else {
                                            echo '<th>Are you homeless or worried that you might be in the future?</th>';
                                        }
                                        if($row["payUtility"]==""){
                                            echo '<th>Do you have trouble paying for your utilities (gas, electricity, phone)?</th>';
                                            } else {
                                                echo '<th>Do you have trouble paying for your utilities (gas, electricity, phone)?</th>';
                                        }
                                        if($row["notWorking"]==""){
                                            echo '<th>Are any appliances in your home not working?</th>';
                                            } else {
                                                echo '<th>Are any appliances in your home not working? </th>';
                                        }
                                        if($row["childknows"]==""){
                                            echo '<th>Do you think your child knows that you care about them?</th>';
                                            } else {
                                                echo '<th>Do you think your child knows that you care about them?</th>';
                                        }
                                        if($row["findResources"]==""){
                                            echo '<th>If you answered "YES" to any of the above questions?</th>';
                                            } else {
                                                echo '<th>If you answered "YES" to any of the above questions?</th>';
                                        }
                                        if($row["anything"]==""){
                                            echo '<th>Anything else you want help with?</th>';
                                            } else {
                                                echo '<th>Anything else you want help with?</th>';
                                        }
                                        if($row["signature"]==""){
                                            echo '<th>Consent Signature</th>';
                                            } else {
                                                echo '<th>Consent Signature</th>';
                                        }
                                        if($row["signDate"]==""){
                                            echo '<th>Consent Signed Date</th>';
                                            } else {
                                                echo '<th>Consent Signed Date</th>';
                                             }
                                             if($row["clinicName"]==""){
                                                echo '<th>Clinic Name</th>';
                                                } else {
                                                    echo '<th>Clinic Name</th>';
                                                }
                                        // echo '<tr><th colspan="2">Smaller Meals</th><td>'.$row["pastmeals"].'</td></tr>';
                                        // echo '<tr><th colspan="2">Homeless or worrid in future?</th><td>'.$row["homeless"].'</td></tr>';
                                        // echo '<tr><th colspan="2">Trouble Paying Utility Bills ?</th><td>'.$row["payUtility"].'</td></tr>';
                                        // echo '<tr><th colspan="2">Are any appliances in your home not working </th><td>'.$row["notWorking"].'</td></tr>';
                                        // echo '<tr><th colspan="2">Child knows you care them ?</th><td>'.$row["childknows"].'</td></tr>';
                                        // echo '<tr><th colspan="2">If you answered "YES" to any of the above questions?</th><td>'.$row["findResources"].'</td></tr>';
                                        // echo '<tr><th colspan="2">Anything else you want help with?</th><td>'.$row["anything"].'</td></tr>';
                                        // echo '<tr><th colspan="2">Consent Signature</th><td>'.$row["signature"].'</td></tr>';
                                        // echo '<tr><th colspan="2">Consent Signed Date</th><td>'.$row["signDate"].'</td></tr>';
                                        // echo '<tr><th colspan="2">Clinic Name</th><td>'.$row["clinicName"].'</td></tr>';
                                        // echo '</tr>'; 
                                    // echo'<th></th>';
                                    $sql1 = "SELECT * FROM fb_qs;";
                                    $stmt1= $conn->prepare($sql1);
                                    $stmt1->execute();
                                    $result1=$stmt1->fetchAll(PDO::FETCH_ASSOC);
                                    $ids = array();
                                        if($result1){
                                        // echo json_encode($result1);
                                            foreach($result1 as $row1){
                                                array_push($ids,$row1["id"]);
                                                echo'<th>'.$row1["question_text"].'</th>';
                                            }
                                            // echo json_encode($ids);

                                        }
                                        $a = 1;
                                            foreach($result as $row){
                                                $user_id = $row['id'];
                                                $sql2 = "SELECT * FROM fb_ans WHERE user_id = '$user_id' ;";
                                                $stmt2= $conn->prepare($sql2);
                                                $stmt2->execute();
                                                $result2=$stmt2->fetchAll(PDO::FETCH_ASSOC);
                                            // $sql2 = "SELECT * FROM fb_ans WHERE user_id = ".$row['id'].";";
                                            // $stmt2= $conn->prepare($sql2);
                                            // $stmt1->execute();
                                            // $result2=$stmt1->fetchAll(PDO::FETCH_ASSOC);
                                            // echo'<tr>';
                                            // if($result2){
                                            // // echo json_encode($result1);
                                            //     foreach($result2 as $row2){
                                            //     echo'<td>'.$row2["ans_value"].'</td>';
                                            //     }
                                            // }
                                            // echo'</tr>';
                                    //     }
                                        
                                        echo '<tr><td>'.$row["fname"].'</td>';
                                        if($row["parentName"]==""){
                                            echo '<td>Not Applicable</td>';
                                        } else {
                                        echo '<td>'.$row["parentName"].'</td>';
                                        }
                                        if($row["phnum"]== 0){
                                            echo '<td>Not Applicable</td>';
                                        } else {
                                        echo '<td>'.$row["phnum"].'</td>';
                                        }
                                        echo '<td>'.$row["email"].'</td>';
                                        echo '<td>'.$row["age"].'</td>';
                                        if($row["relationship"]==""){
                                            echo '<td>Not Applicable</td>';
                                        } else {
                                            echo '<td>'.$row["relationship"].'</td>';
                                        }
                                        if($row["child"]==""){
                                            echo '<td>Not Applicable</td>';
                                        } else {
                                            echo '<td>'.$row["child"].'</td>';
                                        }
                                        echo '<td>'.$row["gender"].'</td>';
                                        if($row["race"]==""){
                                            echo '<td>Not Applicable</td>';
                                        } else {
                                        echo '<td>'.$row["race"].'</td>';
                                        }
                                        if($row["grade"]==""){
                                            echo '<td>Not Applicable</td>';
                                        } else {
                                        echo '<td>'.$row["grade"].'</td>';
                                        }
                                        if($row["lunchStatus"]==""){
                                            echo '<td>Not Applicable</td>';
                                        } else {
                                        echo '<td>'.$row["lunchStatus"].'</td>';
                                        }
                                        if($row["zip"]==""){
                                                echo '<td>Not Applicable</td>';
                                            } else {
                                                echo '<td>'.$row["zip"].'</td>';
                                        }
                                        if($row["pastmeals"]==""){
                                            echo '<td>Not Applicable</td>';
                                        } else {
                                            echo '<td>'.$row["pastmeals"].'</td>';
                                      }
                                      if($row["homeless"]==""){
                                        echo '<td>Not Applicable</td>';
                                        } else {
                                            echo '<td>'.$row["homeless"].'</td>';
                                        }
                                        if($row["payUtility"]==""){
                                            echo '<td>Not Applicable</td>';
                                            } else {
                                                echo '<td>'.$row["payUtility"].'</td>';
                                        }
                                        if($row["notWorking"]==""){
                                            echo '<td>Not Applicable</td>';
                                            } else {
                                                echo '<td>'.$row["notWorking"].'</td>';
                                        }
                                        if($row["childknows"]==""){
                                            echo '<td>Not Applicable</td>';
                                            } else {
                                                echo '<td>'.$row["childknows"].'</td>';
                                        }
                                        if($row["findResources"]==""){
                                            echo '<td>Not Applicable</td>';
                                            } else {
                                                echo '<td>'.$row["findResources"].'</td>';
                                        }
                                        if($row["anything"]==""){
                                            echo '<td>Not Applicable</td>';
                                            } else {
                                                echo '<td>'.$row["anything"].'</td>';
                                        }
                                        if($row["signature"]==""){
                                            echo '<td>Not Applicable</td>';
                                            } else {
                                                echo '<td>'.$row["signature"].'</td>';
                                        }
                                        if($row["signDate"]==""){
                                            echo '<td>Not Applicable</td>';
                                            } else {
                                                echo '<td>'.$row["signDate"].'</td>';
                                             }
                                             if($row["clinicName"]==""){
                                                echo '<td>Not Applicable</td>';
                                                } else {
                                                    echo '<td>'.$row["clinicName"].'</td>';
                                                }
                                        // echo '<tr><th colspan="2">Smaller Meals</th><td>'.$row["pastmeals"].'</td></tr>';
                                        // echo '<tr><th colspan="2">Homeless or worrid in future?</th><td>'.$row["homeless"].'</td></tr>';
                                        // echo '<tr><th colspan="2">Trouble Paying Utility Bills ?</th><td>'.$row["payUtility"].'</td></tr>';
                                        // echo '<tr><th colspan="2">Are any appliances in your home not working </th><td>'.$row["notWorking"].'</td></tr>';
                                        // echo '<tr><th colspan="2">Child knows you care them ?</th><td>'.$row["childknows"].'</td></tr>';
                                        // echo '<tr><th colspan="2">If you answered "YES" to any of the above questions?</th><td>'.$row["findResources"].'</td></tr>';
                                        // echo '<tr><th colspan="2">Anything else you want help with?</th><td>'.$row["anything"].'</td></tr>';
                                        // echo '<tr><th colspan="2">Consent Signature</th><td>'.$row["signature"].'</td></tr>';
                                        // echo '<tr><th colspan="2">Consent Signed Date</th><td>'.$row["signDate"].'</td></tr>';
                                        // echo '<tr><th colspan="2">Clinic Name</th><td>'.$row["clinicName"].'</td></tr>';
                                        // echo '</tr>';
                                                
                                                
                                                foreach($ids as $id){
                                                    $a = 1;
                                                    foreach($result2 as $row2 ){
                                                        if($row2['q_id'] == $id){
                                                            echo'<td>'.$row2["ans_value"].'</td>';
                                                            $a = 2;
                                                            break;
                                                        }
                                                    }
                                                    if($a == 1){
                                                        echo'<td>'.'NA'.'</td>';
                                                    }

                                                }
                     
                                            }
                                    } 
                                    
                                    ?>
                                    <!-- <tbody id="pullquizans"> -->
                                    
                                <!-- </tbody> -->
                            </table>
                            <input id="resetID" value=<?php echo $uid; ?> type="hidden" />
                        </div>
                    </div>
                    <div style="text-align: center;padding-bottom: 30px;">
                        <!-- <button id="resetQuizAnswers" onclick="resetQuiz()" type="button" class="btn btn-success" type="button"> RESET
                            QUIZ </button> -->
                    </div>
                </form>
        </div>
        
  </div>
 