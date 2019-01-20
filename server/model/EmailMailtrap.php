<?php
namespace App\Models;
require 'vendor/autoload.php'; //Load Composer's autoloader
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 
require "Email.php"; 

class EmailSubscription extends Email{
   


    public function __construct(){ 
      
      
        $this->site = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST']; // https://www.danielemanzi.it/ ||| http://localhost:3000/
    }
      
  
    

    

/***************************|
*    EMAIL INVIO [MAILTRAP] |           
****************************/  
public function send(){
    
      $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
      try { 
        //  MAILTRAP SMTP
        $mail->SMTPDebug = 0;                                   // Enable verbose debug output
        $mail->isSMTP();                                        // Set mailer to use SMTP
        $mail->Host = 'smtp.mailtrap.io';                       //smtp.gmail.com  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                                 // Enable SMTP authentication
        $mail->Username = 'b34b7169adb122';                     // dmanzi83@gmail.com // SMTP username
        $mail->Password = '8d0c925142f07b';                     // DMbr0l1@XIX83.google  // SMTP password
        $mail->SMTPSecure = 'tls';                              // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 465;    
        //Recipients
        $mail->setFrom($this->emailSender, $this->nameSender);    // mittente email e nome
        $mail->addAddress($this->emailRecipient, $this->nameRecipient);  // destinatario email e nome                  
        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $this->subject;  // Crea una nuova password // Benvenuto in danielemanzi.it // Account su danielemanzi.it cancellato
        $body = require 'layout/'.$this->template.'.tpl.php';  
        $mail->Body = $body; 
        $mail->AltBody = strip_tags($body);
          
        $mail->send();
        } catch (Exception $e) {
            echo 'Invio email fallito! Errore: ', $mail->ErrorInfo;
        }
}


} // CHIUDE CLASSE
