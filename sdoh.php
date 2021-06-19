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


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">

    <!-- Scripts By Self   -->
    <link rel="stylesheet" href="./cssstyles/style.css" />
    <script>
        $.ajax({
        // url: './services/request_Patient_Daily_Report.php',
        url: './services/get_feedback_submitted_Data.php',
        type: 'GET',
        datatype: 'text',
        success: function(data) {
            console.log(data); 
            $('#feedbackPullTable tbody').append(data);
            $('#feedbackPullTable').DataTable();
           
        }
    });
    </script>

</head>

<body>
    <?php
     $sql = "SELECT * FROM users WHERE id = '$uid' AND registration_status = 'requested';";
     $result = $conn->query($sql);
     if($result->num_rows>0){
        
             require("./navbar.php");
             echo '<div class="container text-center align-items-center" style="margin-top:10%"><h1>Kindly Verify your email address to login to the website.If you still face any issue even after authenticating your email please contact the devlopment team.</h1></div>';
     }
    else{
    require("./navigationbar.php");
    ?>
    <div class="container text-center align-items-center" style="margin-top:10%"><h1>Welcome To Lifescreen Animated Tool !!!</h2></div>
    <?php
            
        }
    ?>
</body>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>

</html>