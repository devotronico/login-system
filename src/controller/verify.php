<?php
if (!isset($_POST)) {header("Location: index.php");die;}

header( "Content-type: application/json" );

if (!filter_has_var(INPUT_POST, 'verify')) { die('{ "page": "verify", "status": "bug", "bug": "POST", "message": "variabile POST con indice verify non trovata" }'); }

$page = key($_POST);

// $file = basename(__FILE__); // DEBUG
// die('{ "page": "'.$page.'" }');
// die('{ "page": "signin", "status": "test", "test": "php" }'); // DEBUG
// die('{ "page": "'.$page.'", "status": "test", "test": "php", "message": "file ' . $file . ' - linea: ' . __LINE__ . '" }'); // DEBUG

$str = $_POST["verify"];



if (!file_exists("../helper/Validation.php")) { die('{ "page": "'.$page.'", "status": "bug", "bug": "php", "message": "Errore: file Validation.php non trovato" }'); }

require "../helper/Validation.php";

$obj = json_decode($str); // echo '<pre>';var_dump( $obj ); die;// object(stdClass)

$email = $obj->mail;

if (!class_exists("Validation")) {die('{ "page": "'.$page.'", "status": "bug", "bug": "php", "message": "Errore: classe Validation non trovata" }');}

$validation = new Validation($page, ["email" => $email]);

if ($validation->validate()) {

    if (!file_exists("../../config/db.php")) { die('{ "page": "'.$page.'", "status": "bug", "bug": "file_exists", "message": "file db.php non trovato" }'); }
    require "../../config/db.php";

    $user = getUserInfo($email, $mysqli, $page);

    // die('{ "page": "'.$user['email'].'" }');
   // print_($user);die;
    resendEmail($user, $page);
}



function getUserInfo(string $email, object $mysqli, string $page) {

    $sql = "SELECT name, email, hash FROM users WHERE email = ?";

    if ( !$stmt = $mysqli->prepare($sql) ) { die('{ "page": "'.$page.'", "status": "bug", "bug": "mysqli", "message": "Errore: mysqli_stmt::prepare" }'); }

    if (!$stmt->bind_param('s', $param )) { die('{ "page": "'.$page.'", "status": "bug", "bug": "mysqli", "message": "Errore: mysqli_stmt::bind_param" }'); }

    $param = $email;

    if ( !$stmt->execute() ) { die('{ "page": "'.$page.'", "status": "bug", "bug": "mysqli", "message": "Errore: mysqli_stmt::execute" }'); }

    if (!$result = $stmt->get_result()) { die('{ "page": "'.$page.'", "status": "bug", "bug": "mysqli", "message": "Errore: mysqli_stmt::get_result" }'); }

    if ($result->num_rows === 0) { die('{ "page": "'.$page.'", "status": "error", "error": "email", "message": "All\' email '.$email.' non risulta associato nessun account" }');}

    if ( !$user = $result->fetch_assoc() ) { die('{ "page": "'.$page.'", "status": "bug", "bug": "mysqli", "message": "Errore: mysqli_stmt::fetch_assoc" }'); }

    return $user;

    //return $user = $result->fetch_assoc() ?? die('{ "page": "'.$page.'", "status": "bug", "bug": "mysqli", "message": "Errore: mysqli_stmt::fetch_assoc" }'); 
}






function resendEmail(array $user, string $page) {

    // SEND EMAIL
    if (!file_exists('../model/EmailVerify.php')) {die('{ "page": "'.$page.'", "status": "error", "error": "php", "message": "Errore: file EmailSubscription.php non trovato" }');}
 
    require "../model/EmailVerify.php";
 
    if (!class_exists("EmailVerify")) {die('{ "page": "'.$page.'", "status": "bug", "bug": "php", "message": "Errore: classe EmailSubscription non trovata" }');}
 
    $emailSubscription = new EmailVerify($user);
    $emailSubscription->send();
 }
 



