<?php
namespace App\Models;
use \PDO;
class EmailLink
{
    private $conn;
    private $message;
    private $email;
    private $hash; 
    public function __construct(PDO $conn, $email, $hash)
    {
        $this->conn = $conn;
        $this->email = $this->isEmailStored($email);
        $this->hash =  $this->isHashStored($hash);    
    }

/***************************************************************************************************************************|
 * Email ACTIVATION      [set cookie]    SIGNUP                                                                             |
 * Quando  nell'email clicchiamo sul link di conferma per attivare l'account presente verremo indirizzati di nuovo sul sito |
 * Il link contiene le variabili/parametri $_GET['email'] e $_GET['hash']                                                   |
 * Dopo aver validato la email e la hash che sono stati passati dall'url col metodo GET                                     |
 * Controlliamo se corrispondo ai valori presenti nella tabella 'users' del database                                        |
 * Se sono uguali allora settiamo le variabili globali SESSION e COOKIE                                                     |
 * Poi facciamo un controllo sul campo 'user_status'                                                                        |
 * Se il valore di 'user_status' è uguale a 0:                                                                              |
 *  cambiamo il suo valore in 1. il valore 1 sta a indicare che la registrazione al sito è completa.                        |
 * Se il valore di 'user_status' è uguale a 1:                                                                              |
 *  lasciamo il suo valore in 1. vuol dire che questo account era già stato attivato precedentemente                        |                                                    
 ***************************************************************************************************************************/
public function accountActivation()
{     
        $sql = "SELECT ID, user_type, user_name, activation_key, user_status FROM users WHERE email = :email";
        if ($stmt = $this->conn->prepare($sql)) 
        {
            $stmt->bindParam(':email', $this->email, PDO::PARAM_STR, 32);
            if ($stmt->execute()) 
            {
                if ($stmt->rowCount() == 1) { 
                 
                    $user = $stmt->fetch(PDO::FETCH_ASSOC); 
                    if ( $user['activation_key'] === $this->hash ) {
                        die ( $user['activation_key'].'  '.$this->hash );
                        $_SESSION['user_id'] = $user['ID'];
                        $_SESSION['user_type'] = $user['user_type'];
                        $_SESSION['user_name'] = $user['user_name'];
                        setcookie("user_id", $user['ID'], time()+3600, '/');
                        if ( $user['user_status'] == 0 ) {
                            $sql = "UPDATE users SET user_status = 1 WHERE email = :email";
                            if ($stmt = $this->conn->prepare($sql)) 
                            {
                                $stmt->bindParam(':email', $this->email, PDO::PARAM_STR, 32);
                           
                                $this->message = $stmt->execute() ? '' : "Qualcosa è andato storto. Per favore prova più tardi.";
                            } else { $this->message = "Qualcosa è andato storto. Per favore prova più tardi.";}
                        }
                        else {  $this->message = 'Questo account è già stato attivato';}
                    } else { $this->message = "Il parametro hash è errato";} 
                } else { $this->message = "Il parametro email è errato";} 
            } else { $this->message = "Qualcosa è andato storto. Per favore prova più tardi.";}
        } else { $this->message = "Qualcosa è andato storto. Per favore prova più tardi.";}
        $stmt = null;
        $this->conn = null; 
}
/***************************************************************************************************************************|
 * EMAIL LINK                                  PASSWORD                                                                     |
 * Quando  nell'email clicchiamo sul link di conferma per attivare l'account presente verremo indirizzati di nuovo sul sito |
 * Il link contiene le variabili/parametri $_GET['email'] e $_GET['hash']                                                   |
 * Dopo aver validato la email e la hash che sono stati passati dall'url col metodo GET                                     |
 * Controlliamo se corrispondo ai valori presenti nella tabella 'users' del database                                        |
 * Se sono uguali allora facciamo un controllo sul campo 'user_status'                                                      |
 * Se il valore di 'user_status' è uguale a 0:                                                                              |
 *  cambiamo il suo valore in 1. il valore 1 sta a indicare che la registrazione al sito è completa.                        |
 * Se il valore di 'user_status' è uguale a 1:                                                                              |
 *  lasciamo il suo valore in 1. vuol dire che questo account era già stato attivato precedentemente                        |                                                    
 ***************************************************************************************************************************/
public function linkNewPass()
{
    if (!empty($this->message)) {exit;}
      
        $email = $this->email;  
        $hash = $this->hash; 
        $sql = "SELECT activation_key, user_status FROM users WHERE email = :email";
        if ($stmt = $this->conn->prepare($sql)) 
        {
            $stmt->bindParam(':email', $this->email, PDO::PARAM_STR, 32);
          
            if ($stmt->execute()) 
            {
                if ($stmt->rowCount() == 1) 
                { 
                    $user = $stmt->fetch(PDO::FETCH_ASSOC); 
                    if ( $user['activation_key'] === $this->hash ) 
                    {
                        if ( $user['user_status'] == 0 ) {
                            $sql = "UPDATE users SET user_status = 1 WHERE email = :email";
                            if ($stmt = $this->conn->prepare($sql)) 
                            {
                                $stmt->bindParam(':email', $this->email, PDO::PARAM_STR, 32);
                
                                $this->message .= $stmt->execute() ? '' : "Qualcosa è andato storto. Per favore prova più tardi.";
                            } else { $this->message .= "Qualcosa è andato storto. Per favore prova più tardi.";}
                        } // else { $this->message .= '';}
                    } else { $this->message = "Il parametro hash è errato";}        
                } else { $this->message = "Il parametro email è errato";} 
            } else { $this->message .= "Qualcosa è andato storto. Per favore prova più tardi.";}
        } else { $this->message .= "Qualcosa è andato storto. Per favore prova più tardi.";}
        $stmt = null;
        $this->conn = null; 
}
/*****************************************VALIDAZIONI*******************************************************************************/
   
    /*******************************************************************************************************|
     * IS EMAIL STORED                                                                                      |
     * Controlla se l'email è già presente nel database                                                     |
     * Se lo è, allora la ritorna e viene prelevato anche il valore dell' hash corrispondete a questa email |
     *******************************************************************************************************/
    private function isEmailStored($email) 
    {
        $sql = "SELECT activation_key FROM users WHERE email = :email";
        if ($stmt = $this->conn->prepare($sql)) // Prepariamo lo Statement
        { 
            $stmt->bindParam(':email', $email, PDO::PARAM_STR, 32);
            if ($stmt->execute()) // Tentiamo di eseguire lo statement
            {
                if ($stmt->rowCount() == 1) {
                    $user = [];
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    $this->hash = $user['activation_key']; 
                    
                    return $email; 
                } else {
                  
                    die('{ "status": "error", "error": "L\' email <strong>'.$email.'</strong> non è stata ancora registrata." }');
                }
            } else {
               
                die('{ "status": "error", "error": "Qualcosa è andato storto. Per favore prova più tardi." }');
            }
        } else {
            
            die('{ "status": "error", "error": "Qualcosa è andato storto. Per favore prova più tardi." }');
        }
        $stmt = null; 
    }
    
    /*******************************************************************************************************|
     * IS HASH STORED                                                                                       |
     * Controlla se l' hash è già presente nel database                                                     |
     * Se lo è, allora la ritorna                                                                           |
     *******************************************************************************************************/
    private function isHashStored($hash) 
    {
        $sql = "SELECT activation_key FROM users WHERE activation_key = :hash";
        if ($stmt = $this->conn->prepare($sql)) 
        { 
            $stmt->bindParam(':hash', $hash, PDO::PARAM_STR, 32);
            if ($stmt->execute()) 
            {
                if ($stmt->rowCount() == 1) {
                    $user = [];
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
                    $stmt = null; 
                    return $user['activation_key']; 
                } else {
                  
                    die('{ "status": "error", "error": "Questa hash <strong>'.$hash.'</strong> non è presente nel database." }');
                }
            } else {
                
                die('{ "status": "error", "error": "Qualcosa è andato storto. Per favore prova più tardi." }');
            }
        } else {
            
            die('{ "status": "error", "error": "Qualcosa è andato storto. Per favore prova più tardi." }');
        }
        $stmt = null;
    }




} // Chiude la classe EmailLink