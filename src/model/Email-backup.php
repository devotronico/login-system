<?php
namespace App\Models;
require 'vendor/autoload.php'; //Load Composer's autoloader
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 
  
class Email{
    private $email; 
    private $name;
    private $emailSender; 
    private $nameSender;
    private $emailRecipient; 
    private $nameRecipient;
    private $surnameSender;
    private $telSender;
    private $template;
    private $site;
    private $link;
    private $subject;
    private $titleTpl; 
    private $infoTpl;
    private $buttonTpl;
//  activeStatus  |   signup  |   newpass     |   contact
    public function __construct(){ 
      
      
        $this->site = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST']; // https://www.danielemanzi.it/ ||| http://localhost:3000/
    }
        public static function toMe(array $data) {
            $obj = new static;
  
          //  $obj->name = nameValidetion($data['nome']);  // !empty($_POST['nome'])?$_POST['nome']:'senza nome'; 
          //  $obj->surname = nameValidetion($data['cognome']); // !empty($_POST['cognome'])?$_POST['cognome']:'senza cognome';  // $_POST['cognome']; 
          //  $obj->telephone =  telValidetion($data['tel']); //!empty($_POST['tel'])?$_POST['tel']:'senza tel'; //  $_POST['tel']; 
          //  $obj->email = $data['email'];
          //  $obj->body =  $data['testo'];
            $obj->nameSender = $data['nome'];
            $obj->emailSender =  $data['email'];
            $obj->surnameSender = $data['cognome']; 
            $obj->telSender = $data['tel']; 
            $obj->nameRecipient = 'Daniele Manzi';
            $obj->emailRecipient = 'dmanzi83@hotmail.it';
            
            $obj->subject = 'Info';
            $obj->template = 'emailToMe'; 
            $obj->infoTpl = $data['testo'];
            $obj->titleTpl = 'Ciao Daniele sei stato contattato da un visitatore dal tuo sito internet'; 
       
            return $obj;
        }
        public static function verify($email, $hash, $name='utente') {        // SIGNUP   ($email, $hash, $name);  // Verifica account
            $obj = new static;
            $obj->nameSender = 'Daniele Manzi';
            $obj->emailSender = 'dmanzi83@gmail.com';
            $obj->nameRecipient =  $name;
            $obj->emailRecipient = $email;
     
            $obj->template = 'emailAuth'; 
        
            $obj->subject = 'Registrazione';
            $obj->titleTpl = 'Verifica il tuo indirizzo email'; 
            $obj->infoTpl = 'Per iniziare ad usare il tuo account devi confermare l\'indirizzo email';
            $obj->buttonTpl = 'Verifica indirizzo email';
            $route = '/auth/signup/verify/';
            $obj->link = $obj->site.$route."?email=".$email."&hash=".$hash; //http://localhost:3000/auth/verify/?email=dmanzi83@hotmail.it&hash=a597e50502f5ff68e3e25b9114205d4a
            return $obj;
        }
   
        public static function newpass($email, $hash) {   // PASSWORD RESET ($email, $hash, 'newpass')
            $obj = new static;
  
            $obj->nameSender = 'Daniele Manzi';
            $obj->emailSender = 'dmanzi83@gmail.com';
            $obj->emailRecipient = $email;
         
            $obj->template = 'emailAuth'; 
         
            $route = '/auth/password/new/';
            $obj->subject = 'Nuova password';
            $obj->titleTpl = 'Crea una nuova password'; 
            $obj->infoTpl = 'Per creare una nuova password clicca sul bottone nuova password';
            $obj->buttonTpl = 'Nuova password';
            $obj->link = $obj->site.$route."?email=".$email."&hash=".$hash; //http://localhost:3000/auth/verify/?email=dmanzi83@hotmail.it&hash=a597e50502f5ff68e3e25b9114205d4a
            return $obj;
        }
  
    /*******************************************************************************|
    *    EMAIL INVIO [ARUBA]    https://support.google.com/a/answer/176600?hl=it    |
    ********************************************************************************/  
    public function sendY(){
        $mail = new PHPMailer(true);                  
        try { //Server settings
        //   SMTP (simple mail transfer protocol)
        $mail->SMTPDebug = 0;                       // Enable verbose debug output
        $mail->isSMTP();                            // Set mailer to use SMTP
        $mail->Host = 'smtps.aruba.it';      // Server di posta in uscita(SMTP)    //[mailtrap: 'smtp.mailtrap.io']  
        $mail->SMTPAuth = true;                     // Enable SMTP authentication
        $mail->Username = 'postmaster@danielemanzi.it';    // SMTP username                            //[mailtrap: 'b34b7169adb122'] 
        $mail->Password = 'Br0l1D0m1n483';          // SMTP password                            //[mailtrap: '8d0c925142f07b'] 
        $mail->SMTPSecure = 'ssl';             // attiva 'tls' per porta '587' oppure `ssl` per porta '465'
        $mail->Port = 465;                          // TCP port to connect to                   //[mailtrap: 465] 
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
            die ('Invio email fallito! Errore: '. $mail->ErrorInfo);
        }
    }
    /*******************************************************************************|
    *    EMAIL INVIO [OUTLOOK]                                                      |
    ********************************************************************************/  
    public function send(){
        $mail = new PHPMailer(true);                  
        try { //Server settings
        //   SMTP (simple mail transfer protocol)
        $mail->SMTPDebug = 0;                       // Enable verbose debug output
        $mail->isSMTP();                            // Set mailer to use SMTP
        $mail->Host = 'smtp-mail.outlook.com';      // Server di posta in uscita(SMTP)    //[mailtrap: 'smtp.mailtrap.io']  
        $mail->SMTPAuth = true;                     // Enable SMTP authentication
        $mail->Username = 'dmanzi83@hotmail.it';    // SMTP username                            //[mailtrap: 'b34b7169adb122'] 
        $mail->Password = 'Broliregna.83';          // SMTP password                            //[mailtrap: '8d0c925142f07b'] 
        $mail->SMTPSecure = 'tls';   //STARTTLS          // attiva 'tls' per porta '587' oppure `ssl` per porta '465'
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
            die ('Invio email fallito! Errore: '. $mail->ErrorInfo);
        }
    }
    
    
    /*******************************************************************************|
    *    EMAIL INVIO [GMAIL]    https://support.google.com/a/answer/176600?hl=it    |
    ********************************************************************************/  
    public function sendZ(){
        $mail = new PHPMailer(true);                  
        try { //Server settings
        //  GMAIL SMTP (simple mail transfer protocol)
        $mail->SMTPDebug = 0;                       // Enable verbose debug output
        $mail->isSMTP();                            // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';             // Server di posta in uscita(SMTP)    //[mailtrap: 'smtp.mailtrap.io']  
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
    
    
/***************************|
*    EMAIL INVIO [MAILTRAP] |           
****************************/  
public function sendT(){
    
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
public function nameValidetion($str) {
    if ( !empty($str) ) {
        if (preg_match('/^[a-zA-Z]{32}$/', $str)) {
            return $str;
        } else {
            return 'nome invalido!'; 
        }
    } else {
        return 'senza nome';
    }
}
public function telValidetion($num) {
    if ( !empty($num) ) {
        if (preg_match('/^[0-9]{15}$/', $num)) {
            return $num;
        } else {
            return 'numero di telefono invalido!'; 
        }
    } else {
        return 'senza telefono';
    }
}
/**************************************************************|
* VALIDATE EMAIL BASE                                          |
* fa una prima validificazione del 'email                      |
* Controlla: che non sia vuota e che abbia caratteri validi    |
****************************************************************/
public function validateEmail()
{
$this->email = trim($this->email);
if (empty($this->email)) {
    $this->message .= "Il campo <strong>email</strong> è vuoto.<br>";
} 
else 
{
    /* FILTER_SANITIZE_EMAIL
    Rimuove tutti i caratteri eccetto le lettere, i numeri e !#$%&'*+-/=?^_`{|}~@.[]
    ma lascia le virgolette singole ['] perciò non è sufficiente.*/
    $this->email = filter_var($this->email, FILTER_SANITIZE_EMAIL);
    if ($this->email === false) {
        $this->message .= "<strong>".$this->email."</strong> non è un email valida.<br>";
    }
    else{
        return $this->email;
    }
}
}  
}
