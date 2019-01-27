<?php
if ( !isset($_POST) ) { header("Location: index.php"); die; } 

header( "Content-type: application/json" );


if(!filter_has_var(INPUT_POST, 'emailcheck')){ die('{ "status": "error", "error": "variabile POST con indice signup non trovata"}'); }



$str = $_POST["emailcheck"];

$obj = json_decode($str); // echo '<pre>';var_dump( $obj ); die;// object(stdClass)


$email = $obj->mail;

require "model/Validation.php";


if (  Validation::validateEmail($email) ){

    $hash = getHashFromEmail($email);
    // TODO: invia email 
}


/**
 * GET HASH FROM EMAIL ì   
 * Controlla se l'email è già presente nel database    
 * Se lo è, allora viene prelevato il valore dell' hash corrispondete a questa email      
 */ 
function getHashFromEmail($email) 
{
    $sql = "SELECT hash FROM users WHERE email = ?";

    if ($stmt = $this->conn->prepare($sql)) {  // Prepariamo lo Statement
    
        $stmt->bind_param('s', $param );

        $param = $email;

        if ( !$stmt->execute() ) {  die('{ "status": "error", "error": "Errore: execute in isEmailStored" }'); }

        $result = $stmt->get_result();

        if($result->num_rows === 1) {

            $user = $result->fetch_object();
                
            return $user->hash;

        } else {
            
            die('{ "status": "error", "error": "L\' email <strong>'.$email.'</strong> non è stata ancora registrata." }');
        }
        
    } else {
        
        die('{ "status": "error", "error": "Errore: prepare in isEmailStored" }');
    }
    $stmt = null; 
}
    





/***********************************************************************************************|
 * SEND EMAIL                                                                                   |
 * Dopo aver inserito la mail nel campo input e premuto il bottone si attiverà questo metodo    |
 * Dopo la validazione dell' email e ottenuto l'hash corrispondete dal database                 |
 * il sistema ci invierà una mail per creare una nuova password                                 |
 * La mail conterrà un link con la rotta '/auth/password/new/'                                  |
 ***********************************************************************************************/
function sendEmail() {
 
    if ( !empty($this->email) && !empty($this->hash) ) {  // se email e password sono corretti 
      
        $Email = Email::newpass($this->email, $this->hash);
        $Email->send();
    }
}