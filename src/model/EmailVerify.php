<?php
// https://github.com/PHPMailer/PHPMailer
require "Email.php";
require '../vendor/autoload.php'; //Load Composer's autoloader
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



class EmailVerify extends Email
{

    private $subject = 'Attivazione Account';
    private $buttonTpl = 'Attiva il tuo account';

    // variabili per il template/body dell' email
    private $template = 'email';
    public $site;
    public $titleTpl = 'Verifica il tuo indirizzo email';
    public $infoTpl = 'Per iniziare ad usare il tuo account devi confermare l\'indirizzo email';
    public $link;

    public function __construct(array $user){

        $name = $user['name'];
        $email = $user['email'];
        $hash = $user['hash'];

      //  die('{ "email": "'.$email.'" }');

        parent::__construct($name, $email);

        //$this->site = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST']; // https://www.danielemanzi.it/ ||| http://localhost:3000/
        $this->site = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST']; // "http://localhost/login-system/";
        $uri = "/login-system/src/controller/registration.php/"; //  http://localhost/login-system/src/controller/registration.php
        $this->link = $this->site.$uri."?email=".$email."&hash=".$hash; //http://localhost:3000/auth/verify/?email=dmanzi83@hotmail.it&hash=a597e50502f5ff68e3e25b9114205d4a
        // $this->link = $this->site.$route."?email=".$email."&hash=".$hash; //http://localhost:3000/auth/verify/?email=dmanzi83@hotmail.it&hash=a597e50502f5ff68e3e25b9114205d4a
        // $route = '/auth/signup/verify/';
        // http://localhost/login-system/src/controller/signup.phpsrc/controller/registration.php?email=dan@mail.it&hash=3621f1454cacf995530ea53652ddf8fb
    }





    /**
     * email che viene inviata in fase di registrazione dell' utente
     * oppure quando l' account dell' utente non è ancora stato attivato
     *
     * @param boolean $test
     * @return void
     */
    public function send(bool $test=true){

        $mail = new PHPMailer(true);                                          // Passing `true` enables exceptions
        try {
            //  MAILTRAP SMTP
            $mail->SMTPDebug = 0;                                               // Enable verbose debug output
            $mail->isSMTP();                                                    // Set mailer to use SMTP
            $mail->Host = $test ? 'smtp.mailtrap.io' : 'smtp.gmail.com';        // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                                             // Enable SMTP authentication
            $mail->Username = $test ? 'b34b7169adb122' : 'dmanzi83@gmail.com';  // dmanzi83@gmail.com   // SMTP username
            $mail->Password = $test ? '8d0c925142f07b' : '**********';          // mia password google  // SMTP password
            $mail->SMTPSecure = 'tls';                                          // Enable TLS encryption, `ssl` also accepted
            $mail->Port =  $test ? 465 : 587;
            //Recipients
            $mail->setFrom($this->emailSender, $this->nameSender);              // mittente email e nome
            $mail->addAddress($this->emailRecipient, $this->nameRecipient);     // destinatario email e nome
            //Content
            $mail->isHTML(true);                                                // Set email format to HTML
            $mail->Subject = $this->subject;                                    // Benvenuto in danielemanzi.it // Account su danielemanzi.it cancellato // Crea una nuova password

            if( file_exists("../view/".$this->template.".tpl.php") ) {
                $body = require '../view/'.$this->template.'.tpl.php';
            } else { $body = "<h1>Email Inviata2</h1>";   }
            $mail->Body = $body;                                                // $body = "<h1>Email Inviata</h1>";
            $mail->AltBody = strip_tags($body);

            $mail->send();
            } catch (Exception $e) {
                echo 'Invio email fallito! Errore: ', $mail->ErrorInfo;
            }
    }





} // CHIUDE CLASSE



/***************************|
*    EMAIL INVIO [MAILTRAP] |
****************************/
/*
public function send_(){

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
        if( file_exists("../view/".$this->template.".tpl.php") ) {
            $body = require '../view/'.$this->template.'.tpl.php';
        } else { $body = "<h1>Email Inviata2</h1>";   }
        $mail->Body = $body;
        $mail->AltBody = strip_tags($body);

        $mail->send();
        } catch (Exception $e) {
            echo 'Invio email fallito! Errore: ', $mail->ErrorInfo;
        }
}
*/




 /*******************************************************************************|
    *    EMAIL INVIO [GMAIL]    https://support.google.com/a/answer/176600?hl=it    |
    ********************************************************************************/
    /*
    public function sendZ(){
        $mail = new PHPMailer(true);
        try { //Server settings
        //  GMAIL SMTP (simple mail transfer protocol)
        $mail->SMTPDebug = 0;                       // Enable verbose debug output
        $mail->isSMTP();                            // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';             // Server di posta in uscita(SMTP)
        $mail->SMTPAuth = true;                     // Enable SMTP authentication
        $mail->Username = 'dmanzi83@gmail.com';     // SMTP username                            //[mailtrap: 'b34b7169adb122']
        $mail->Password = '**********';             // SMTP password                            //[mailtrap: '8d0c925142f07b']
        $mail->SMTPSecure = 'tls';                  // attiva 'tls' per porta '587' oppure `ssl` per porta '465'
        $mail->Port = 587;                          // TCP port to connect to                   //[mailtrap: 465]
        //Recipients
        $mail->setFrom($this->emailSender, $this->nameSender);          // mittente email e nome
        $mail->addAddress($this->emailRecipient, $this->nameRecipient); // destinatario email e nome
        //Content
        $mail->isHTML(true);
        $mail->Subject = $this->subject;
        $body = require 'layout/'.$this->template.'.tpl.php';  // 'layout\\'.$this->template.'.tpl.php';
        $mail->Body = $body;
        $mail->AltBody = strip_tags($body);
        $mail->send();
        } catch (Exception $e) {
            echo 'Invio email fallito! Errore: ', $mail->ErrorInfo;
        }
    }
*/
