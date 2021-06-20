<?php
//echo "hello";
// error_reporting(0);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
$connType = "PDO";
require("./connect.php");
include("./services/saveUserActivityPdo.php");
include("./php/class.phpmailer.php");
$useractivity = new ActivityHistory();
$version =$_REQUEST["version"];
$_SESSION["version"]=$version;
$encrypted = $_REQUEST['id'];
function my_simple_crypt( $string, $action = 'd') {
    // you may change these values to your own
    $secret_key = 'my_simple_secret_key';
    $secret_iv = 'my_simple_secret_iv';
  
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash( 'sha256', $secret_key );
    $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
  
    if( $action == 'e' ) {
        $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
    }
    else if( $action == 'd' ){
        $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
    }
  
    return $output;
  }
$email = my_simple_crypt($encrypted, 'd' );
$sql_1 = "update users set registration_status = 'registered' where email='$email'";
$stmt_1 = $conn->prepare($sql_1);
$stmt_1->execute();

if (isset($_SESSION["userid"])) {
  header("Location:./home.php?version=".$version);
}

//Check if username is empty
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty(trim($_POST["username"]))) {
    $username_err = "Please enter username.";
    echo '<script>alert("Please enter Username");</script>';
  } else if (empty(trim($_POST["password"]))) {
    $password_err = "Please enter your password.";
    echo '<script>alert("Please enter Password");</script';
  } else {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
  }

//   var_dump($password);

  // Validate credentials
  if (empty($username_err) && empty($password_err)) {
    $sql = "SELECT u.id,u.fname,u.lname, u.username as username, u.password as password,u.quiz_status,u.email,ur.role_id,r.r_name,r.role_status as roleStatus FROM users u LEFT join pmp_user_role_mapping ur on u.id = ur.user_id left join pmp_role r on ur.role_id = r.role_id WHERE u.username = ? AND u.isFake = 0";
    try {
      $stmt = $conn->prepare($sql);
      $stmt->execute([$username]);
      //fetch the result row and put it in $result
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (Exception $e) {
      echo $e->getMessage();
    }
    if ($result) {
      if ($stmt->rowCount() >= 1) {
        foreach ($result as $row) {
          // Password is correct, so start a new session
          $hashedPwd = $row["password"];
          if (password_verify($password, $hashedPwd)) {
            // Store data in session variables
            $_SESSION["loggedin"] = true;
            $_SESSION["userid"] = $row["id"];
            $_SESSION["username"] = $username;
            $_SESSION["firstname1"] = $row["fname"];
            $_SESSION["lastname2"] = $row["lname"];
            $_SESSION["rname"] = $row["r_name"];
            $_SESSION["quizStatus"] = $row["quiz_status"];

            try {
              $_SESSION["roleId"] = $row["role_id"];
              $sql1 = "SELECT * FROM pmp_role_feature_mapping where r_id=?";

              $stmt1 = $conn->prepare($sql1);

              $stmt1->execute([$_SESSION["roleId"]]);
              //fetch the result row and put it in $result
              $result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
              foreach ($result1 as $row1) {
                $_SESSION["f" . $row1["fid"]] = true;
               
              }

              $useractivity->saveHistory($conn, "LOGIN", "Just logged in");
            } catch (Exception $e) {
              echo $e->getMessage();
            }

            header("Location: ./sdoh.php?version=".$_SESSION["version"]);
            die('Should have redirected by now');
          } else {
            echo "<script>alert('Invalid username or password.Try again');</script>";
            //header("Location: ./pmpDisabledRole.php");
          }
        }
      } else {
        // echo "no rows";
        echo "<script>alert('Cannot Login!!Username doesnot exist in Database');</script>";
      }
    } else {
      echo "<script>alert('Username doesnot exist in Database');</script>";
    }
  }
}
?>
<!doctype html>

<html lang="en">

<head>
    <title>Animation Demo</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css">
    <link rel="stylesheet" href="./cssstyles/consent.css" />
    <link rel="stylesheet" href="./cssstyles/style.css" />
    <script src="./scripts/login.js" type="text/javascript"></script>
    <script src="https://unpkg.com/material-components-web@v5.0.0/dist/material-components-web.min.js"></script>
  <script src="./scripts/talkBotSdoh.js"></script>
    <style>
        input:invalid {
            border: 2px solid red;
        }

        input:valid {
            border: 2px solid black;
        }
        /* to disable inner spin and outer spin for number text field */
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { 
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        margin: 0; 
      }
    </style>
</head>

<body >
<?php
  function getBrowser() { 
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";
  
    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
      $platform = 'linux';
    }elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
      $platform = 'mac';
    }elseif (preg_match('/windows|win32/i', $u_agent)) {
      $platform = 'windows';
    }
  
    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)){
      $bname = 'Internet Explorer';
      $ub = "MSIE";
    }elseif(preg_match('/Firefox/i',$u_agent)){
      $bname = 'Mozilla Firefox';
      $ub = "Firefox";
    }elseif(preg_match('/OPR/i',$u_agent)){
      $bname = 'Opera';
      $ub = "Opera";
    }elseif(preg_match('/Chrome/i',$u_agent) && !preg_match('/Edge/i',$u_agent)){
      $bname = 'Google Chrome';
      $ub = "Chrome";
    }elseif(preg_match('/Safari/i',$u_agent) && !preg_match('/Edge/i',$u_agent)){
      $bname = 'Apple Safari';
      $ub = "Safari";
    }elseif(preg_match('/Netscape/i',$u_agent)){
      $bname = 'Netscape';
      $ub = "Netscape";
    }elseif(preg_match('/Edge/i',$u_agent)){
      $bname = 'Edge';
      $ub = "Edge";
    }elseif(preg_match('/Trident/i',$u_agent)){
      $bname = 'Internet Explorer';
      $ub = "MSIE";
    }
  
    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
  ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
      // we have no matching number just continue
    }
    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
      //we will have two since we are not using 'other' argument yet
      //see if version is before or after the name
      if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
          $version= $matches['version'][0];
      }else {
          $version= $matches['version'][1];
      }
    }else {
      $version= $matches['version'][0];
    }
  
    // check if we have a number
    if ($version==null || $version=="") {$version="?";}
  
    return array(
      'userAgent' => $u_agent,
      'name'      => $bname,
      'version'   => $version,
      'platform'  => $platform,
      'pattern'    => $pattern
    );
  } 
  
  // now try it
  $ua=getBrowser();
  // echo $ua['name'];
  // echo $ua['userAgent'];
  $haystack = $ua['userAgent'];
  $needle = 'iPhone OS';
  $iPod    = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
  $iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
  $iPad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
  $Android = stripos($_SERVER['HTTP_USER_AGENT'],"Android");
  $webOS   = stripos($_SERVER['HTTP_USER_AGENT'],"webOS");

//do something with this information
if($iPhone || $iPad){
    $iPhone = 1;
}
else{
    $iPhone = 0;
}
  if (($iPhone == 1) && ($ua['name'] == "Google Chrome")) {
    require("./topNavbar.php");
  }
  else{
    require("./navigationbar.php");
  }
  $regStatus = $_GET["regstat"];
  if ($regStatus == "registered") {
      include('email_registration.php');
      include('email_response.php');
  ?>
    <script>
    swal("Registered Successfully!", "You have been successfully registered. Kindly use your email address to login to the website", "success");
    </script>
    <?php
  }
  ?>
    <div id = "userAgentdiv">
    </div>
    <!-- <div id = "main" style="margin-top: 250px;display:none"><p style = "font-size:30px; text-align:center;margin:40px;"><b>We apologize for the inconvenience caused. Kindly open the website in Safari.</b><br></p>
    </div> -->
    <div id="main1">
        <header>
            <div class="overlay"></div>
            <div id="consentPage">
                <div class="overlay"></div>
                <form id="regForm" action="./services/insert_patient_details.php" method="post">

                    <div class="tab">
                        <div class="container h-100">
                            <div class="d-flex text-center align-items-center">
                                <div class="w-100 ">
                                    <h1 class="display-3 responsiveTitle" style="margin-bottom: 30px;max-width:1500px">The Lifescreen Animated Tool</h1>
                                    <h3>Parent/Guardian Consent</h3>
                                </div>
                            </div>
                            <p class="lead mb-0 pStyle">Hello! </p>
                            <p class="lead mb-0 pStyle">My name is Dr. Kaprea Johnson (Virginia Commonwealth University)
                                and I am working with
                                your healthcare
                                provider to complete a new animated evaluation and research project. You and your child
                                are being
                                invited to participate, it is voluntary, and you can decide to not participate now and
                                at any time. Your
                                decision not to take part or to withdraw will involve no penalty or loss of benefits to
                                which you are
                                otherwise entitled.</p>
                            <strong class="mb-0 pStyle">What will happen if you participate?</strong>
                            <ol class="lead mb-0 pStyle">
                                <li>You will answer a few questions about your child (e.g., age, gender, race, etc.) and
                                    5 brief
                                    questions about your household.</li>
                                <li>Your child will watch an animated story and answer questions about their life which should take about 5 to 7 minutes,
                                    including their daily living conditions and feelings.</li>
                            </ol>
                            <p class="lead mb-0 pStyle">The information you and your child provide will only be shared
                                with your doctor and me
                                (Dr. Kaprea
                                Johnson). After we receive you and your child's responses, we remove your name and your
                                child's name, we
                                remove any information from responses that can be connected to you. The information you
                                provide will be
                                kept confidential and anonymous. The information cannot be connected to you or your
                                child when reported
                                in any reports.
                            </p>
                            <p class="lead mb-0 pStyle">If you and your child are willing to participate, please type
                                your name below as your
                                signature:</p>
                            <p class="lead mb-0 pStyle">
                            <div class=" row form-group mg-t-25">
                                <p class="col-sm-6"><input required placeholder="Enter your First and Last name" name="signame" id="signame" />
                                <span class="error error_red" id="spanSigName"></span>
                                </p>
                                <p class="col-sm-6 ">
                                <input type="text" name="signDate" id="signDate" disabled value=""> 
                                    <span class="error error_red" id="spandate"></span>
                                </p>
                               

                            </div>
                            </p>
                            <div style="display:flex;margin:5px;align-items: baseline;">
                                <p class="lead mb-0 pStyle">Click this link to view the consent document in its entirety: <a href="#" style="margin-left:10px;" data-toggle="modal" id="bt1" class="show-modal" data-target="#myModal2">View</a> </p>
                                
                            </div>
                            <div style="display:flex;margin:5px;align-items: baseline;">
                                <p class="lead mb-0 pStyle">Click here to view an example of the animated cartoon:  <a href="#" style="margin-left:10px;" data-toggle="modal" id="bt2" class="show-modal1" data-target="#myModal1">View</a></p> 
                            </div>
                           

                        </div>
                    </div>
                    <div class="tab">
                        <div class="container h-100" style="margin-top:30px">
                            <div class="d-flex h-100 text-center align-items-center">
                                <div class="w-100 " style="font-family:sanserif">
                                    <h1 class="display-3 responsiveTitle">The Lifescreen Animated Tool</h1>
                                    <!-- <p class="lead mb-0 pStyle">

                                        Hello! We are going to show you a series of animated videos. Within the videos,
                                        the
                                        character will ask you a question asking about your life. Then, the question
                                        will pop up on
                                        the screen and be repeated with answer choices. Choose one answer for each
                                        question and
                                        please answer truthfully. Your answers will not be shared with anyone other than
                                        the person
                                        who takes care of you and your doctor.
                                    </p> -->
                                    <p class="lead mb-0 pStyle">
                                        &nbsp &nbsp &nbsp Parents and guardians, please complete the following questions
                                        about your
                                        child (i.e., race, gender, age, grade level and free/reduced lunch status). No
                                        one will be
                                        able to connect your answers to you.
                                    </p>
                                    <p class="lead mb-0 pStyle">
                                        &nbsp &nbsp &nbsp We have to collect this information, so that we understand if
                                        questions
                                        are answered differently based on who someone is (i.e. does age matter? gender?,
                                        etc).
                                    </p>
                                    <p class="lead mb-0 pStyle">
                                        &nbsp &nbsp &nbsp After filling out these questions, please hit "submit" and
                                        then have the
                                        child or teenager begin watching the video. Thank you for your help in changing
                                        the world!
                                    </p>
                                    <div style="border: 1px solid;margin: 10px;padding: 25px;">
                                        <div class="form-group d-flex flex-column align-items-baseline mg-b-20">
                                            <label class="color-heading" for="studentName"><strong>Child Name :
                                                </strong></label>
                                            <input type="text" class="form-control color-heading"
                                                placeholder="Enter Child name" required id="studentName"
                                                name="studentName">
                                        </div>
                                        <div class="form-group d-flex flex-column align-items-baseline mg-b-20">
                                            <label class="color-heading" for="parentName"><strong>Parent Name / Guardian
                                                    Name:
                                                </strong></label>
                                            <input type="text" class="form-control color-heading"
                                                placeholder="Enter Parent name" required id="parentName"
                                                name="parentName">
                                        </div>
                                        <div class="form-group d-flex flex-column align-items-baseline mg-b-20">
                                            <label class="color-heading" for="email"><strong> Email </strong></label>
                                            <input type="email" class="form-control color-heading"
                                                placeholder="Enter your email" required id="email" name="email">
                                        </div>

                                        <div class="form-row">
                                            <div
                                                class="form-group col-md-12 col-sm-12 d-flex flex-column align-items-baseline mg-b-20">
                                                <label class="race color-heading" for="race"><strong>Relationship to child: </strong></label>
                                                <div class="input-group flex-items-center">
                                                    <div class="form-check mg-r-10">
                                                        <input class="w-auto" type="radio" name="relationship" value="mother" > 
                                                        <label
                                                            style="font-family: Raleway;"
                                                            class="form-check-label color-heading"> Mother</label>
                                                    </div>
                                                    <div class="form-check mg-r-10 flex-items-center">
                                                        <input class="w-auto" type="radio" name="relationship" value="father">
                                                        <label style="font-family: Raleway;"
                                                            class="form-check-label color-heading"> Father</label>
                                                    </div>
                                                    <div class="form-check mg-r-10 flex-items-center">
                                                        <input class="w-auto" type="radio" name="relationship" value="grandparent">
                                                        <label style="font-family: Raleway;"
                                                            class="form-check-label color-heading"> Grandparent</label>
                                                    </div>
                                                    <div class="form-check mg-r-10 flex-items-center">
                                                        <input class="w-auto" type="radio" name="relationship" value="guardian">
                                                        <label style="font-family: Raleway;"
                                                            class="form-check-label color-heading">
                                                            Foster Parent/legal guardian</label>
                                                    </div>
                                                    <div class="form-check mg-r-10 flex-items-center">
                                                        <input class="w-auto" type="radio" name="relationship" value="other"> <label
                                                            style="font-family: Raleway;"
                                                            class="form-check-label color-heading">
                                                            Other</label>
                                                    </div>
                                                </div>
                                                <span class="error error_red" id="raceError"></span>
                                            </div>
                                        </div>
                                        
                                        <div class="form-row">
                                            <div
                                                class="form-group col-md-12 col-sm-12 d-flex flex-column align-items-baseline mg-b-20">
                                                <label class="race color-heading" for="race"><strong>Does your child have any of the following? (Check all that apply) </strong></label>
                                                <div class="input-group flex-items-center">
                                                    <div class="form-check mg-r-10">
                                                        <input class="w-auto" type="checkbox" name="order[]" value="anxiety" > 
                                                        <label
                                                            style="font-family: Raleway;"
                                                            class="form-check-label color-heading"> Anxiety</label>
                                                    </div>
                                                    <div class="form-check mg-r-10 flex-items-center">
                                                        <input class="w-auto" type="checkbox" name="order[]" value="depression">
                                                        <label style="font-family: Raleway;"
                                                            class="form-check-label color-heading"> Depression</label>
                                                    </div>
                                                    <div class="form-check mg-r-10 flex-items-center">
                                                        <input class="w-auto" type="checkbox" name="order[]" value="behaviour">
                                                        <label style="font-family: Raleway;"
                                                            class="form-check-label color-heading"> Behavioral problems</label>
                                                    </div>
                                                    <div class="form-check mg-r-10 flex-items-center">
                                                        <input class="w-auto" type="checkbox" name="order[]" value="conduct">
                                                        <label style="font-family: Raleway;"
                                                            class="form-check-label color-heading">
                                                            Conduct disorder</label>
                                                    </div>
                                                    <div class="form-check mg-r-10 flex-items-center">
                                                        <input class="w-auto" type="checkbox" name="order[]" value="adhd"> <label
                                                            style="font-family: Raleway;"
                                                            class="form-check-label color-heading">
                                                            ADHD/ADD</label>
                                                    </div>
                                                    <div class="form-check mg-r-10 flex-items-center">
                                                        <input class="w-auto" type="checkbox" name="order[]" value="autism"> <label style="font-family: Raleway;"
                                                            class="form-check-label color-heading">
                                                            Autism Spectrum disorder</label>
                                                    </div>
                                                    <div class="form-check mg-r-10 flex-items-center">
                                                        <input class="w-auto" type="checkbox" name="order[]" value="chronic"> <label style="font-family: Raleway;"
                                                            class="form-check-label color-heading">
                                                            Chronic medical condition</label>
                                                    </div>
                                                    <div class="form-check mg-r-10 flex-items-center">
                                                        <input class="w-auto" type="checkbox" name="order[]" value="order"> <label style="font-family: Raleway;"
                                                            class="form-check-label color-heading">
                                                            None of the above</label>
                                                    </div>
                                                </div>
                                                <span class="error error_red" id="raceError"></span>
                                            </div>
                                        </div>
                                        
                                        <div class="form-row">
                                            <div
                                                class="form-group col-md-12 col-sm-12 d-flex flex-column align-items-baseline mg-b-20">
                                                <label class="race color-heading" for="race"><strong>What racial ethnic
                                                        group is
                                                        your child? </strong></label>
                                                <div class="input-group flex-items-center">
                                                    <div class="form-check mg-r-10">
                                                        <input class="w-auto" type="radio" name="race" value="asian" > 
                                                        <label
                                                            style="font-family: Raleway;"
                                                            class="form-check-label color-heading"> Asian/Pacific
                                                            Islander</label>
                                                    </div>
                                                    <div class="form-check mg-r-10 flex-items-center">
                                                        <input class="w-auto" type="radio" name="race" value="black">
                                                        <label style="font-family: Raleway;"
                                                            class="form-check-label color-heading"> African
                                                            American/Black</label>
                                                    </div>
                                                    <div class="form-check mg-r-10 flex-items-center">
                                                        <input class="w-auto" type="radio" name="race" value="latinx">
                                                        <label style="font-family: Raleway;"
                                                            class="form-check-label color-heading"> Hispanic/
                                                            Latinx</label>
                                                    </div>
                                                    <div class="form-check mg-r-10 flex-items-center">
                                                        <input class="w-auto" type="radio" name="race" value="white">
                                                        <label style="font-family: Raleway;"
                                                            class="form-check-label color-heading">
                                                            Caucasian/White</label>
                                                    </div>
                                                    <div class="form-check mg-r-10 flex-items-center">
                                                        <input class="w-auto" type="radio" name="race" value="multinational"> <label
                                                            style="font-family: Raleway;"
                                                            class="form-check-label color-heading">
                                                            Multiracial</label>
                                                    </div>
                                                    <div class="form-check mg-r-10 flex-items-center">
                                                        <input class="w-auto" type="radio" name="race" value="peferNotToAnswer"> <label style="font-family: Raleway;"
                                                            class="form-check-label color-heading">
                                                            Prefer Not To Answer</label>
                                                    </div>
                                                </div>
                                                <span class="error error_red" id="raceError"></span>
                                            </div>
                                        </div>
                                        <div class="form-row ">
                                            <div
                                                class="form-group col-md-12 col-sm-12 d-flex flex-column align-items-baseline mg-b-20">
                                                <label class="genderDemographic color-heading"
                                                    for="gender"><strong>Child's Gender :
                                                    </strong></label>
                                                <div class="input-group">
                                                    <div class="form-check mg-r-10 flex-items-center">
                                                        <input class="w-auto"  type="radio" name="genderDemographic" id="fGender" value="female">
                                                        <label style="font-family: Raleway;"
                                                            class="color-heading disableOtherText mg-r-10">
                                                            Female<label>
                                                    </div>
                                                    <div class="form-check mg-r-10 flex-items-center">
                                                        <input class="w-auto" type="radio" name="genderDemographic" id="mGender" value="male">
                                                        <label style="font-family: Raleway;"
                                                            class="color-heading disableOtherText mg-r-10"> Male</label>
                                                    </div>
                                                    <div class="form-check mg-r-10 flex-items-center">
                                                        <input class="w-auto"  type="radio" name="genderDemographic" id="transGender"
                                                            value="transgender">
                                                        <label style="font-family: Raleway;"
                                                            class="color-heading disableOtherText mg-r-10">
                                                            Transgender</label>
                                                    </div>
                                                    <div class="form-check mg-r-10 flex-items-center">
                                                        <input class="w-auto" class="mg-r-10" type="radio" id="otherGenderDemo"
                                                            name="genderDemographic" value="other" >
                                                        <label style="font-family: Raleway;"
                                                            class="color-heading disableOtherText mg-r-10">
                                                            Other</label>
                                                    </div>
                                                    <input style="display: none;" type="text" id="other_reason"
                                                        name="other_reason" />
                                                </div>
                                                <span class="error error_red" id="genderDemographicError"></span>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-12 col-sm-12 d-flex flex-column align-items-baseline mg-b-20">
                                                <label class="color-heading" for="age"><strong>Child's Age</strong></label>
                                                <div class="input-group">
                                                    <select id="age" name="age" class="form-control color-heading"
                                                        required>
                                                        <option value="">Choose Age in Years.</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                        <option value="10">10</option>
                                                        <option value="11">11</option>
                                                        <option value="12">12</option>
                                                        <option value="13">13</option>
                                                        <option value="14">14</option>
                                                        <option value="15">15</option>
                                                        <option value="16">16</option>
                                                        <option value="17">17</option>
                                                        <option value="18">18</option>

                                                    </select>
                                                </div>
                                                <span class="error error_red" id="ageError"></span>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div
                                                class="form-group col-md-12 col-sm-12 d-flex flex-column align-items-baseline mg-b-20">
                                                <label for="gradeLevel" class="color-heading"><strong>Current Grade Level</strong></label>
                                                <div class="input-group">
                                                    <select id="gradeLevel" name="gradeLevel"
                                                        class="form-control color-heading" required>
                                                        <option value="">Choose your child’s grade level</option>
                                                        <option value="1">1st Grade</option>
                                                        <option value="2">2nd Grade</option>
                                                        <option value="3">3rd Grade</option>
                                                        <option value="4">4th Grade</option>
                                                        <option value="5">5th Grade</option>
                                                        <option value="6">6th Grade</option>
                                                        <option value="7">7th Grade</option>
                                                        <option value="8">8th Grade</option>
                                                        <option value="9">9th Grade</option>
                                                        <option value="10">10th Grade</option>
                                                        <option value="11">11th Grade</option>
                                                        <option value="12">12th Grade</option>

                                                    </select>
                                                </div>
                                                <span class="error error_red" id="gradeLevelError"></span>
                                            </div>
                                        </div>
                                        <div class="form-row ">
                                            <div class="form-group col-md-12 col-sm-12 d-flex flex-column align-items-baseline mg-b-20">
                                                <label class="childLunch color-heading" for="gender"><strong>Child
                                                        Receive Free or
                                                        Reduced Lunch </strong></label>
                                                <div class="input-group flex-items-center">
                                                    <div class="radio ">
                                                        <label class="color-heading mg-r-10"><input  class="w-auto"  type="radio"
                                                                name="childLunch" value="yes" required>
                                                            Yes</label>
                                                        <label class="color-heading mg-r-10"><input  class="w-auto"  type="radio"
                                                                name="childLunch" value="no"> No</label>
                                                    </div>
                                                </div>
                                                <span class="error error_red" id="childLunchError"></span>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div
                                                class="form-group col-md-12 col-sm-12 d-flex flex-column align-items-baseline mg-b-20">
                                                <label for="gradeLevel" class="color-heading"><strong>Zipcode:</strong>
                                                </label>
                                                <input type="number" class="form-control color-heading" id="zipcode"
                                                    required min="1" max="99999" maxlength="5"
                                                    oninput="this.value=this.value.slice(0,this.maxLength||1/1);this.value=(this.value   < 1) ? (1/1) : this.value;"
                                                    placeholder="Enter zipcode (In numbers only)" name="zipcode" />
                                            </div>
                                            <span class="error error_red" id="zipcodeError"></span>
                                        </div>
                                        <div class="form-row ">
                                            <div
                                                class="form-group col-md-12 col-sm-12 d-flex flex-column align-items-baseline mg-b-20">
                                                <label class="pastmeals color-heading" for="pastMeals">
                                                    <strong>In the past 30 days, did you or others you live with eat
                                                        smaller meals
                                                        or skip meals because you didn’t have money for food?
                                                    </strong>
                                                </label>
                                                <div class="input-group flex-items-center">
                                                    <div class="radio ">
                                                        <label class="color-heading mg-r-10"><input  class="w-auto"  type="radio"
                                                                name="pastmeals" value="yes" required>
                                                            Yes</label>
                                                        <label class="color-heading mg-r-10"><input  class="w-auto"  type="radio"
                                                                name="pastmeals" value="no"> No</label>
                                                    </div>
                                                </div>
                                                <span class="error error_red" id="pastmealsError"></span>
                                            </div>
                                        </div>
                                        <div class="form-row ">
                                            <div
                                                class="form-group col-md-12 col-sm-12 d-flex flex-column align-items-baseline mg-b-20">
                                                <label class="homeless color-heading" for="homeless">
                                                    <strong>Are you homeless or worried that you might be in the future?
                                                    </strong>
                                                </label>
                                                <div class="input-group flex-items-center">
                                                    <div class="radio ">
                                                        <label class="color-heading mg-r-10"><input  class="w-auto"  type="radio"
                                                                name="homeless" value="yes" required>
                                                            Yes</label>
                                                        <label class="color-heading mg-r-10"><input  class="w-auto"  type="radio"
                                                                name="homeless" value="no"> No</label>
                                                    </div>
                                                </div>
                                                <span class="error error_red" id="homelessError"></span>
                                            </div>
                                        </div>
                                        <div class="form-row ">
                                            <div
                                                class="form-group col-md-12 col-sm-12 d-flex flex-column align-items-baseline mg-b-20">
                                                <label class="payUtil color-heading" for="payUtil">
                                                    <strong>Do you have trouble paying for your utilities (gas,
                                                        electricity, phone)?
                                                    </strong>
                                                </label>
                                                <div class="input-group flex-items-center">
                                                    <div class="radio ">
                                                        <label class="color-heading mg-r-10"><input  class="w-auto"  type="radio"
                                                                name="payUtil" value="yes" required> Yes</label>
                                                        <label class="color-heading mg-r-10"><input  class="w-auto"  type="radio"
                                                                name="payUtil" value="no"> No</label>
                                                    </div>
                                                </div>
                                                <span class="error error_red" id="payUtilError"></span>
                                            </div>
                                        </div>
                                        <div class="form-row ">
                                            <div
                                                class="form-group col-md-12 col-sm-12 d-flex flex-column align-items-baseline mg-b-20">
                                                <label class="appliances color-heading" for="appliances">
                                                    <strong>Are any appliances in your home not working currently or
                                                        within the last 3 months (stove, fridge, etc.)
                                                    </strong>
                                                </label>
                                                <div class="input-group flex-items-center">
                                                    <div class="radio ">
                                                        <label class="color-heading mg-r-10"><input  class="w-auto"  type="radio"
                                                                name="appliances" value="yes" required> Yes</label>
                                                        <label class="color-heading mg-r-10"><input  class="w-auto"  type="radio"
                                                                name="appliances" value="no"> No</label>
                                                    </div>
                                                </div>
                                                <span class="error error_red" id="appliancesError"></span>
                                            </div>
                                        </div>
                                        <div class="form-row ">
                                            <div
                                                class="form-group col-md-12 col-sm-12 d-flex flex-column align-items-baseline mg-b-20">
                                                <label class="childCare color-heading" for="childCare">
                                                    <strong>Do you think your child knows that you care about them?
                                                    </strong>
                                                </label>
                                                <div class="input-group">
                                                    <div class="radio ">
                                                        <label class="color-heading mg-r-10"><input  class="w-auto"  type="radio"
                                                                name="childCare" value="yes" required>
                                                            Yes</label>
                                                        <label class="color-heading mg-r-10"><input  class="w-auto"  type="radio"
                                                                name="childCare" value="no"> No</label>
                                                    </div>
                                                </div>
                                                <span class="error error_red" id="childCareError"></span>
                                            </div>
                                        </div>
                                        <div class="form-row ">
                                            <div
                                                class="form-group col-md-12 col-sm-12 d-flex flex-column align-items-baseline mg-b-20">
                                                <label class="findResources color-heading" for="findResources">
                                                    <strong>If you answered "YES" to any of the above questions, would you like help with finding resources?
                                                    </strong>
                                                </label>
                                                <div class="input-group">
                                                    <div class="radio ">
                                                        <label class="color-heading mg-r-10"><input  class="w-auto"  type="radio"
                                                                name="findResources" value="yes" required> Yes</label>
                                                        <label class="color-heading mg-r-10"><input  class="w-auto"  type="radio"
                                                                name="findResources" value="no"> No</label>
                                                    </div>
                                                </div>
                                                <span class="error error_red" id="childCareError"></span>
                                            </div>
                                        </div>
                                        <div class="form-row ">
                                            <div
                                                class="form-group col-md-12 col-sm-12 d-flex flex-column align-items-baseline mg-b-20">
                                                <strong><label for="username">Clinic Name</label></strong>
                                                <select id="clinicName" name="clinicName" class="form-control">
                                                <option value="Sood Clinic" selected>Dr Sood Clinic </option>
                                                <option value="Kaprea Clinic">Dr Kaprea Clinic</option>
                                                <option value="test">Test</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row ">
                                            <div
                                                class="form-group col-md-12 col-sm-12 d-flex flex-column align-items-baseline mg-b-20">
                                                <label class="color-heading" for="anythingElse"><strong> Anything else
                                                        you want help with or would like to add? </strong></label>
                                                <input type="text" class="form-control color-heading"
                                                    placeholder="Enter here"  id="anythingElse"
                                                    name="anythingElse">
                                                <span class="error error_red" id="anythingElseError"></span>
                                            </div>
                                        </div>
                                        <input type="hidden" class="form-control"
                                            value="<?php echo $_REQUEST["version"] ?>"
                                            placeholder="Sending Version Number" required id="version" name="version">
                                            <p class = "lead mb-0 pStyle">
                                                Thank you for your participation and your child’s participation. 
                                            </p>
                                            <p class ="lead mb-0 pStyle">
                                                Please click NEXT below, and hand the device to your child to complete the animated screener.
                                            </p>
                                            <p style="color:red">
                                                Note : The next section is for your child to complete, please pass them the phone or tablet to complete the next section.
                                             </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab">
                        <div class="container h-100">
                            <div class="d-flex h-100 text-center align-items-center">
                                <div class="w-100 " style="font-family:sanserif">
                                    <h1 class="display-3">The Lifescreen Animated Tool</h1>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <p class="lead mb-0 pStyle">
                                                Hi there! My name is Kaprea, and I want to tell you about the cartoon
                                                you are about to watch that is a part of a research study! A research
                                                study is a way to learn more about something.
                                            </p>
                                            <p class="lead mb-0 pStyle">
                                                You are going to see a character go about their day, and they will share
                                                with you what they are doing and how they are feeling. Then, the
                                                character will ask you questions about your life and feelings! The
                                                question will pop up on the screen, and you will choose “yes” , “no”, or
                                                “sometimes”.
                                            </p>
                                        </div>
                                        <div class="col-sm-6">
                                            <video id="video1" width="500" height="345" controls playsinline>
                                                <source src="./vedios/kapr_note.mp4"> type="video/mp4">
                                            </video>
                                        </div>
                                        <div class=col-sm-6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="display: flex;margin-top: 10px">
                        <div style="margin: 0 auto;">
                            <button type="button" id="prevBtn" class="" onclick="nextPrev(-1)">Previous</button>
                            <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
                        </div>
                    </div>
                    <!-- Circles which indicates the steps of the form: -->
                    <div style="text-align:center;margin-top:40px;">
                        <span class="step"></span>
                        <span class="step"></span>
                        <span class="step"></span>
                    </div>
                </form>
            </div>
        </header>
    </div>
  
<script>
    var currentTab = 0; // Current tab is set to be the first tab (0)
    var formData = {
        first_name: "",
        child_name: ""
    }
    showTab(currentTab); // Display the current tab

    function showTab(n) {
        // This function will display the specified tab of the form...
        var x = document.getElementsByClassName("tab");
        x[n].style.display = "block";
        //... and fix the Previous/Next buttons:
        if (n == 0) {
            document.getElementById("prevBtn").style.display = "none";
        } else {
            document.getElementById("prevBtn").style.display = "inline";
        }
        if (n == (x.length - 1)) {
            document.getElementById("nextBtn").innerHTML = "Yes";
        } else {
            document.getElementById("nextBtn").innerHTML = "Next";
            if (currentTab == 2) {
                document.getElementById("nextBtn").innerHTML = "Yes";
            }
        }
        //... and run a function that will display the correct step indicator:
        fixStepIndicator(n)
    }

    function nextPrev(n) {
        // This function will figure out which tab to display
        var x = document.getElementsByClassName("tab");
        // Exit the function if any field in the current tab is invalid:
        if (n == 1 && !validateForm(n)) return false;
        if ((currentTab == 1 || currentTab == 2) && n==1) {
            document.getElementById("video1").play();
        } else {
            document.getElementById("video1").pause();
        }


        // Hide the current tab:
        x[currentTab].style.display = "none";
        // Increase or decrease the current tab by 1:
        currentTab = currentTab + n;
        // if you have reached the end of the form...
        if (currentTab >= x.length) {
            // ... the form gets submitted:
            document.getElementById("regForm").submit();
            return false;
        }
        // Otherwise, display the correct tab:
        showTab(currentTab);
    }

    function validateForm(n) {
        //return true;
        if (currentTab == 0) {
                    if (!document.getElementById("signame").validity.valid) {
                        document.getElementById("signame").focus();
                        return false;
                    }
                    if (!document.getElementById("signDate").validity.valid) {
                        document.getElementById("signDate").focus();

                        return false;
                        
                    }

        } else if (currentTab == 1) {
            if (!document.getElementById("studentName").validity.valid) {
                document.getElementById("studentName").focus();
                return false;
                
            }
            if (!document.getElementById("parentName").validity.valid) {
                document.getElementById("parentName").focus();
                return false;
            }
            if (!document.getElementById("email").validity.valid) {
                document.getElementById("email").focus();
                return false;
            }
            if (typeof($("input[name='race']:checked").val()) == "undefined" || $(
                    "input[name='race']:checked").val() == "") {
                        swal("Race ", "Please Select Race ", "error");

                return false
            }
            if (typeof($("input[name='genderDemographic']:checked").val()) == "undefined" || $(
                    "input[name='genderDemographic']:checked").val() == "") {
                        swal("Gender ", "Please Select Gender ", "error");
                return false
            }
            if(document.getElementById("age").value == ""){
                swal("Age ", "Please Select Age ", "error");
                return false
            }
            if(document.getElementById("gradeLevel").value == ""){
                swal("Grade Level ", "Please Select Grade Level ", "error");
                return false
            }
            if (typeof($("input[name='childLunch']:checked").val()) == "undefined" || $(
                    "input[name='childLunch']:checked").val() == "") {
                        swal("Child Lunch ", "Please Select whether child recieved free or reduced lunch. ", "error");
                return false
            }
            if (!document.getElementById("zipcode").validity.valid) {
                document.getElementById("zipcode").focus();
                return false;
            }
            if (typeof($("input[name='pastmeals']:checked").val()) == "undefined" || $(
                    "input[name='pastmeals']:checked").val() == "") {
                        swal("Past Meals", "Please Select whether did you or others you live with eat smaller meals or skip meals.", "error");
                        document.getElementById("pastmeals").focus();

                return false
            }
            if (typeof($("input[name='homeless']:checked").val()) == "undefined" || $(
                    "input[name='homeless']:checked").val() == "") {
                        swal("Homeless", "Please Select whether are you homeless or worried that you might be in the future", "error");
                return false
            }
            if (typeof($("input[name='payUtil']:checked").val()) == "undefined" || $(
                    "input[name='payUtil']:checked").val() == "") {
                        swal("Past Utilities", "Please Select whether you have trouble paying  your utilities", "error");
                return false
            }
            if (typeof($("input[name='appliances']:checked").val()) == "undefined" || $(
                    "input[name='appliances']:checked").val() == "") {
                        swal("Appliances", "Please Select whether appliances in your home not working currently or within the last 3 months", "error");
                return false
            }
            if (typeof($("input[name='childCare']:checked").val()) == "undefined" || $(
                    "input[name='childCare']:checked").val() == "") {
                        swal("Child Care", "Please Select whether your child knows that you care about them", "error");
                return false
            }
            if (typeof($("input[name='findResources']:checked").val()) == "undefined" || $(
                    "input[name='findResources']:checked").val() == "") {
                        swal("Finding Resources", "Please Select yes or no option whether if you require any help with finding resources ", "error");
                return false
            }
            // if ($("input[name='findResources']:checked").val() == "yes") {
            //             // swal("send email", "email ", "sucess");
            //             console.log("send email needs to be done");
            //     return false
            // }
            // if (!document.getElementById("anythingElse").validity.valid) {
            //     document.getElementById("anythingElse").focus();
            //     return false;
            // }
            // checks if the field is blank or not
            
           
        }
        return true;
    }

    function fixStepIndicator(n) {
        // This function removes the "active" class of all steps...
        var i, x = document.getElementsByClassName("step");
        for (i = 0; i < x.length; i++) {
            x[i].className = x[i].className.replace(" active", "");
        }
        //... and adds the "active" class on the current step:
        x[n].className += " active";
    }

    $(document).ready(function() {
        console.log("document ready");
        $("#signDate").val(new Date().toLocaleDateString());
        // $('#regForm').on('focus', 'input[type=number]', function (e) {
        //     $(this).on('wheel.disableScroll', function (e) {
        //         e.preventDefault()
        //     });
        // });
        //     $('#regForm').on('blur', 'input[type=number]', function (e) {
        //     $(this).off('wheel.disableScroll')
        // });
        $("#myModal1").on('shown.bs.modal', function(event) {
            console.log(event.relatedTarget);
            document.getElementById("scene5").play();
            console.log("document play");
        });

        $(".show-modal").click(function(){
            // $("#myModal1").modal({
            //     backdrop: 'static',
            //     keyboard: false
            // });
        });
        $(".stopVedio").click(function(){
            $("#scene5")[0].pause()
        });
    
    });
    </script>
<div class="modal fade" id="myModal2" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="display:block;">
                    <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
                    <h4 class="modal-title">Consent Document</h4>
                </div>
                <div class="modal-body">
                    <div class="col-sm-12 ">
                        <div class="card">
                            <div class="card-block" style="padding:1%">
                                <h4 class="card-title">Consent</h4>
                                <p class="card-text"></p>
                                <div>
                                <object data="./pdfs/updated_consent.pdf" type="application/pdf" style="width:100%;height:300px;">
                                    alt : <a href="./pdfs/updated_consent.pdf">View</a>
                                </object>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger stopVedio" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="myModal1" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="display:block;">
                    <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
                    <h4 class="modal-title">Sample Video</h4>
                </div>
                <div class="modal-body">
                    <video id="scene5" width="100%" height="345" controls playsinline>
                        <source src="./vedios/scene5.mp4"> type="video/mp4">
                    </video>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger stopVedio" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    

</body>

</html>
