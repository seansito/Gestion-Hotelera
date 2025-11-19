<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader (created by composer, not included with PHPMailer)
require __DIR__ . '/../../vendor/autoload.php';
function sendEmailVerification($name, $email, $verify_token, $setTemplate = 1){
    //(name, email... )
$mail = new PHPMailer(true);

    $mail->SMTPDebug = 0;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'yuga42694@gmail.com';                     //SMTP username
    $mail->Password   = 'dyob ytvp vzee dcot';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('yuga42694@gmail.com', 'Hotel Violeta');
    $mail->addAddress($email);     //Add a recipient
    // $mail->addAddress('ellen@example.com');               //Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Verificacion de email del Hotel Violeta';
    if($setTemplate == 1){
        $mail->Body ="
        <h2> Hola $name ! Te has registrado con el Hotel Violeta  </h2>
    <h5> Verifica tu email haciendo click en el siguiente link:</h5>
    <br>
    <a href='http://localhost/hotel/src/verificarEmail.php?token=$verify_token'>Click aquí para verificar tu email </a>

    ";
    }
    else if($setTemplate == 3){
         $mail->Body ="
        <h2> Hola $name!</h2>
    <h5>Te contactamos para avisarte que has comprado un travesti exitosamente</h5>
    <br>
    <p>Gracias por contratar nuestros servicios! </p>

    ";
    }
    else{
        $mail->Body = "
        <h2> Hola $name! </h2>
    <h5> Si estás intentando recuperar tu contraseña, clickea el siguiente link:</h5>
    <br>
    <a href='http://localhost/hotel/src/nuevaContraseña.php?token=$verify_token'>Click here to reset your password </a>

    ";
    }
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    // echo 'Message has been sent';
// } catch (Exception $e) {
//     echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
// }

}

?>