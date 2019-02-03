<?php
if (!isset($_POST)) {header("Location: index.php");die;}

header("Content-type: application/json");

if (!filter_has_var(INPUT_POST, 'signup')) {die('{ "status": "error", "error": "http", "message": "variabile POST con indice signup non trovata"}');}

$file = basename(__FILE__);
// die('{ "status": "test", "test": "Test: file '.$file.' - linea: '.__LINE__.'" }');
$str = $_POST["signup"];

$obj = json_decode($str); // echo '<pre>';var_dump( $obj ); die;// object(stdClass)

$name = $obj->name;
$email = $obj->mail;
$password = $obj->pass;

/**
 * IS EMAIL STORED
 * Controlla se l'email è già presente nel database.
 * Quando viene creato un nuovo account bisogna verificare
 * che l' email che l'utente inserisce nel form non sia già stata utilizza da un altro utente
 * quindi già registrata nel database
 * L'email deve avere un valore univoco, non ci possono essere duplicati nel database
 */
function isEmailStored($mysqli, $email)
{

    $sql = "SELECT email FROM users WHERE email = ?";

    if (!$stmt = $mysqli->prepare($sql)) {die('{ "status": "error", "error": "mysqli", "message": "Errore: prepare in isEmailStored" }');}

    $stmt->bind_param('s', $param);

    $param = $email;

    if (!$stmt->execute()) {die('{ "status": "error", "error": "mysqli", "message": "Errore: execute in isEmailStored" }');}

    //$result = $stmt->get_result();

    $stmt->store_result();

    // if( $result->num_rows > 0 ) { die('{ "status": "error", "error": "Un account con L\' email <strong>'.$email.'</strong> è stata già registrata." }'); }
    if ($stmt->num_rows > 0) {die('{ "status": "error", "error": "email", "message": "Un account con L\' email <strong>' . $email . '</strong> è stata già registrata." }');}

    $stmt = null;

    return false;
}

/**
 * status ( typo: VARCHAR, length: 100, esempio: utente)
 * name ( typo: VARCHAR, length: 100, esempio: Rossi)
 * email ( typo: VARCHAR, length: 100, esempio: utente )
 * password ( typo: VARCHAR, length: 255, esempio: $2y$10$KimdfbZihiepECDtVLZPBu9.VFgj.Y.GQAceGLPvn89ZiFnQgg4ji )
 *  descrizione: archiviare il risultato in una colonna del database in grado di espandersi oltre i 60 caratteri (255 caratteri sarebbero una buona scelta).
 * registered ( typo: DATE, length: 10, format: yyyy-mm-dd 00:00:00 )
 * hash ( typo: VARCHAR, length: 32, format: [a-z0-9]{32} )
 * verified ( typo: BOOLEAN, length: 1 )
 */
function signup($mysqli, $name, $email, $password)
{

    $status = 'utente';
    $password = password_hash($password, PASSWORD_DEFAULT);
    $registered = date('Y-m-d H:i:s');
    $hash = md5(strval(rand(0, 1000)));
    $verified = 0;

    if (!$mysqli->ping()) {die('{ "status": "error", "error": "mysqli", "message": "La connessione al server è chiusa" }');}

    $sql = "INSERT INTO users ( status, name, email, password, registered, hash, verified ) VALUES ( ?, ?, ?, ?, ?, ?, ? )";

    if ($stmt = $mysqli->prepare($sql)) {

        $stmt->bind_param('ssssssi', $param1, $param2, $param3, $param4, $param5, $param6, $param7);

        $param1 = $status;
        $param2 = $name;
        $param3 = $email;
        $param4 = $password;
        $param5 = $registered;
        $param6 = $hash;
        $param7 = $verified;

        if (!$stmt->execute()) {die('{ "status": "error", "error": "mysqli", "message": "Errore: execute" }');}

        $righe_generate = $mysqli->affected_rows;
        $ultimo_ID_inserito = $mysqli->insert_id;

        if (!file_exists('../model/EmailSubscription.php')) {die('{ "status": "error", "error": "php", "message": "Errore: file EmailSubscription.php non trovato" }');}

        require "../model/EmailSubscription.php";

        if (!class_exists("EmailSubscription")) {die('{ "status": "error", "error": "php", "message": "Errore: classe EmailSubscription non trovata" }');}

        $emailSubscription = new EmailSubscription($name, $email, $hash);
        $emailSubscription->send();
        die('{ "status": "success", "success": "insert", "message": "Inserite ' . $righe_generate . ' riga nel database con id ' . $ultimo_ID_inserito . '" }');

        $stmt->close();

    } else {die('{ "status": "error", "error": "mysqli", "message": "Impossibile inserire nuove righe nel database - prepare" }');}

    $mysqli->close();
}

if (!file_exists("../helper/Validation.php")) {die('{ "status": "error", "error": "php", "message": "Errore: file Validation.php non trovato" }');}

require "../helper/Validation.php";

// $name = "Daniele";
// $email = "dan@mail.it";
// $password = "0123456789";

$validation = new Validation(
    [
        "name" => $name,
        "email" => $email,
        "password" => $password,
    ]
);
    
if ($validation->validate()) {

    if (!file_exists("../../config/db.php")) { die('{ "status": "error", "error": "php", "message": "Errore: file db.php non trovato" }'); }
    require "../../config/db.php";
    if (!isEmailStored($mysqli, $email)) {

        signup($mysqli, $name, $email, $password);
        die('{ "status": "test", "test": "php", "message": "file ' . $file . ' - linea: ' . __LINE__ . '" }');
    }
}
/*
if (Validation::validateName($name) && Validation::validateEmail($email) && Validation::validatePassword($password)) {

if (!file_exists("../../config/db.php")) {die('{ "status": "error", "error": "Errore: file db.php non trovato" }');}
require "../../config/db.php";
if (!isEmailStored($mysqli, $email)) {

signup($mysqli, $name, $email, $password);
die('{ "status": "test", "test": "Test: file ' . $file . ' - linea: ' . __LINE__ . '" }');
}
}
 */
