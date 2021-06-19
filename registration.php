<html>
<head>
    <title>Registration SDOH</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./cssstyles/style.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css">
</head>
  <style>
   /* to disable inner spin and outer spin for number text field */
   input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    margin: 0; 
}
  </style>
<body>
<?php 
  $flag ="regnav";
  require("./navigationbar.php");
  $regStatus = $_GET["regstat"];
  if($regStatus == "failed"){
    ?>
    <script>swal("Registration Failed!", "Please check if your email or usernam are not used.", "warning");</script>
  <?php
    }
  ?>
<div id="main1" class="container">
<div class="text-mono text-center text-gray-light text-normal mb-3 mg-t-25" >Join Lifescreen Animated Tool</div>
<h1 style="text-align:center;margin-top:50px;margin-bottom:20px;color:#4CAF50"><i class="fa fa-registered"></i> Create your account </h1>

<form method="post"  action="./services/register_user.php">
<div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">First Name</label>
      <input type="text" required class="form-control" id="fname" name="fname" placeholder="First Name">
      <span class="error error_red" id="spanf_name" ></span> 

    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Last Name</label>
      <input type="text" required class="form-control" id="inputPassword4" name="lname" placeholder="Last Name">
      <span class="error error_red" id="spanl_name" ></span> 

    </div>
  </div>
  <div class="form-row">
  <div class="form-group col-md-6">
      <label for="inputPassword4">Password</label>
      <input type="password" required class="form-control" id="inputPassword4" name="password" placeholder="Password">
      <span class="error error_red" id="spanpassword" ></span> 

    </div>
    <div class="form-group col-md-6">
      <label for="inputConfirmPassword4">Confirm Password</label>
      <input type="password" required class="form-control" id="confirmPassword" placeholder="Confirm Password">
      <span class="error error_red" id="spanconfirmPassword" ></span> 

    </div>
  </div>
  <div class="form-row">
  <div class="form-group col-md-3">
      <label for="username">Username</label>
      <input type="text" required class="form-control" id="username" name="username" placeholder="username">
      <span class="error error_red" id="spanConfirmUsername" ></span> 
  </div>  
  <div class="form-group col-md-3">
      <label for="username">Role</label>
      <select id="roleSelect" class="form-control" name="roleSelect">
      <option selected>Choose...</option>
                <?php
                    $connType="PDO";
                    require("./connect.php");
                    $sql = "select * from pmp_role";
                    //echo $sql;

                        $stmt= $conn->prepare($sql);
                        $result=$stmt->execute([]);
                        if($result){
                          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . $row["role_id"] . "'>" . $row["r_name"] . "</option>";
                          }
                        }else{
                          echo $e->getMessage();
                        }
                  ?>
      </select>
      <span class="error error_red" id="spanConfirmUsername" ></span> 
  </div>  
  <div class="form-group col-md-3">
    <label for="username">Clinic Name</label>
    <select id="clinicName" name="clinicName" class="form-control" >
        <option value="Sood Clinic">Dr Sood Clinic </option>
        <option value="Kaprea Clinic">Dr Kaprea Clinic</option>
        <option value="test">Test</option>
		</select>
  </div>
  
  <div class="form-group col-md-3">
      <label for="phonenumber">Phone Number</label>
      <input type="txt" maxlength="10" required class="form-control"  oninput="this.value=this.value.slice(0,this.maxLength||1/1);this.value=(this.value   < 1) ? (1/1) : this.value;" id="phnum" name="phnum" placeholder="Phone">
  </div>
  <div class="form-group col-md-3">
    <label for="inputEmail4">Email</label>
    <input type="email" class="form-control" required id="inputEmail4" name="email" placeholder="Email">
  </div>
  <div class="form-group col-md-3">
         <label for="age">Age:</label>
         <input type="txt" maxlength="2" required class="form-control"  oninput="this.value=this.value.slice(0,this.maxLength||1/1);this.value=(this.value   < 1) ? (1/1) : this.value;" placeholder="Age" name="age" id="age"/>
  </div>
  <div class="form-group col-md-3">
      <fieldset class="form-group">
          <legend class="col-form-label col-sm-12 pt-0">Gender</legend>
          <div class="col-sm-12">
              <div class="form-check">
              <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="Male" checked>
              <label class="form-check-label" for="gridRadios1">
                  Male
              </label>
              </div>
              <div class="form-check">
              <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="Female">
              <label class="form-check-label" for="gridRadios2">
                  Female
              </label>
              </div>
            </div>
      </fieldset>
  </div>
  <div class="form-group col-md-3">
      <label for="inputZip">Zip</label>
      <input type="number" class="form-control" required id="inputZip" required min="1" max="99999" name="zipcode" maxlength="5"  placeholder="Zip Code">
    </div>
  </div>
  <div style="text-align:center"><button type="submit" class="btn btn-primary">Sign in</button>
  </div>
</form>
</div>
</body>
</html>