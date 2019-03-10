<?php
if(session_status() === PHP_SESSION_NONE) session_start();
/*

if ( count($_COOKIE) ) { echo "ci sono " .count($_COOKIE). " cookie"; } else { echo "0"; } // 0
echo "<br>";
if(filter_has_var(INPUT_COOKIE, 'id')) {  echo "cookie id: ".$_COOKIE["id"]; } else { echo "nessun cookie id"; } // 0
echo "<br>";
if ( count($_SESSION) ) { echo "L' array SESSION è attivo"; } else {  echo "L' array SESSION NON è attivo"; }
echo "<br>";
echo "<pre>";print_r($_SESSION);echo "</pre>"; // array vuoto
if ( isset($_SESSION["id"]) )  {  echo "session id: ".$_SESSION["id"]; } else { echo "nessun session id"; } // 0
*/


if(!filter_has_var(INPUT_COOKIE, 'id')){

    // Se è stato cliccato sul link contenuto nel email
    if(filter_has_var(INPUT_GET, 'email') && filter_has_var(INPUT_GET, 'hash') ){

        $email = $_GET["email"];
        $hash = $_GET["hash"];

        /**
         * SIGNUP VERIFY     metodo = GET   route = auth/signup/verify    COOKIE
         * Quando all'interno della Mail clicchiamo il link verremo indirizzati di nuovo sul sito per
         * verificare se i parametri del link siano validi e se l'account non era già stato attivato.
         * Se è andato tutto bene verremo loggati
         */
        function signupVerify($email, $hash){


            if( !file_exists("../../config/db.php") ) {die('{ "page": "'.$page.'", "status": "bug", "bug": "php", "message": "Errore: file db.php non trovato" }');}
            require "../../config/db.php";

            if( !file_exists("../model/EmailLink.php") ) {die('{ "page": "'.$page.'", "status": "bug", "bug": "php", "message": "Errore: file EmailLink.php non trovato" }');}
            require "../model/EmailLink.php";

            if (!class_exists("EmailLink")) {die('{ "page": "'.$page.'", "status": "bug", "bug": "php", "message": "Errore: classe EmailLink non trovata" }');}

            $EmailLink = new EmailLink($mysqli, $email, $hash);
            $data = $EmailLink->accountActivation();
            header("Location: /login-system/index.php?result=".$data["result"]."&message=".$data["message"]); die;
        }

        if( !file_exists("../helper/Validation.php") ) {  die('{ "status": "error", "error": "Errore: il file Validation.php non trovato" }'); }

        require "../helper/Validation.php";

        if (!class_exists("Validation")) {die('{ "page": "'.$page.'", "status": "bug", "bug": "php", "message": "Errore: classe Validation non trovata" }');}

        $validation = new Validation($page, ["email" => $email, "hash" => $hash]);

        if ($validation->validate()) {

            signupVerify($email, $hash);

            // if ( !isset( $_SESSION['id'] ) ) {  header("Location: index.html"); die;}
        }

    } else {
        // header("Location: login.html");
        // die;
    }
}




/*
if ( $_GET["email"] && $_GET["hash"] ) {

}*/
// $message = "ciao"; die($message);
    // die('{ "status": "error", "error": "variabile GET  con indice signup non trovata"}');



 /*


 $obj = json_decode($str); // echo '<pre>';var_dump( $obj ); die;// object(stdClass)

 $name = $obj->name;
 $email = $obj->mail;
 $password = $obj->pass;


   <p id="message-registration" style="display:<?= isset($messageRegistration) ? 'block' : 'none' ?>"><?=$messageRegistration?></p>
 */

?>
