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
      $parent_name = $row['parentName'];
      $age = $row['age'];
      $gender = $row['gender'];
      $race = $row['race'];
      $grade = $row['grade'];
      $lunch_status = $row['lunchStatus'];
      $pastmeals = $row['pastmeals'];
      $homeless = $row['homeless'];
      $payUtility = $row['payUtility'];
      $notWorking = $row['notWorking'];
      $childKnows = $row['childKnows'];
      $anything = $row['anything'];
      
    }
    if(($pastmeals == "yes")||($homeless=="yes")||($payUtility=="yes")||($notWorking=="yes")){
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
$mailaddress = "equityresearchnow@gmail.com";
$mail->AddAddress('johnsonkf@vcu.edu');
$mail->addBCC('amatc001@odu.edu');

// $mailaddress = "adithyar82@gmail.com";
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
              <p> Child Name: '.$fname.'</p>
              <p> Parent Name / Guardian Name: '.$parent_name.'</p>
              <p> Email: '.$email.'</p>
              <p> What racial ethnic group is your child? '.$race.'</p>
              <p> Child s Gender : '.$gender.'</p>
              <p> Child s Age: '.$age.'</p>
              <p> Grade Level in September 2020: '.$grade.'</p>
              <p> Child Receive Free or Reduced Lunch: '.$lunch_status.'</p>
              <p> In the past 30 days, did you or others you live with eat smaller meals or skip meals because you didn’t have money for food? '.$pastmeals.'</p>
              <p> Are you homeless or worried that you might be in the future? '.$homeless.'</p>
              <p> Do you have trouble paying for your utilities (gas, electricity, phone)? '.$payUtility.'</p>
              <p> Are any appliances in your home not working currently or within the last 3 months (stove, fridge, etc.) '.$notWorking.'</p>
              <p> Do you think your child knows that you care about them? '.$childKnows.'</p>
              <p>Anything else you want help with or would like to add? '.$anything.' </p>
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
        
    }
  }
?>
