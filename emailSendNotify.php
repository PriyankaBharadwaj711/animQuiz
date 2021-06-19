 
<?php
include("./php/class.phpmailer.php");
class sendEmail{

  public function sendCGEmail($email,$consent_Form,$fnamelnamevalue){
    echo "<script>console.log".($fnamelnamevalue).";</script>".
    $mail = new PHPMailer();

      $emailId = $email;
      $firstlastname= $fnamelnamevalue;
      $mail->SMTPDebug = false;// Enable verbose debug output
      $mail->Port = '587';
      $mail->isSMTP();// Set mailer to use SMTP 
      // Specify main and backup SMTP servers                                   // Set mailer to use SMTP
      $mail->Host = gethostbyname('smtp.gmail.com');  // Specify main and backup SMTP servers
      $mail->SMTPAuth = true; // Authentication must be disabled

      
      $message = 'Welcome to SDOH Screening Tool Portal | <div>Hello  <b style="color:#1c84c6">'.$firstlastname.'</b>,<br><br>  You have been successfully Registered to the Portal. Please use your Registered email to login and Temporary password is : aaaa /</div>';
    
      $messageContent = explode('|', $message);
      $subject = $messageContent[0];
      $matter = $messageContent[1];

      // $file_name = md5(rand()) . '.pdf';
      // $file_name = "./consent.pdf";
      // $f = file_put_contents($file_name, "testingdom");
      // $matter .= $f;
      // $mail->addAttachment($file_name);
      // $mail->IsHTML(true);
      
      //to send html it works
      // $filename="consentform.html";
      // $encoding = "base64";
      // $type = "text/html";
      // $mail->addStringAttachment($consent_Form,$filename,$encoding,$type,"attachment");


      $filename="consentform.pdf";
      // $encoding = "base64";
      $type = "application/octet-stream";
      $mail->addStringAttachment($consent_Form,$filename);
      // $mail->AddEmbeddedImage("./Sign.png", "digitalSign");
      // $mail->AddAttachment("Sign.png");

      $mail->Username = 'clinicaltraining2019@gmail.com';
      $mail->Password = 'hANDSON123';
      $mail->SMTPSecure= 'tls';
      $mail->setFrom('DO-NOT-REPLY@sdoh.com',"DO-NOT-REPLY-ODU SDOH Screening Tool Portal");
      $mail->AddAddress($emailId); 
      // Optional name
      $mail->isHTML(true);            // Set email format to HTML
      $mail->Subject = $subject;
      $mail->Body    = $matter;
      $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';          
      if(!$mail->Send()){
        echo "Failed at email Notify file " .$emailId." ".$role." ".$invite."Error Info:".$mail->ErrorInfo;
      }else{
       
      }
  }


}
?>