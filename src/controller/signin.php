<?php
session_start();

if (!isset($_POST) || empty($_POST)) {header("Location: index.php");die;}

header( "Content-type: application/json" );

if (!filter_has_var(INPUT_POST, 'signin')) { die('{ "page": "signin", "status": "bug", "bug": "POST", "message": "variabile POST con indice signin non trovata" }'); }

define("PAGE", key($_POST));

$str = $_POST["signin"];

$obj = json_decode($str); // echo '<pre>';var_dump( $obj ); die;// object(stdClass)

$token = $obj->token;
$email = $obj->mail;
$password = $obj->pass;

if ($token !== $_SESSION['csrf']) { die('{ "page": "'.PAGE.'", "status": "error", "error": "token", "message": "il token è errato" }'); }


$file = basename(__FILE__); // DEBUG

if (!file_exists("../helper/Validation.php")) { die('{ "page": "'.PAGE.'", "status": "bug", "bug": "php", "message": "Errore: file Validation.php non trovato" }'); }

require "../helper/Validation.php";

if (!class_exists("Validation")) {die('{ "page": "'.PAGE.'", "status": "bug", "bug": "php", "message": "Errore: classe Validation non trovata" }');}

$validation = new Validation(
    PAGE,
    [
        "email" => $email,
        "password" => $password,
    ]
);


if ($validation->validate()) {

    if (!file_exists("../../config/db.php")) { die('{ "page": "'.PAGE.'", "status": "bug", "bug": "file_exists", "message": "file db.php non trovato" }'); }
    require "../../config/db.php";

    $user = login($email, $password, $mysqli);

    if(session_status() === PHP_SESSION_NONE) session_start();

    $_SESSION['id'] = $user->id;
    $_SESSION['name'] = $user->name;
    $_SESSION['email'] = $user->email;
    // setcookie("user_id", $user['id'], time()+3600, '/');
    // die('{ "page": "'.PAGE.'", "status": "test", "test": "php", "message": "file ' . $file . ' - linea: ' . __LINE__ . '" }'); // DEBUG
    die('{ "page": "'.PAGE.'", "status": "success", "success": "'.PAGE.'", "message": "login avvenuto con successo" }');

}


/*


// die('{ "page": "'.PAGE.'" }');
// die('{ "page": "signin", "status": "test", "test": "php" }'); // DEBUG
// die('{ "page": "'.PAGE.'", "status": "test", "test": "php", "message": "file ' . $file . ' - linea: ' . __LINE__ . '" }'); // DEBUG

if ( Validation::validateEmail($email) && Validation::validatePassword($password) ){

    require "db.php";
    //echo '{ "page": "'.PAGE.'", "status": "error", "error": "4" }';
    $user = login($email, $password, $mysqli);

    if(session_status() === PHP_SESSION_NONE) session_start();

    $_SESSION['id'] = $user->id;
    $_SESSION['name'] = $user->name;
    $_SESSION['email'] = $user->email;
    // setcookie("user_id", $user['id'], time()+3600, '/');

    die('{ "status": "success", "success": "'.PAGE.'", "message": "login avvenuto con successo" }');
}

*/

/**
 * LOGIN  [set cookie]
 * dopo aver precedentemente validato l'email e la password controlliamo se entrambi i valori esistono nel database
 * Utilizzando solo l'email per fare la query estraiamo il valore della password dal database
 * se l'email è presente nel database confrontiamo la password che abbiamo inserito nel form con quella nel database
 * se le password sono uguali facciamo un altro controllo sul campo 'user_status'
 * Se 'user_status' è uguale a 1:
 * vuol dire che abbiamo già attivato l'account precedentemente dall'email che il sistema ci ha inviato al momento della registrazione
 * Se 'user_status' è uguale a 0:
 * allora  non potremo loggarci e il sistema ci invierà una mail per attivare il l'account
 */
function login($email, $password, $mysqli) {

    $email = $mysqli->real_escape_string($email);
    $password = $mysqli->real_escape_string($password);

    $sql = "SELECT * FROM users WHERE email = ?";

    if ( !$stmt = $mysqli->prepare($sql) ) { die('{ "page": "'.PAGE.'", "status": "bug", "bug": "mysqli", "message": "Errore: mysqli_stmt::prepare" }'); }

        $stmt->bind_param('s', $param );

        $param = $email;

        if ( !$stmt->execute() ) { die('{ "page": "'.PAGE.'", "status": "bug", "bug": "mysqli", "message": "Errore: mysqli_stmt::execute" }'); }

        $result = $stmt->get_result();

        if ($result->num_rows === 0) { die('{ "page": "'.PAGE.'", "status": "error", "error": "signin-email", "message": "All\' email '.$email.' non risulta associato nessun account" }');}

        $user = $result->fetch_object();

        if (!password_verify($password, $user->password) ) { die('{ "page": "'.PAGE.'", "status": "error", "error": "password", "message": "La password non corrisponde all\' email '.$email.'" }'); }

        if ($user->verified === 0) { die('{ "page": "'.PAGE.'", "status": "error", "error": "verified", "message": "non hai ancora attivato il tuo account. Clicca su verify e un un link per attivarlo ti verrà inviato alla tua email '.$email.'" }');}

        return $user;
}
// function login($email, $password, $mysqli, $page) {

//     $sql = "SELECT * FROM users WHERE email = ? AND verified = 1";

//     if ( !$stmt = $mysqli->prepare($sql) ) { die('{ "page": "'.PAGE.'", "status": "bug", "bug": "mysqli", "message": "Errore: mysqli_stmt::prepare" }'); }

//         $stmt->bind_param('s', $param );

//         $param = $email;

//         if ( !$stmt->execute() ) { die('{ "page": "'.PAGE.'", "status": "bug", "bug": "mysqli", "message": "Errore: mysqli_stmt::execute" }'); }

//         $result = $stmt->get_result();

//         if ($result->num_rows === 0) { die('{ "page": "'.PAGE.'", "status": "error", "error": "email", "message": "All\' email '.$email.' non risulta associato nessun account" }');}

//         $user = $result->fetch_object();

//         if ( !password_verify($password, $user->password) ) { die('{ "page": "'.PAGE.'", "status": "error", "error": "'.PAGE.'", "message": "La password non corrisponde all\' email '.$email.'" }'); }

//         return $user;
// }





