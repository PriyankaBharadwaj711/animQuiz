<?php
error_reporting(0);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
session_start();
$connType = "PDO";
require("./connect.php");
include("./services/saveUserActivityPdo.php");
$useractivity = new ActivityHistory();
$useractivity->saveHistory($conn, "User Activity", "Opened Activity Logs");
if (!$_SESSION["loggedin"]) {
  header("Location:./index.php");
}
?> 

<!doctype html>

<html lang="en">

<head>
  <title>Activity Logs </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css">

  <!-- Scripts By Bootstrap Saved  for vedio header-->
  <link rel="stylesheet" href="./cssstyles/downloadedCss/bootstrap_bundle_min.css" />
  <script src="./scripts/downloadedJs/bootstrap_bundle_min.js" type="text/javascript"></script>
  <!-- Scripts By Self -->
  <link rel="stylesheet" href="./cssstyles/style.css" />
    <script src="./scripts/login.js" type="text/javascript"></script>
    <script src="./scripts/animate.js" type="text/javascript"></script>

  <script>
var table;
    /* Formatting function for row details - modify as you need */
function format ( d ) {
  console.log(d);
    // `d` is the original data object for the row
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td>Role Name:</td>'+
            '<td>'+d.r_name+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Email ID :</td>'+
            '<td>'+d.email+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Phone Number:</td>'+
            '<td>'+d.phnum+'</td>'+
        '</tr>'+
    '</table>';
}
 
$(document).ready(function() {
  $.ajax({
            url: './services/requestUsersActivityLog.php',
            type: 'GET',
            success: function(data) {
                  //console.log(data);

                 table = $('#example').DataTable({
                  "data": JSON.parse(data),
                    "columns": [
                        {
                            "className":      'details-control',
                            "orderable":      false,
                            "data":           null,
                            "defaultContent": ''
                        },
                        { "data": "fname" },
                        { "data": "type" },
                        { "data": "description" },
                        { "data": "creation_date" }
                    ],
                    "order": [[1, 'asc']]
                });

             }
            });
  
  
     // Add event listener for opening and closing details
     $('#example tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
 
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    } );
    
});

  </script>
  <style>
    td.details-control {
    background: url('./resources/details_open.png') no-repeat center center;
    cursor: pointer;
}
tr.shown td.details-control {
    background: url('./resources/details_close.png') no-repeat center center;
}
    </style>
</head>

  <body>
   <?php
        require("./navigationbar.php");
    ?>
  
  <div id="main1">
    <header>
      <div class="container h-100">
        <div class="d-flex h-100 text-center align-items-center">
          <div class="w-100 " >
          <h1 class="animationHeading">Activity Logs</h1>
            <div class="card  border-success text-center" style="overflow-x: scroll;">
                <!-- <div class="card-header activityHeader text-white"> -->
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                      <a class="nav-link active" data-toggle="tab" href="#home">All Users</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#menu1">Just Yours</a>
                    </li>
                </ul>

            <!-- Tab panes -->
                <div class="tab-content">
                    <div id="home" class="container tab-pane active"><br>
                    <table id="example" class="display" style="width:100%">
                      <thead>
                          <tr>
                          <th></th>
                              <th>Name</th>
                              <th>Action</th>
                              <th>Description</th>
                              <th>Time</th>
                          </tr>
                        </thead>
                      <tbody>           
                    </tbody>
                    </table>
                    </div>
                    <div id="menu1" class="container tab-pane fade"><br>
                      <h3>You Log Details 1</h3>
                      <p>Waiting for approval</p>
                    </div>
                   
                </div>
            </div>
           
          
        </div>
      </div>
    </div>
   </header>

 
  </div>
 </body>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
  
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
<link href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
</html>