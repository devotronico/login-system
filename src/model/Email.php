<?php

  
class Email{


    protected $nameSender = 'Daniele Manzi';          // toMe - verify - newpass
    protected $emailSender = 'dmanzi83@gmail.com';    // toMe - verify - newpass    
    protected $nameRecipient;                         // toMe - verify 
    protected $emailRecipient;                        // toMe - verify - newpass


    public function __construct($name, $email){ 

        $this->nameSender = 'Daniele Manzi';
        $this->emailSender = 'dmanzi83@gmail.com';
        $this->nameRecipient =  $name;
        $this->emailRecipient = $email;
    }




} // CHIUDE CLASSE EMAIL







/*
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

        public static function toMe(array $data) {
            $obj = new static;
  
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
   
*/

    /*******************************************************************************|
    *    EMAIL INVIO [OUTLOOK]                                                      |
    ********************************************************************************/  
    /*
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
*/

/**************************************************************|
* VALIDATE EMAIL BASE                                          |
* fa una prima validificazione del 'email                      |
* Controlla: che non sia vuota e che abbia caratteri validi    |
****************************************************************/
/*
public function validateEmail()
{
$this->email = trim($this->email);
if (empty($this->email)) {
    $this->message .= "Il campo <strong>email</strong> è vuoto.<br>";
} 
else 
{
    // FILTER_SANITIZE_EMAIL
    // Rimuove tutti i caratteri eccetto le lettere, i numeri e !#$%&'*+-/=?^_`{|}~@.[]
    // ma lascia le virgolette singole ['] perciò non è sufficiente.
    $this->email = filter_var($this->email, FILTER_SANITIZE_EMAIL);
    if ($this->email === false) {
        $this->message .= "<strong>".$this->email."</strong> non è un email valida.<br>";
    }
    else{
        return $this->email;
    }
}
}  
*/



/*
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
*/


/*
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
*/