<?php

//PDO
error_reporting(0);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
session_start();
//echo "hgashdgas" .$_SESSION['version'];
$connType = "PDO";
$version = $_REQUEST["version"];
include("./php/class.phpmailer.php");
// echo  "<script>var versionSent = ".$version;
// echo "</script>";
require("./connect.php");
include("./services/saveUserActivityPdo.php");
// REQUEST_URI will check only if the page is called for the first time or if its refreshed
$RequestSignature = md5($_SERVER['REQUEST_URI'].$_SERVER['QUERY_STRING'].print_r($_POST, true));
if (($_SESSION['LastRequest'] == $RequestSignature) ||( $_GET["qs"] == 1))
{
    
  // echo 'This is a refresh.';
}
else
{
  // echo 'This will go when demographic is submitted from index.php to home.php.';
//   Here $RequestSignature will be 1
  $_SESSION['LastRequest'] = $RequestSignature;
  include('email_submission.php');
}
$useractivity = new ActivityHistory();
$useractivity->saveHistory($conn, "Home", "Opened Home Page with Quiz vedio1");
session_start();
if (!$_SESSION["loggedin"]) {
  header("Location:./index.php");
}
// sent from animate.js
//checks if url has qs ==1 from get
//and then uopdates the table with column quiz_status = 1
if ($_GET["qs"] == 1) {
  //update db value 
  $sql = "update users set quiz_status=1,fb_submission_time=CURRENT_TIMESTAMP where id=?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$_SESSION["userid"]]);
  $_SESSION["quizStatus"] = 1;
  
    
}
include('email_response.php');
$qsval = $_SESSION["quizStatus"];

// var_dump($_SESSION);
?>
<!doctype html>
<html lang="en">

<head>
    <link rel="icon" type="image/png" href="./resources/favicon.jpeg">
    <title>Animation Demo</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css">
    <!-- Talker Function play resume pause starts-->
    <script src="https://code.responsivevoice.org/responsivevoice.js"></script>
    <script src='//vws.responsivevoice.com/v/e?key=gnQGExNu'></script>
    <link rel="stylesheet"
        href="https://unpkg.com/material-components-web@v5.0.0/dist/material-components-web.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
    <!-- Required Material Web JavaScript library -->
    <script src="https://unpkg.com/material-components-web@v5.0.0/dist/material-components-web.min.js"></script>
    <script src="./scripts/talkBotSdoh.js"></script>
    <!-- talker Function play resume pause ends-->
    <!-- Scripts By Self -->
    <link rel="stylesheet" href="./cssstyles/style.css" />
    <link rel="stylesheet" href="./cssstyles/recordAnimation.css" />
    <style>
    .qs_narrate_audio span {
        font-size: 20px;
        text-align: center;
        -webkit-transition: all .3s ease;
        -moz-transition: all .3s ease;
        transition: all .4s ease;
    }

    .qs_narrate_audio span:hover {
        font-size: 40px;
        color: red;
    }

    .qs_narrate_audio span: {
        font-size: 35px;
    }

    .questionArea {
        height: 100px;
    }

    .activeOption {
        font-size: 15px;
        color: red;
        border-radius: 15px;
        background-color: yellowgreen;
    }

    $white: #ffffff;
    $grey: #E5E5E5;
    $grey-dark: #B5B4B9;

    $green: #6ABB5C;
    $blue: #4FABE4;

    body {
        background: $white;
    }

    .wrapper {
        padding: 2rem;
    }

    .audio-wrapper {
        margin: 0 0 2rem 0;
    }

    .audio {
        width: 100%;

        &::-webkit-media-controls-panel {
            background: white;
        }
    }

    .toolbar {
        text-align: center
    }

    .button {
        transition: all .4s ease-in-out;
        position: inline-block;
        padding: .6rem 1rem;
        background: white;
        border: "1px solid grey";
        border-radius: 0;
        outline: none;
        text-transform: uppercase;
        color: grey-dark;
    }

    .start:hover {
        background: green;
        border-color: darken(green, 5);
        color: white;
    }

    .stop:hover {
        background: blue;
        border-color: darken(blue, 5);
        color: white;
    }

    .flexBox {
        display: flex;
    }

    .flex--justifyContent-center {
        justify-content: center;
    }

    .flex--dir-column {
        flex-direction: column;

    }

    .margin-btm-25px {
        margin-bottom: 25px;
    }

    .mg-top-200px {
        margin-top: 200px;
    }

    .margin-10px {
        margin: 10px;
    }
    </style>


</head>

<body>
    <?php
  require("./navigationbar.php");
  //fetching qsval to check if the quiz is done 1 is completed 
  if ($qsval == 1) {
    //   This loop is for sending emails after the Submit button is clicked after last question Since we are sending same content after demographich form we have commented logic for sending here
    // include('email_submission.php');
    // include('email_response.php');

  ?>
    <div class="container h-100">
        <div class="d-flex h-100 text-center align-items-center">
            <div class="w-100 mg-top-200px">
                <h1 class="animationHeading" id="questionHeader">Thank you for completing the tool! Please let your
                    parent know that you are finished.
                </h1>
            </div>
        </div>
    </div>
    <?php
  } else {
    // Below is the query to populate the scenes only if the user is mapped to kid charahcter in user_chartable whic i removed for now as they dont want profiling of charachters
    // $sql1 = "select qs.id,qs.qurl as videoPath,qs.q_narrate,qs.heading,qs.all_option as options, qs.question_text as question_text from fb_qs qs where qs.id not in (select ans.q_id from fb_ans ans where ans.user_id=? and ans.ans_flag is not null) and qs.characterName in (select characterName from user_character_mapping where uid=" . $_SESSION["userid"] . ")";

    //Below is the query which pulls data for all 18 scenes irrespective of the charachter mapping
    $sql1 = "select qs.id,qs.qurl as videoPath,qs.q_narrate,qs.heading,qs.all_option as options, qs.question_text as question_text from fb_qs qs where qs.id not in (select ans.q_id from fb_ans ans where ans.user_id=? and ans.ans_flag is not null) and qs.quiz_version='" . $version . "'";


    $stmt1 = $conn->prepare($sql1);
    $stmt1->execute([$_SESSION["userid"]]);

    // $stmt1->execute($_SESSION["userid"]);
    $result = $stmt1->fetchAll(PDO::FETCH_ASSOC);

    $formattedResult = array();
    foreach ($result as $row) {
      $row["options"] = explode(",", $row["options"]);
      $formattedResult[] = $row;
      //var_dump($row);
    }
    echo "<script>var questions=" . json_encode($formattedResult) . ";</script>";
    //echo "<script>var version=" . $_SESSION['version'] . ";</script>";
    echo '<script src="./scripts/animate.js" type="text/javascript"></script>';
  ?>
    <div class="container h-100">
        <div class="d-flex h-100 text-center align-items-center">
            <div class="w-100">
                <h1 class="animationHeading" id="questionHeader"><?php echo $formattedResult[0]["heading"]; ?>
                </h1>
            </div>
        </div>
    </div>
    <div id="divVideo" style="text-align: center">

        <div class="col-md-12" id="vedioInstructions">
            <div id="vedioNote" style="font-size:16px;color: orchid;margin-bottom:10px">
                Note : Please click on play button in the below video to listen to the narration .
            </div>

            <!-- <div id="debugLog" style="font-size:16px;color: orchid;margin-bottom:10px">sdcs
            </div> -->

        </div>
        <video id="video1" width="75%" controls playsinline autoplay onended="enableNext()">
            <source src='./vedios/<?php echo $formattedResult[0]["videoPath"] ?>' type="video/mp4">
        </video>

        <form action="#">
            <!-- <div id="optionsHolder">
      </div> -->
            <div class="col-md-12" id="formOptions">
                <button type="button" id="prev" style="display:none" class="btn btn-primary" disabled> Prev</button>
                <!-- <button type="button" id="next" class="btn btn-primary" disabled> Next</button>        -->
            </div>

        </form>
    </div>
    <?php
  }
  ?>

    <!-- modal common for all questions  -->
    <div id="modalCommon" class="modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="align-items:center">
                    <h3 class="modal-title talkBot"> </h3>
                    <audio controls playsinline preload="auto" style="width:100% " id="mySound" onended="playOptions()">
                        <source src="./vedios/questions/<?php echo $formattedResult[0]["q_narrate"] ?>"
                            type="audio/mp3">
                        Your browser does not support the audio element.
                    </audio>

                    <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button> -->
                </div>
                <div class="modal-body">
                    <div id="iosNote" style="display:none;font-size:16px;color: orchid;margin-bottom:10px">
                        Note : Please click on play button above to hear the question again. Then click on a response
                        (yes,sometimes, no) and click "save changes".
                    </div>
                    <div id="iosNoteLastQues" style="display:none;font-size:16px;color: orchid;margin-bottom:10px">
                        Note : Please click on play button above to hear the question again.
                    </div>

                    <div class="wrapper flex--dir-column flexBox">
                        <div class="flexAlign flexWrapper">
                            <div style="color:green;"> Read below for instructions on How to Record:
                                <ul>
                                    <li>To Record any message please click on green record button and then click on
                                        stop.</li>
                                    <li>You can hear back your recorded voice once the recording is done by clicking on
                                        the Play button in below box.</li>
                                    <li>Finally click on Submit Button to submit your Feedback to us.</li>
                                </ul>
                            </div>
                            <div id="recordArea" class="toolbar flex--justifyContent-center recordArea">
                                <div class="flexAlign">
                                    <button id="startRecordBtn" class="js-start btn btn-success margin-10px"
                                        style="width : 200px;" onclick="startRecording()">Record</button>
                                    <button id="stopRecordBtn" class="js-stop btn btn-warning margin-10px" disabled
                                        style="color:white; width : 200px; background-color :#ff0000;"
                                        onclick="stopRecording()">Stop</button>
                                </div>
                                <div class="flexAlign">
                                    <button id="add-to-favorites"
                                        class="margin-10px mdc-icon-button mdc-button--raised mdc-fab--extended mdc-card__action--icon mdc-fab recording-btn recording-off"
                                        aria-label="Start recording" data-aria-label-on="Stop recording"
                                        data-aria-label-off="Start recording">
                                        <i
                                            class="material-icons mdc-icon-button__icon mdc-icon-button__icon--on">mic_none</i>
                                        <i class="material-icons mdc-icon-button__icon">mic_off</i>
                                    </button>
                                    <div class="mdc-typography mdc-typography--overline greet-message"></div>
                                    <div id="startRecording" class="indicatorMsg">Recording ! Click on Stop Button once
                                        done.</div>
                                </div>
                                <div class="audio-wrapper flexAlign" style="display:none;">
                                    <audio controls playsinline class="js-audio audio" style="display:inline;"></audio>
                                </div>
                            </div>


                        </div>

                    </div>
                    <div class="flexBox" id="optionsHolder" style="justify-content:center;font-size:20px"></div>
                </div>
                <div class="modal-footer">
                    <div class="row" style="justify-content: center;width: 100%;">
                        <div>
                            <button id="submitQuiz" style="width: 100px;" type="button" onclick="formSubmit()"
                                class="btn btn-success" type="button"> Submit </button>
                            <button type="button" id="saveAndNext" class="btn btn-primary">Save changes</button>
                            <button id="closebtn" type="buttn" style="width: 100px;" class="btn btn-secondary"
                                data-dismiss="modal">Close</button>
                            <button id="nextbtn" style="width: 100px;" type="button" class="btn btn-success"
                                type="button"> next </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script src="./scripts/recordVoiceAnimation.js"></script>
</body>

</html>