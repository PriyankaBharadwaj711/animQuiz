<?php
//mqsqli
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// error_reporting(0);
session_start();
require("./connect.php");
include("./services/saveUserActivity.php");
$useractivity = new ActivityHistory();
$useractivity->saveHistory($conn, "Profile Page ", "Opened Profile Page");
$uname = $_SESSION["username"];
$uid = $_SESSION["userid"];
if (!$_SESSION["loggedin"]) {
    header("Location:./index.php");
  }
// var_dump($_SESSION);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST['f_name'];
    $lname = $_POST['l_name'];
    $age = $_POST['age'];
    $emailaddress = $_POST['email_at_registration'];
    $phnum = $_POST['phnum'];
    $clinic_name = $_POST['clinic_name'];
    $clinic_address = $_POST['clinic_address'];
    $clinic_phnum = $_POST['clinic_phnum'];
    $administrative_assistant = $_POST['administrative_assistant'];

    $sql1 = "UPDATE users SET fname='$fname',lname='$lname',email='$emailaddress',age='$age',phnum='$phnum', clinicName = '$clinic_name', clinic_address = '$clinic_address', clinic_phnum = '$clinic_phnum', administrative_assistant = '$administrative_assistant' WHERE id= $uid";
    $sql_result1 = $conn->query($sql1);
    if ($sql_result1 == TRUE) {
        echo "<script>alert('successully updated');</script> ";
        // return true;
    }
}
echo "<script>console.log($uid);</script>";

$sql0 = "SELECT  fname,lname,email,id,age,phnum, clinicName, clinic_address, clinic_phnum, administrative_assistant FROM users WHERE  username = '$uname' ";
// echo $sql0;
$sql0_result = $conn->query($sql0);
if ($sql0_result == TRUE) {
    while ($row = $sql0_result->fetch_assoc()) {

        $firstname = $row["fname"];
        $lastname = $row["lname"];
        $emailaddr = $row["email"];
        $ageRetrieved = $row["age"];
        $phNumRetrieved = $row["phnum"];
        $clinicName = $row["clinicName"];
        $clinicAddress = $row["clinic_address"];
        $clinicphNum = $row["clinic_phnum"];
        $administrativeAssistant = $row["administrative_assistant"];
        // var_dump ($firstname);

    }
}

$sql2 = "SELECT id,characterName FROM user_character_mapping WHERE uid = '$uid' ";
$sql2_result = $conn->query($sql2);

if ($sql2_result == TRUE) {
    while ($row = $sql2_result->fetch_assoc()) { 
        $profileId = $row["id"];
        $character = $row["characterName"];
    }
}

echo "<script>var character=".json_encode($character).";</script>";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Profile</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css">
  <script src="./scripts/animate.js" type="text/javascript"></script>
  <script src="./scripts/common.js" type="text/javascript"></script>

 <!-- Scripts By Self   -->
    <link rel="stylesheet" href="./cssstyles/style.css" />
         <script>
           $(document).ready(function() {
                $("#update_profile").on("click",function(){
                    // swal("Success!", "You profile has been updated Successfuly", "success");
                    // return false;
                               });
            });

            
        </script>
        <style>
            .alignItems,.alignList  {
                display: flex;
                align-items: baseline;
                justify-content: space-around;
            }
            .listBorder {
                border: 1px solid grey;
                padding: 40px;
            }
            .alignList {
                list-style-type: none;
                align-items: center;                
                margin-bottom: 20px;
            }
            .alignList li {
                padding: 10px;
                border: 1px solid grey;
                margin: 10px;
            }
            .alignList li:hover {
                cursor: pointer;
            } 
        </style>
</head>

<body>
<?php 
require("./navigationbar.php");
?>   
<div class="container alignItems">
    <div class="col-sm-6 col-md-6" id="registration_form">
        <div class="centerAlign">
            <h2 class="animationHeading">
                Profile Details 
            </h2>
        </div>
        <form class="form_properties" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label for="fname"><strong>First Name :</strong></label>
                <div class="input-group">
                    <input id="f_name" name="f_name" type="text" class="form-control" size="100" value="<?php echo htmlspecialchars($firstname) ?>" required>
                    <span class="error error_red" id="spanf_name"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="lname"><strong>Last Name :</strong></label>
                <div class="input-group">
                    <input id="l_name" name="l_name" type="text" class="form-control" size="100" value="<?php echo htmlspecialchars($lastname) ?>" required>
                    <span class="error error_red" id="spanl_name"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="Email"><strong>Email :</strong></label>
                <div class="input-group">
                    <input id="email_at_registration" name="email_at_registration" type="email" class="form-control" size="100" value="<?php echo htmlspecialchars($emailaddr) ?>" required>
                    <span class="error error_red" id="spanEmail_at_registration"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="Email"><strong>Role :</strong></label>
                <div class="input-group">
                    <input id="rolename" name="rolename" type="email" disabled class="form-control" size="100" value="<?php echo $_SESSION["rname"] ?>" required>
                    <span class="error error_red" id="spanEmail_at_registration"></span>
                </div>
            </div>
            <!-- <div class="form-group">
                <label for="age"><strong>Age :</strong></label>
                <div class="input-group">
                    <input id="age" name="age" type="number" class="form-control" size="100" value="<?php echo htmlspecialchars($ageRetrieved) ?>" required>
                    <span class="error error_red" id="spanage"></span>
                </div>
            </div> -->
            <div class="form-group">
                <label for="age"><strong>Phone Number :</strong></label>
                <div class="input-group">
                    <input id="phnum" name="phnum" type="number" class="form-control" size="100" value="<?php echo htmlspecialchars($phNumRetrieved) ?>" required>
                    <span class="error error_red" id="spanage"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="age"><strong>Clinic Name :</strong></label>
                    <select id="clinic_name" name="clinic_name" class="form-control">
                    <option value="Sood Clinic" selected><?php echo htmlspecialchars($clinicName) ?> </option>
                    <option value="Sood Clinic">Dr Sood Clinic </option>
                    <option value="Kaprea Clinic">Dr Kaprea Clinic</option>
                    <option value="test">Test</option>
                    </select>
            </div>
            <div class="form-group">
                <label for="age"><strong>Clinic Address :</strong></label>
                <div class="input-group">
                    <input id="phnum" name="clinic_address" type="text" class="form-control" value="<?php echo htmlspecialchars($clinicAddress) ?>" required>
                    <span class="error error_red" id="spanage"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="age"><strong>Clinic Phone Number :</strong></label>
                <div class="input-group">
                    <input id="phnum" name="clinic_phnum" type="number" class="form-control" value="<?php echo htmlspecialchars($clinicphNum) ?>" required>
                    <span class="error error_red" id="spanage"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="age"><strong>Administrative Assistant Name :</strong></label>
                <div class="input-group">
                    <input id="phnum" name="administrative_assistant" type="text" class="form-control" value="<?php echo htmlspecialchars($administrativeAssistant) ?>" required>
                    <span class="error error_red" id="spanage"></span>
                </div>
            </div>
            
            <div class="text-align form-group">
                <div class="centerAlign">
                    <button class="btn btn-success" id="update_profile" name="update_profile" type="submit"><i class="fa fa-edit" style="font-size: 20px"></i> UPDATE</button>
                </div>
            </div>    
        </form>
    </div>
</div>
</body>
</html>