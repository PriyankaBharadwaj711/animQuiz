
<?php
require("./connect.php");
include("./php/class.phpmailer.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Forgot password</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css">  <!-- Scripts By Self   -->
    <!-- Scripts  By Self-->
    <link rel="stylesheet" href="./cssstyles/style.css" />

  
</head>

<body>

<?php
  require("./navigationbar.php");
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
// echo $email;
?>
       <div style="margin-top:100px;text-align:center" class=" col-sm-3 col-md-4 container centerPiece" id="registration_form">
            <h2><i class="fa fa-user"></i> FORGOT PASSWORD </h2>
            <form class="form_properties" method="POST" action="services/update_password.php">
                    <div class="form-group">
                    <input type="password" class="form-control" id="fpemail" name="password" placeholder="Enter Password">
                     <span class="error_red error" id="spanEmail"></span>
                    </div>
                    <div class="form-group">
                    <input type="password" class="form-control" id="fpemail" name="" placeholder="Confirm Password">
                     <span class="error_red error" id="spanEmail"></span>
                    </div>
                    <div class="form-group">
                    <input type="text" class="form-control" id="fpemail" name="email" value = "<?php echo $email?>" hidden>
                     <span class="error_red error" id="spanEmail"></span>
                    </div>
                    <div class="centerAlign form-group">
                        <div>
                           <button class="btn btn-success" id="update_profile" name="update_profile" type="submit"><i class="fa fa-edit"></i>Submit</button>
                        </div>
                    </div>
                </div>
            </form>
       </div>
</body>
</html>