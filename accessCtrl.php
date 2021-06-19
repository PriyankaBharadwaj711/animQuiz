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
$useractivity->saveHistory($conn, "Access Control ", "Opened Access Control");
if(!$_SESSION["loggedin"]){
    header("Location:./index.php");
}
?>
<!doctype html>
<html lang="en">

<head>
  <title>ACCESS CONTROL</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/qtip2/3.0.3/jquery.qtip.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/qtip2/3.0.3/jquery.qtip.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" />
  <!-- Scripts By Self -->

  <script src="./jsFiles/pmpAccessControl.js"></script>
  <script src="./scripts/animate.js" type="text/javascript"></script>

  <link rel="stylesheet" href="./cssstyles/style.css" />
   
</head>
<body>
<?php
    require("./navigationbar.php");
?>

<div class="container">

    <div style="margin-top:50px;">
      <div class="align-center teal_heading col-sm-12" id="registrasend_invite_form">
          <div id="panelEditRole" class="panel-group paddingTop">
            <div class="panel panel-info">
              <div class="panel-heading box-heading">
                <h5 class="panel-title">
                  <span class="glyphicon glyphicon-user "> </span> EDIT ROLES
                  <span id="pdrid"></span><span type="button" style="float:right" data-toggle="modal" data-target="#myModal" class="glyphicon glyphicon-plus pointer_hover"> </span> </h5>
              </div>
              <div class="panel-body">
                  <table id="existing_role_table" class="table table-hover" style="width:100%"> <!-- Table -->
                      <thead> <!-- Table head -->
                        <tr class="">
                          <th>ROLE</th><th></th>
                        </tr>
                      </thead> <!-- Table head -->
                      <tbody> <!-- Table body -->
                            <?php 
                        $sql1 = "SELECT * FROM pmp_role";
                        $sql1_result = $conn->query($sql1);
                          if ($sql1_result == TRUE){
                              while ($row = $sql1_result->fetch_assoc()) {
                                if($row["role_status"] == 1){
                                echo '<tr><td>'.$row["r_name"].'</td><td><button href="#" class="btn-warning btn-sm btn editRole" id="'.$row["role_id"].'" name="'.$row["r_name"].'">Edit</button> &nbsp &nbsp <button onclick="disableRole('.$row["role_id"].')" class="btn btn-danger btn-sm " id="disableRole"> Disable</button> </td></tr>' ;
                                }else{
                                echo '<tr><td>'.$row["r_name"].'</td><td><button href="#" class="btn-warning btn-sm btn editRole" id="'.$row["role_id"].'" name="'.$row["r_name"].'">Edit</button> &nbsp &nbsp <button onclick="enableRole('.$row["role_id"].')" class="btn btn-success btn-sm" id="enableRole"> Enable</button> </td></tr>' ;
                              }
                            }
                          }
                            ?>    
                      </tbody>
                  </table>
              </div>
            </div>
          </div>
        </div>
      </div>    
</div>
  <!---------------- modal1 for create Role -->
  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal1 content-->
      <div class="modal-content">
        <div class="modal-header box-heading">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title boldClass">CREATE AND MODIFY ROLE</h4>
        </div>
        <div class="modal-body">
        <form name="createRoleForm" role="form" action ="#" method="post">
              <div class="form-group">
                <label class="form_font_heading" for="createrole">Create Role</label>
                <input type="text" class="form-control" name="cr" id="createRole"  placeholder="Enter Role">
                <span class="font_red error" id="span_createRole" ></span> 
              </div>
                <div class="form-group">
                  <label class="form_font_heading" for="Email">Role Mapping:</label>
                  <table class="table table-bordered">
                    <!-- Table  -->
                    <tbody>
                      <!-- Table body -->
                      <?php 
                     $sql2 = "SELECT * FROM pmp_feature";
                     $sql2_result = $conn->query($sql2);
                      if ($sql2_result == TRUE){
                          while ($row2 = $sql2_result->fetch_assoc()) {
                             echo '<tr><td class="bg_color_lcyan" scope="row"><b>'.$row2["feature_desc"].'</b> </td><td><div class="form-check"><input type="checkbox" class="form-check-input" id="f'.$row2["fid"].'" value="'.$row2["fid"].'" name="createf'.$row2["fid"].'"><label class="form-check-label" for="tableMaterialCheck'.$row2["fid"].'"></label></div> </td></tr>' ;
                          }
                        }
                        ?>
                    </tbody>
                    <!-- Table body -->
                  </table>
                  </div>
                  <!-- Table  -->
            <div class=" col-sm-offset-5 col-sm-7">
                <button id="createRoleSubmit" type="submit" class="btn btn-info btnshadowTrans">CREATE</button>
             </div>
            </form>
          <br> <br>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>  
    <!----Modal1 for Create Role Ends -->
    <!----Modal2 for Modify Role Starts---->
  <div id="myModal2" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal2 for modify role-->
      <div class="modal-content">
        <div class="modal-header box-heading">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title boldClass">Enable or Disable FEATURES</h4>
        </div>
        <div class="modal-body">
        <form name="editRoleForm" role="form" action ="#" method="post">
              <div class="form-group">
                <label class="form_font_heading" for="editRoleName">Role :</label>
                
                <input type="hidden" class="form-control" disabled name="updateRoleId" id="updateRoleId">
                <input type="text" class="form-control" disabled name="editRoleName" id="updateRoleName">
                <span class="font_red error" id="span_editRoleName"></span> 
              </div>
              <div class="form-group">
                  <label class="form_font_heading" for="RoleMap">Role Mapping:</label>
                  <table class="table table-bordered">
                    <!-- Table  -->
                    <tbody>
                      <!-- Table body -->
                      <?php 
                     $sql2 = "SELECT * FROM pmp_feature";
                     $sql2_result = $conn->query($sql2);
                      if ($sql2_result == TRUE){
                          while ($row2 = $sql2_result->fetch_assoc()) {
                             echo '<tr><td class="bg_color_lcyan" scope="row"><b>'.$row2["feature_desc"].'</b> </td><td><div class="form-check"><input type="checkbox" class="form-check-input" id="ef'.$row2["fid"].'" value="'.$row2["fid"].'" name="editf'.$row2["fid"].'"><label class="form-check-label" for="tableMaterialCheck'.$row2["fid"].'"></label></div> </td></tr>' ;
                          }
                        }
                        ?>    
                    
                    </tbody>
                    <!-- Table body -->
                  </table>
              </div>
                  <!-- Table  -->
              <div class=" col-sm-offset-5 col-sm-7">
                <button id="editRolebtn" type="button" class="btn btn-info btnshadowTrans">MODIFY</button>
                </div>
            </form>
          <br> <br>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>

      </div>

    </div>
  </div> 
  <!---- Modal2 for Modify Role  Ends-->

 <div id="userMaintenanceModal" class="modal fade" role="dialog">
  <!----Modal3 for Existing User Update Starts -------->
    <div class="modal-dialog">

      <!-- Modal3 content called in js file-->
      <div class="modal-content">
        <div class="modal-header box-heading">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title boldClass">UPDATE ROLE OF : <span id="editSpecificUname"></span> </h4>
        </div>
        <div class="modal-body">
           <div class="container-fluid">
              <form name="editRoleForm" class="form-inline" action=# method="post">
                         
                         <div class="form-group">
                              <label> Change Role To : </label> 
                               <select class="form-control" id="roleSelect">
                                      <option value="0" id="currentRoleID" selected>Select</option>
                                      <?php
                                      // include("./connect_DB.php");
                                      include("./connect_db_remodeled.php");
                                      $sql = "SELECT * FROM pmp_role";
                                    $sql_result = $conn->query($sql);
                                    if ($sql_result == TRUE) {
                                  while ($row = $sql_result->fetch_assoc()) {
                                        echo "<option value='" . $row["role_id"] . "'>" . $row["r_name"] . "</option>";
                                    }
                                  }
                                  ?>
                              </select>  
                        </div> 
                        <div class="form-group col-sm-offset-4 col-sm-7 paddingTop">
                            <button id="editRolebtn" type="submit" class="btn btn-info">UPDATE</button>
                        </div>
               </form> 
               </div>                               
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>

      </div>

    </div>
  </div>    
  <!-------------------------------------------------- modal3 for user maintenance ends -------------------------------------------------->
    

  <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/datatables.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    
    </div>

 <!-- Calendar Modal -->
 <div id="schedule_event_modal" class="modal fade" role="dialog"></div>

</html>
</body>