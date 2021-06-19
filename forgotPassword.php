
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

   <script>
    //Check if email is already existing in DB or not
            $(document).on("input", '#fpemail', function() {
                var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
                var email = $('#fpemail').val().trim();

                if (($('#fpemail').val().length > 1) && (mailformat.test($('#fpemail').val()))) {
                    $('#spanEmail').html("");
                } else {
                    $('#spanEmail').html("<div class='warning_color'><i class='fa fa-exclamation-triangle' aria-hidden='true'></i>&nbsp <span class='warning_color'>Enter correct format email address</span><i></div>");

                }
            });
    </script>
</head>

<body>

<?php
  require("./navigationbar.php");
  if(isset($_POST['update_profile'])){
  $email = $_POST['fpemail'];
  $sql = "SELECT * FROM users WHERE email = '$email';";
  $result = $conn->query($sql);
  if($result->num_rows>0){
    $mail = new PHPMailer;
    $mailaddress = $email;
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
    $encrypted = my_simple_crypt($email, 'e' );
    // $fname = $_POST['fname'];
    // $username = $_POST['username'];
    // $mail->SMTPDebug = 4;                               // Enable verbose debug output

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail -> Username = 'sdohanimation@gmail.com';
    $mail -> Password = 'testPassword01!';                          // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    $mail->setFrom('sdohanimation@gmail.com', 'no reply');
    $mail->addAddress($mailaddress);     // Add a recipient
    // $mail->addAddress('ellen@example.com');               // Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    // $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = 'Lifescreen Animated Tool';
    $mail->Body    = '<html>
    <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
    body {
      margin: 0;
      font-family: Arial, Helvetica, sans-serif;
      margin: 10px;
      font-size: 13px;
    }
    
    .topnav {
      overflow: hidden;
      background-color: #333;
      
    }
    
    .topnav a {
      float: left;
      color: #f2f2f2;
      text-align: center;
      padding: 14px 16px;
      text-decoration: none;
      font-size: 17px;
    }
    
    .topnav a:hover {
      background-color: #ddd;
      color: black;
    }
    
    .topnav a.active {
      background-color: #4CAF50;
      color: white;
    }
    .bodyContent {
      margin:30px;
      width: 80%;
      box-sizing: border-box;
      word-break: break-word;
      font-size: 12px;
    }
    .bodyContent p {
      color:black;
      font-size: 18px;
      font-weight: bold;
    }
    .content {
      padding: 10px 0;
    }
    </style>
    </head>
    <body>
    <div style = "background-color : #f5f5f5 ; width: 100%;">
      <br>   
    
        <div style="background-color : White; margin:30px;">
            <div class="topnav">
                <a class="active" href="#home">Lifescreen Animated Tool</a>
            </div>
            <div class="bodyContent">
                <p>Dear '.$fname.' </p>
                <p class="content">Thank you for your participation.

                <p>Kindly click on the link below to change your password</p>
                <p><a href="https://qav2.cs.odu.edu/animQuiz/dev/forgot_password.php?id='.$encrypted.'&verison=2">Click here to change your password</a></p>
                
                Have a great day!</p>
            </div>
            <br>
            <br>
            
        </div>
        <br>
        <br>
        <br>
    </div>
    </body>
    </html>';              
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    $mail -> isHTML(true);
    if(!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
        
    } else {
      
        echo '<script>alert("A email has been sent to your registered email address to change your password");
        window.location = "forgotPassword.php?btn=back";
        </script>';


        
    }
  }
  else{
    echo '<script>
    alert("This email has not been registered");
    </script>';
  }
}

?>
       <div style="margin-top:50px;text-align:center" class="container centerPiece" id="registration_form">
            <h2><i class="fa fa-user"></i> FORGOT PASSWORD </h2>
            <form class="form_properties" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="form-group">
                    <input type="text" class="form-control" id="fpemail" name="fpemail" placeholder="Enter Email Address">
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