<?php

require 'vendor/autoload.php'; //Load Composer's autoloader
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 
require "Email.php"; 

class EmailNewPass extends Email{
   

    private $subject = "Nuova password";
    private $buttonTpl = 'Nuova password'; 
    // variabili per il template/body dell' email
    private $template = 'emailAuth';     
    public $site;
    public $titleTpl = 'Crea una nuova password'; 
    public $infoTpl = 'Per creare una nuova password clicca sul bottone nuova password';
    public $link;          


    public function __construct(){ 
      
        $this->site = "http://localhost/login-system/";
        $this->link = $this->site."?email=".$email."&hash=".$hash; //http://localhost:3000/auth/verify/?email=dmanzi83@hotmail.it&hash=a597e50502f5ff68e3e25b9114205d4a
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
      $mail->Host = 'smtp.mailtrap.io';                       // Specify main and backup SMTP servers
      $mail->SMTPAuth = true;                                 // Enable SMTP authentication
      $mail->Username = 'b34b7169adb122';                     // dmanzi83@gmail.com   // SMTP username
      $mail->Password = '8d0c925142f07b';                     // mia password google  // SMTP password
      $mail->SMTPSecure = 'tls';                              // Enable TLS encryption, `ssl` also accepted
      $mail->Port = 465;    
      //Recipients
      $mail->setFrom($this->emailSender, $this->nameSender);    // mittente email e nome
      $mail->addAddress($this->emailRecipient, $this->nameRecipient);  // destinatario email e nome                  
      //Content
      $mail->isHTML(true);                                  // Set email format to HTML
      $mail->Subject = $this->subject;  // Crea una nuova password // Benvenuto in danielemanzi.it // Account su danielemanzi.it cancellato
      // $body = "<h1>Email Inviata</h1>";  
      if( file_exists("view/".$this->template.".tpl.php") ) {
          $body = require 'view/'.$this->template.'.tpl.php';  
      } else { $body = "<h1>Email Inviata2</h1>";   }
      $mail->Body = $body; 
      $mail->AltBody = strip_tags($body);
        
      $mail->send();
      } catch (Exception $e) {
          echo 'Invio email fallito! Errore: ', $mail->ErrorInfo;
      }
}


} // CHIUDE CLASSE
