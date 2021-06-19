<?php
$sql = "SELECT * FROM users WHERE registration_status = 'requested'";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // $stmt1->execute($_SESSION["userid"]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // $formattedResult = array();
    foreach ($result as $row) {
      // $row["options"] = explode(",", $row["options"]);
      // $formattedResult[] = $row;
      $fname = $row['fname'];
      $email = $row['email'];
      $fname = $row ['fname'];
    }
$encrypted = my_simple_crypt($email, 'e' );
$mail = new PHPMailer;
$mailaddress = $email;
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

                <p>Kindly click on the link below to verify your email address</p>
                <p><a href="https://qav2.cs.odu.edu/animQuiz/dev/index.php?id='.$encrypted.'&verison=2">Click here to verify your email address</a></p>

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
    //   $sql_1 = "update users set email_1=1 where id=?";
    //   $stmt_1 = $conn->prepare($sql);
    //   $stmt_1->execute([$_SESSION["userid"]]);
        
    }
?>