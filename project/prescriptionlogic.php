
<?php

if(!isset($_SESSION["NIC"]))
{
	header("location:index.php");
}

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';



$conn = mysqli_connect('localhost', 'root', '', 'group44');

$sql = "SELECT * FROM `prescriptions`";
$result = mysqli_query($conn, $sql);



if(isset($_POST['upload'])){

    $dt = date('Y-m-d H:i:s ');
    $Pnic = $_POST['patientID'];
    $pres = $_POST['prescription'];
    $Dnic =   $_SESSION["NIC"] ;
    $email= $_POST['email'];
    $adt = $_POST['apdate'];

    $name = $_SESSION["NIC"] ;
   
    // insert data
    



$mail = new PHPMailer(true);

try {
    
    $mail->isSMTP();                                          //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'sajinadissanayake999@gmail.com';                     //SMTP username
    $mail->Password   = 'jktokiunivygskdc';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('from@example.com', 'doctor');
    $mail->addAddress($email);     //Add a recipient
    

    $message = "dear ".$Pnic."\r\n". "your next appointment date of doctor".$Dnic. "\r\n is  - ".$adt;

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'appointment date ';
    $mail->Body    = $message;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

mysqli_query($conn,"INSERT INTO `prescriptions`( `Pnic`, `Dnic`, `Prescription`,`Time`) VALUES ('$Pnic','$Dnic','$pres','$dt')");
header("location:prescription.php");

    

}


?>
