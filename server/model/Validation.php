<?php

class Validation {

    private $email;
    private $password;

    // public function __construct($email, $password){
    public function __construct(){

    //    $this->email = $email;
      //  $this->password = $password;

    }



 /**
 * VALIDATE EMAIL BASE   
 * 
 * varie espressioni regolari per validare l' email ma nessuna di esse include tutte le varianti di email al mondo:
 * [1] /^([a-zA-Z0-9\.\-]+)@([a-zA-Z0-9\.\-]+)\.([a-z]{2,20})(.[a-z]{2,8})?$/
 * [2] /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/
 * [3] /^[-!#$%&'+/0-9=_A^AZ-z{|}?~].?!(\[-#$%&'?+/0-9= _A^AZ-z{|}~])*@[a-zA-Z](-?[a-zA-Z0-9])*(\.[a-zA-Z](-?[a-zA-Z0 -9])*)+$/
 *
 * link utiliù:
 * https://stackoverflow.com/questions/2049502/what-characters-are-allowed-in-an-email-address
 * https://en.wikipedia.org/wiki/Email_address#Local-part
 * https://stackoverflow.com/questions/201323/how-to-validate-an-email-address-using-a-regular-expression
 * 
 * Local-part, ovvero PRIMA della chiocciola sono consentiti i caratteri:
 * [1]: da 'A' a 'Z', da 'a' a 'z', da '0' a '9'
 * [2]: i caratteri speciali: !#$%&'*+-/=?^_`{|}~;
 *      Il punto., a condizione che non sia il primo o l'ultimo carattere se non quotato,
 *      e purché non appaia consecutivamente a meno che non sia quotato
 *      (ad es. John..Doe@mail.com non è permesso ma "John..Doe"@mail.com è permesso);
 * [3]: spazio e caratteri: "(),:; <> @ [\] sono consentiti con restrizioni
 *      (sono consentiti solo all'interno di una stringa quotata, come descritto nel paragrafo seguente, 
 *      e inoltre, una barra rovesciata o una virgoletta deve essere preceduta da una barra rovesciata);
 * 
 * Domain, ovvero DOPO la chiocciola sono consentiti i caratteri:
 * [1]: da 'A' a 'Z', da 'a' a 'z', da '0' a '9'
 * [2]: e il trattino (-)
 * [3]: NON possano iniziare con una cifra o con un trattino e non devono terminare con un trattino.
 *      Non sono consentiti altri simboli, caratteri di punteggiatura o spazi vuoti.
 * 
 * DESCRIZIONE FUNZIONE:
 * fa una prima validificazione del 'email   
 * Controlla: che non sia vuota e che abbia caratteri validi    
 * FILTER_SANITIZE_EMAIL     
 * Rimuove tutti i caratteri eccetto le lettere, i numeri e i caratteri !#$%&'*+-/=?^_`{|}~@.[]  
 * Non sono considerate valide le email con i caratteri "\<>  
 * ma lascia le virgolette singole ['] perciò non è sufficiente.       
 * Se l'email contiene il carattere '/' verrà ritenuta valida ma il carattere '/' verrà rimosso 
 * HTML5 non considera valide le email con i caratteri: 
 * prima e dopo la chiocciola  @()[]:<>\"   
 * prima della chiocciola      @()[]:<>\"        
 * dopo la chiocciola          @$%&'*+/=?^_`{|}~()[]:<>\"     
 */
public static function validateEmail($email)
{
    $email = trim($email);
    if ( empty($email) ) {
       
        die('{ "status": "error", "error": "Il campo email è vuoto." }');
    } 
    else 
    {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL); // sanitized_email
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
           
            return true;
        }
        else{

            die('{ "status": "error", "error":  "'.$email.' non è un email valida." }');
        }
    }
}  







/**
 * VALIDATE PASSWORD
 * Se presenti vengono eliminati gli spazi prima e dopo la password
 * Controlla se il valore della password è vuoto, ovvero se la password è stata digitata dall' utente
 * Controlla la lunghezza della password
 */
public static function validatePassword($password)
    {
        $PASSWORD_LENGTH = 4; 
        $password = trim($password);
        if (empty($password)) {
           
            die('{ "status": "error", "error": "Il campo password è vuoto." }');
        } else if (strlen($password) < $PASSWORD_LENGTH) {
          
            die('{ "status": "error", "error": "La password deve avere almeno '.$PASSWORD_LENGTH.' caratteri." }');
        } else {
            return true;
        }
    }




/**
 * VALIDATE NAME
 * fa la validazione al nome dell' utente
 * TO-DO: validare anche i simboli: ' "
 * $illegal = "#$%^&*()+=-[]';,./{}|:<>?~";
 * echo (false === strpbrk($YourCsvVarible, $illegal)) ? 'Allowed' : "Disallowed";
 * $illegal = "€#$%^&*()+=-[]';,./{}|:<>?~";
 * $illegal = \€\#\$\%\^\&\*\(\)\+\=\-\[\]\'\;\,\.\/\{\}\|\:\<\>\?\~
 */
public function validateName($name) {
    if ( empty($name) ) {  die('{ "status": "error", "error": "Il campo nome è vuoto." }'); }

    $illegal = "@[\€\#\$\%\^\&\*\(\)\+\=\-\[\]\'\;\,\.\/\{\}\|\:\<\>\?\~]@";
    if ( preg_match($illegal, $name, $matches) ) {  die('{ "status": "error", "error": "Il carettere '.$matches[0].' non è valido" }'); }
    // if ( preg_match($illegal, $name, $matches) ) {  die('{ "status": "error", "error": "Il carettere  non è valido" }'); }
    return $name;
    //  die('{ "status": "error", "error": "Il carettere '.$matches[0].' non è valido" }');
}




    /**
     * VALIDATE HASH [metodo GET]
     * Controlla la validità del codice hash che proviene dall' email che si è inviato
     * all' utente durante la fase di registrazione del suo account
     * Controlla se sono validi i caratteri che compongono l' hash che otteniamo dall' url
     */
    public function validateHash($hash)
    {
        if (preg_match('/^[a-f0-9]{32}$/', $hash)) {
            return $hash;
        } else {
            $this->message .= "il parametro hash non è valido";
        }
    }


/**
 * VALIDATE PHONE
 * Controlla se il numero di telefono immesso
 * dall' utente sia valido
 */
public function validatePhone($num) {
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



} // CHIUDE CLASSE