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
                                <tr style="background-color: #4CAF50; color: white; font-weight: bold;"><th colspan="3">Demographic Form Submission Data</th></tr>
                                <!-- <tbody id="pullquizans"> -->
                                    <?php 
                                    $uid = $_POST["userid"];
                                    $sql = "SELECT username, fname, parentName,phnum,email,relationship,child,age,gender,race,grade,lunchStatus,zip,pastmeals,homeless,payUtility,notWorking,childknows,findResources,anything,signature,signDate,clinicName FROM `users` WHERE id = ?";
                                    $stmt= $conn->prepare($sql);
                                    $stmt->execute([$uid]);
                                    $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
                                    if($result){
                                        foreach($result as $row){
                                        echo '<tr><th colspan="2">Child Name</th><td>'.$row["fname"].'</td></tr>';
                                        if($row["parentName"] == ""){
                                            echo '<tr><th colspan="2">Parent Name</th><td>'.'Not Applicable'.'</td></tr>';
                                        }else{
                                            echo '<tr><th colspan="2">Parent Name</th><td>'.$row["parentName"].'</td></tr>';
                                        }
                                        if($row["phnum"] == 0){
                                            echo '<tr><th colspan="2">Phone Number</th><td>'.'Not Applicable'.'</td></tr>';
                                        }else{
                                            echo '<tr><th colspan="2">Phone Number</th><td>'.$row["phnum"].'</td></tr>';
                                        }
                                        echo '<tr><th colspan="2">Email</th><td>'.$row["email"].'</td></tr>';
                                        echo '<tr><th colspan="2">Age</th><td>'.$row["age"].'</td></tr>';
                                        echo '<tr><th colspan="2">Relationship to child:</th><td>'.$row["relationship"].'</td></tr>';
                                        echo '<tr><th colspan="2">Does your child have any of the following? (Check all that apply)</th><td>'.$row["child"].'</td></tr>';
                                        echo '<tr><th colspan="2">Gender</th><td>'.$row["gender"].'</td></tr>';
                                        if($row["race"] == ""){
                                            echo '<tr><th colspan="2">Race</th><td>'.'Not Applicable'.'</td></tr>';
                                        }else{
                                            echo '<tr><th colspan="2">Race</th><td>'.$row["race"].'</td></tr>';
                                        }
                                        if($row["grade"] == ""){
                                            echo '<tr><th colspan="2">Child\'s Grade</th><td>'.'Not Applicable'.'</td></tr>';
                                        }else{
                                            echo '<tr><th colspan="2">Child\'s Grade</th><td>'.$row["grade"].'</td></tr>';
                                        }
                                        if($row["lunchStatus"]==""){
                                            echo '<tr><th colspan="2">Child\'s Lunch Status</th><td>Not Applicable</td></tr>';
                                        } else {
                                        echo '<tr><th colspan="2">Child\'s Lunch Status</th><td>'.$row["lunchStatus"].'</td></tr>';
                                       }
                                        if($row["zip"]==""){
                                                echo '<tr><th colspan="2">Zipcode</th><td>Not Applicable</td></tr>';
                                            } else {
                                                echo '<tr><th colspan="2">Zipcode</th><td>'.$row["zip"].'</td></tr>';
                                        }
                                        if($row["pastmeals"]==""){
                                            echo '<tr><th colspan="2">Smaller Meals</th><td>Not Applicable</td></tr>';
                                        } else {
                                            echo '<tr><th colspan="2">Smaller Meals</th><td>'.$row["pastmeals"].'</td></tr>';
                                      }
                                      if($row["homeless"]==""){
                                        echo '<tr><th colspan="2">Are you homeless or worried that you might be in the future?</th><td>Not Applicable</td></tr>';
                                        } else {
                                            echo '<tr><th colspan="2">Are you homeless or worried that you might be in the future?</th><td>'.$row["homeless"].'</td></tr>';
                                        }
                                        if($row["payUtility"]==""){
                                            echo '<tr><th colspan="2">Do you have trouble paying for your utilities (gas, electricity, phone)?</th><td>Not Applicable</td></tr>';
                                            } else {
                                                echo '<tr><th colspan="2">Do you have trouble paying for your utilities (gas, electricity, phone)?</th><td>'.$row["payUtility"].'</td></tr>';
                                        }
                                        if($row["notWorking"]==""){
                                            echo '<tr><th colspan="2">Are any appliances in your home not working?</th><td>Not Applicable</td></tr>';
                                            } else {
                                                echo '<tr><th colspan="2">Are any appliances in your home not working? </th><td>'.$row["notWorking"].'</td></tr>';
                                        }
                                        if($row["childknows"]==""){
                                            echo '<tr><th colspan="2">Do you think your child knows that you care about them?</th><td>Not Applicable</td></tr>';
                                            } else {
                                                echo '<tr><th colspan="2">Do you think your child knows that you care about them?</th><td>'.$row["childknows"].'</td></tr>';
                                        }
                                        if($row["findResources"]==""){
                                            echo '<tr><th colspan="2">If you answered "YES" to any of the above questions?</th><td>Not Applicable</td></tr>';
                                            } else {
                                                echo '<tr><th colspan="2">If you answered "YES" to any of the above questions?</th><td>'.$row["findResources"].'</td></tr>';
                                        }
                                        if($row["anything"]==""){
                                            echo '<tr><th colspan="2">Anything else you want help with?</th><td>Not Applicable</td></tr>';
                                            } else {
                                                echo '<tr><th colspan="2">Anything else you want help with?</th><td>'.$row["anything"].'</td></tr>';
                                        }
                                        if($row["signature"]==""){
                                            echo '<tr><th colspan="2">Consent Signature</th><td>Not Applicable</td></tr>';
                                            } else {
                                                echo '<tr><th colspan="2">Consent Signature</th><td>'.$row["signature"].'</td></tr>';
                                        }
                                        if($row["signDate"]==""){
                                            echo '<tr><th colspan="2">Consent Signed Date</th><td>Not Applicable</td></tr>';
                                            } else {
                                                echo '<tr><th colspan="2">Consent Signed Date</th><td>'.$row["signDate"].'</td></tr>';
                                             }
                                             if($row["clinicName"]==""){
                                                echo '<tr><th colspan="2">Clinic Name</th><td>Not Applicable</td></tr>';
                                                } else {
                                                    echo '<tr><th colspan="2">Clinic Name</th><td>'.$row["clinicName"].'</td></tr>';
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
                                    }
                                     
                                    } else {
                                    echo "<tr><td colspan='7' style='text-align:center;font-size: xx-large;' class='redColor'>No Quiz Submissions yet!!! </td></tr>";
                                    }
                                    ?>
                                    <tr colspan="20"></tr>
                                    <tr colspan="20"></tr>
                                    <tr style="background-color: #4CAF50; color: white; font-weight: bold;">
                                        <th>Question</th>
                                        <th>User Name</th>
                                        <!-- <th>Yes</th>
                                        <th>Sometimes</th>
                                        <th>No</th> -->
                                        <th>Answer(Yes/No/Sometimes)</th>
                                    </tr>
                                    <!-- <tbody id="pullquizans"> -->
                                    <?php 
                                    $uid = $_POST["userid"];
                                    $sql = "SELECT q.id,q.question_text,a.user_id,u.fname,u.lname, a.ans_value,a.timestamp FROM fb_qs as q LEFT JOIN fb_ans as a on q.id = a.q_id LEFT join users as u on a.user_id = u.id WHERE a.user_id = ?";
                                    $stmt= $conn->prepare($sql);
                                    $stmt->execute([$uid]);
                                    $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
                                    if($result){
                                        foreach($result as $row){
                                        echo '<tr>';
                                        echo '<td style="width: 400px;">'.$row["question_text"].'</td>';
                                        echo '<td>'.$row["fname"].'</td>';
                                        if($row["ans_value"]=="Yes"){
                                            echo '<td>Yes</td>';
                                        // echo '<td><label><input type="radio" disabled  name="optradio'.$row["id"].'" checked></label></td>';
                                        }
                                        //else {
                                        //     echo '<td><label><input type="radio" disabled name="optradio'.$row["id"].'"></label></td>';
                                        // }
                                        if($row["ans_value"]=="Sometimes"){
                                            echo '<td>Sometimes</td>';
                                        // echo '<td><label><input type="radio"  disabled name="optradio'.$row["id"].'" checked></label></td>';
                                        }
                                        // else {
                                        // echo '<td><label><input type="radio"  disabled name="optradio'.$row["id"].'"></label></td>';
                                        // }
                                        
                                        if($row["ans_value"]=="No"){
                                            echo '<td>No</td>';
                                        // echo '<td><label><input type="radio"  disabled name="optradio'.$row["id"].'" checked></label></td>';
                                        }
                                        // else {
                                        // echo '<td><label><input type="radio"  disabled name="optradio'.$row["id"].'"></label></td>';
                                        // }
                                        echo '</tr>';                      
                                    }
                                        echo '<div style="display:inline-flex;align-items: center;">
                                            <div>Click to listen audio recorded</div>
                                            <div> <audio controls="controls" src="./services/feedbackViewer.php?userid='.$row["user_id"].'" type="video/mp4" /> </div>
                                        </div>';
                                    } else {
                                    echo "<tr><td colspan='7' style='text-align:center;font-size: xx-large;' class='redColor'>No Quiz Submissions yet!!! </td></tr>";
                                    }
                                    ?>
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
