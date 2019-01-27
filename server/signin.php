<?php

header( "Content-type: application/json" );




if ( !isset($_POST) ) { header("Location: /index.php"); die; } 
    
if(!filter_has_var(INPUT_POST, 'signin')){ die('{ "status": "error", "error": "variabile POST con indice signin non trovata" }'); }


$str = $_POST["signin"];

$obj = json_decode($str); // echo '<pre>';var_dump( $obj ); die;// object(stdClass)

$email = $obj->mail;
$password = $obj->pass;


require "model/Validation.php";


if ( Validation::validateEmail($email) && Validation::validatePassword($password) ){

    require "db.php";
    //echo '{ "status": "error", "error": "4" }';
    $user = login($email, $password, $mysqli);

    if(session_status() === PHP_SESSION_NONE) session_start();

    $_SESSION['id'] = $user->id;
    $_SESSION['name'] = $user->name;
    $_SESSION['email'] = $user->email;
    // setcookie("user_id", $user['id'], time()+3600, '/');
   
    die('{ "status": "success", "success": "login avvenuto con successo" }');
}
 


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
  
    $sql = "SELECT * FROM users WHERE email = ?";

    if ( $stmt = $mysqli->prepare($sql) ) {

        $stmt->bind_param('s', $param );
        
        $param = $email;
        
        if ( !$stmt->execute() ) { die('{ "status": "error", "error":  "Errore: execute" }'); }
        
        $result = $stmt->get_result();
        
        if($result->num_rows === 0) { die('{ "status": "error", "error":  "All\' email '.$email.' non risulta associato nessun account." }'); }
        
        $user = $result->fetch_object();

        if ( !password_verify($password, $user->password) ) {  die('{ "status": "error", "error":  " La password non corrisponde all\' email '.$email.'" }'); }

        return $user;

    } else { 

        die('{ "status": "error", "error": "Errore: prepare" }');
    }
}





