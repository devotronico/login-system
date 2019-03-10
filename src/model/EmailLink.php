<?php

class EmailLink
{
    private $conn;
    private $email;
    private $hash;

    public function __construct($conn, $email, $hash)
    {

        $this->conn = $conn;
        $this->email = $this->isEmailStored($email);
        $this->hash =  $this->isHashStored($hash);
    }



/**
 * ACCOUNT ACTIVATION
 * Email ACTIVATION      [set cookie]    SIGNUP
 * Quando  nell'email clicchiamo sul link di conferma per attivare l'account presente verremo indirizzati di nuovo sul sito.
 * Il link contiene le variabili/parametri $_GET['email'] e $_GET['hash']
 * Dopo aver validato la email e la hash che sono stati passati dall'url col metodo GET
 * Controlliamo se corrispondo ai valori presenti nella tabella `users` del database
 * e se entrambi i valori sono presenti sulla stessa riga della tabella `users`
 * Se sono uguali allora settiamo le variabili globali SESSION e COOKIE
 * Poi facciamo un controllo sul campo 'verified'
 * Se il valore di 'verified' è uguale a 0:
 * cambiamo il suo valore in 1. il valore 1 sta a indicare che la registrazione al sito è completa.
 * Se il valore di 'verified' è uguale a 1:
 *  lasciamo il suo valore in 1. vuol dire che questo account era già stato attivato precedentemente
 */
public function accountActivation(){

        $sql = "SELECT id, name, email, verified FROM users WHERE email = ? AND hash = ?";

        if ($stmt = $this->conn->prepare($sql)) {

            $stmt->bind_param('ss', $param1, $param2 );

            $param1 = $this->email;
            $param2 = $this->hash;

            if ( !$stmt->execute() ) { ["result"=>"danger", "message"=>"execute in accountActivation"]; }

            $result = $stmt->get_result();

            if( $result->num_rows === 1 ) {

                $user = $result->fetch_object();

                $_SESSION['id'] = $user->id;
                $_SESSION['name'] = $user->name;
                $_SESSION['email'] = $user->email;
                //setcookie("id", $user['id'], time()+3600, '/');

                if ( $user->verified !== 0 ) { return ["result"=>"warning", "message"=>"Questo account è già stato attivato da te"]; }

                $sql = "UPDATE users SET verified = 1 WHERE id = ".$user->id;

                if (!$stmt = $this->conn->prepare($sql)) { return ["result"=>"danger", "message"=>"prepare in accountActivation"]; }

                if ( !$stmt->execute() ) {  return ["result"=>"danger", "message"=>"execute in accountActivation"]; }

              //  return "L' account è stato attivato";

                return ["result"=>"success", "message"=>"Complimenti il tuo account è stato attivato"];

                // return "L' account con id: ".$_SESSION["id"]." dell'utente ".$_SESSION["name"]." è stato attivato";
                //return "Complimenti <strong>".$_SESSION['name']."</strong> la tua registrazione è avvenuta con successo!"";
            } else {  return ["result"=>"warning", "message"=>"email e hash non corrispondono"]; }

        } else { return ["result"=>"danger", "message"=>"prepare in accountActivation"]; }
        $stmt = null;
        $this->conn = null;
}

/*****************************************VALIDAZIONI*******************************************************************************/

    /**
     * IS EMAIL STORED
     * Controlla se l'email è già presente nel database
     *  Se lo è, allora la ritorna e viene prelevato anche il valore dell' hash corrispondete a questa email
     */
    private function isEmailStored($email)
    {
        $sql = "SELECT email FROM users WHERE email = ?";

        if ($stmt = $this->conn->prepare($sql)) {  // Prepariamo lo Statement

            $stmt->bind_param('s', $param );

            $param = $email;

            if ( !$stmt->execute() ) { die('{ "page": "'.$page.'", "status": "error", "error": "mysqli", "message": "Errore: execute" }'); }

            $result = $stmt->get_result();

            if($result->num_rows === 1) {

                return $email;
            } else {

                die('{ "status": "error", "error": "L\' email <strong>'.$email.'</strong> non è stata ancora registrata." }');
            }

        } else {

            die('{ "status": "error", "error": "Errore: prepare in isEmailStored" }');
        }
        $stmt = null;
    }



    /**
     * IS HASH STORED
     * Controlla se l' hash è già presente nel database
     * Se lo è, allora la ritorna
     */
    private function isHashStored($hash)
    {
        $sql = "SELECT hash FROM users WHERE hash = ?";

        if ($stmt = $this->conn->prepare($sql)) {

            $stmt->bind_param('s', $param );

            $param = $hash;

            if ( !$stmt->execute() ) {  die('{ "status": "error", "error": "Errore: execute in isHashStored" }'); }

            $result = $stmt->get_result();

            if( $result->num_rows === 1) {

                return $hash;
            } else {

                die('{ "status": "error", "error": "Questa hash <strong>'.$hash.'</strong> non è presente nel database." }');
            }
    } else {

        die('{ "status": "error", "error": "Errore: prepare in isHashStored" }');
    }

        $stmt = null;
    }







/***************************************************************************************************************************|
 * EMAIL LINK                                  PASSWORD                                                                     |
 * Quando  nell'email clicchiamo sul link di conferma per attivare l'account presente verremo indirizzati di nuovo sul sito |
 * Il link contiene le variabili/parametri $_GET['email'] e $_GET['hash']                                                   |
 * Dopo aver validato la email e la hash che sono stati passati dall'url col metodo GET                                     |
 * Controlliamo se corrispondo ai valori presenti nella tabella 'users' del database                                        |
 * Se sono uguali allora facciamo un controllo sul campo 'verified'                                                      |
 * Se il valore di 'verified' è uguale a 0:                                                                              |
 *  cambiamo il suo valore in 1. il valore 1 sta a indicare che la registrazione al sito è completa.                        |
 * Se il valore di 'verified' è uguale a 1:                                                                              |
 *  lasciamo il suo valore in 1. vuol dire che questo account era già stato attivato precedentemente                        |
 ***************************************************************************************************************************/
public function linkNewPass()
{
    if (!empty($this->message)) {exit;}

        $email = $this->email;
        $hash = $this->hash;
        $sql = "SELECT hash, verified FROM users WHERE email = :email";
        if ($stmt = $this->conn->prepare($sql))
        {
            $stmt->bindParam(':email', $this->email, PDO::PARAM_STR, 32);

            if ($stmt->execute())
            {
                if ($stmt->rowCount() == 1)
                {
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ( $user['hash'] === $this->hash )
                    {
                        if ( $user['verified'] == 0 ) {
                            $sql = "UPDATE users SET verified = 1 WHERE email = :email";
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



} // Chiude la classe EmailLink