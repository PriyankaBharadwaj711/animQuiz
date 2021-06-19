<?php
$sql2 = "SELECT * FROM users WHERE id = ?";


    $stmt2 = $conn->prepare($sql2);
    $stmt2->execute([$_SESSION["userid"]]);

    // $stmt1->execute($_SESSION["userid"]);
    $result = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    // $formattedResult = array();
    foreach ($result as $row) {
      // $row["options"] = explode(",", $row["options"]);
      // $formattedResult[] = $row;
      $fname = $row['fname'];
      $email = $row['email'];
      $fname = $row ['fname'];
    }
      //var_dump($row);
      // echo $email;
      
// $mail = new PHPMailer;
// $mail -> isSMTP();
// $mail -> Host = 'smtp.gmail.com';
// $mail -> Post = 587;
// $mail -> SMTPAuth = true;
// $mail -> SMPTSecure = 'tls';

// $mail -> Username = 'noreplyhomesearchportal@gmail.com';
// $mail -> Password = 'Vikram!23';
// $mailaddress = $_POST['email'];
// $fname = $_POST['fname'];
// $username = $_POST['username'];
// require 'PHPMailerAutoload.php';
// function rand_string_1( $length ) {

//     $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
//     return substr(str_shuffle($chars),0,$length);
    
//     }
    
// $pwd = rand_string_1(8);
// echo $pwd;
$mail = new PHPMailer;
$mailaddress = $email;
// $fname = $_POST['fname'];
// $username = $_POST['username'];
// $mail->SMTPDebug = 4;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
// $mail->Username = 'adithyar82@gmail.com';                 // SMTP username
// $mail->Password = 'Stabal@2'; 
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

$mail->Subject = ' SDOH Animation Quiz';
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
    <div style = "background-color : #f5f5f5 ;width: 100%;">
    <br>   
    
        <div style="background-color : White; margin:30px;">
            <div class="topnav">
                <a class="active" href="#home">Lifescreen Animated Tool</a>
            </div>
            <div class="bodyContent">
              <p>Dear '.$fname.' </p>
              <p class="content">Thank you for your participation.

              To make finding the support you need easy, we recommend the findhelp.org website.  You can type in the website using your phone or computer (www.findhelp.org). To use the website you plug your zipcode into the search bar, and findhelp.org generates a large list of programs in your area, sorted into the kind of help that is needed be it food, housing, financial, legal, transportation, etc.
              If you find a program that is a good fit, just click on it to find the contact information for the organization. The list of resources is huge and diverse and the website is easy to navigate, but we are more than happy to answer any questions that come up. You can also watch a two minute video which shows you how to use the findhelp.org website. The video is here: https://youtu.be/PDzC7AciAP8
              If you would like someone to send resources from the findhelp.org website directly to you,  please email us at equityresearchnow@gmail.com or Dr. Johnson at Johnsonkf@vcu.edu.
              <br>
              <br>
              Sincerely,
              <br>
              The Equity Research Team in Collaboration with Providers of HealthCare
              <br>
              Have a great day!</p>
            </div>
            
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
      // $sql_1 = "update users set email_1=1 where id=?";
      // $stmt_1 = $conn->prepare($sql);
      // $stmt_1->execute([$_SESSION["userid"]]);
        
    }
?>