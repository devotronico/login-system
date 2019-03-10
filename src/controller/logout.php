<?php
if (!isset($_POST)) {header("Location: index.php");die;}

header( "Content-type: application/json" );

if (!filter_has_var(INPUT_POST, 'logout')) { die('{ "page": "logout", "status": "bug", "bug": "POST", "message": "variabile POST con indice logout non trovata" }'); }

define("PAGE", key($_POST));

$file = basename(__FILE__); // DEBUG

$str = $_POST[PAGE];

$obj = json_decode($str); // echo '<pre>';var_dump( $obj ); die;// object(stdClass)

$email = $obj->mail;


// die('{ "page": "'.PAGE.'", "status": "test", "test": "php", "message": "file ' . $file . ' - linea: ' . __LINE__ . '" }'); // DEBUG


/**
 * PHP_SESSION_DISABLED if sessions are disabled.
 * PHP_SESSION_NONE if sessions are enabled, but none exists.
 * PHP_SESSION_ACTIVE if sessions are enabled, and one exists.
 *
 * LOGOUT    metodo = GET    route = auth/logout
 * distruggiamo l'id della sessione e il valore di $_SESSION["user_id"] e $_SESSION["user_type"]
 * e distruggiamo il COOKIE
 * @return void
 */
function logout(){

    if(session_status() === PHP_SESSION_NONE) session_start();
    $_SESSION = array();
    session_unset();
    session_destroy();
    //if(session_status() !== PHP_SESSION_DISABLED) { die('{ "page": "'.PAGE.'", "status": "bug", "bug": "session", "message": "Errore: PHP_SESSION_DISABLED è false" }'); }
    if(session_status() !== PHP_SESSION_NONE) { die('{ "page": "'.PAGE.'", "status": "bug", "bug": "session", "message": "Errore: PHP_SESSION_NONE è false" }'); }
    if(session_status() === PHP_SESSION_ACTIVE) { die('{ "page": "'.PAGE.'", "status": "bug", "bug": "session", "message": "Errore: PHP_SESSION_ACTIVE è true" }'); }

    die('{ "page": "'.PAGE.'", "status": "success", "success": "'.PAGE.'", "message": "logout avvenuto con successo" }');





    //setcookie("user_id", null);
    //setcookie("user_id", null, time()-3600, '/');
}


logout();



