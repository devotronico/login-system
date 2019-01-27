<?php
header( "Content-type: application/json" );
/*
$_SERVER["PHP_SELF"];
$_SESSION["id"] = htmlentities($);
unset($_SESSION["id"]);
session_destroy();
print_r($_SESSION);


setcookie("id", $id, time()+3600); // 1 hour
setcookie("username", $username, time()+(86400*30)); // 1 day
$_COOKIE["username"]
setcookie("id", $id, time()-3600); // unset

if ( count($_COOKIE) ) { echo "ci sono count($_COOKIE) cookie"; }
chrome://settings/cookie

$user = ["name" => "Brad", "email" => "test@mail.it", "age" => 35];
serialize($user);
unserialize();
*/


// https://github.com/redeluni/blog/blob/master/app/models/Signup.php

 //echo "SERVER"; die;

 
 

// echo '{ "status": "error", "error": "2" }';


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
/*
function login($email, $password, $mysqli) {
  
    $sql = "SELECT * FROM users WHERE email = ?";

    if ( $stmt = $mysqli->prepare($sql) ) {

        $stmt->bind_param('s', $param );
        
        $param = $email;
        
        if ( !$stmt->execute() ) { die('{ "status": "error", "error":  "Errore: execute" }'); }
        
        $result = $stmt->get_result();
        
        if($result->num_rows === 0) { die('{ "status": "error", "error":  "All\' email '.$email.' non risulta associato nessun account." }'); }
        
        $user = $result->fetch_object();
        // die('{ "status": "error", "error":  "Errore: " }');

            if ( !password_verify($password, $user->password) ) {  die('{ "status": "error", "error":  " La password non corrisponde all\' email '.$email.'" }'); }

                $_SESSION['id'] = $user->id;
                $_SESSION['name'] = $user->name;
                // setcookie("user_id", $user['id'], time()+3600, '/');
                header("Location: /index.php");
                die;
            
    } else { 

        die('{ "status": "error", "error": "Errore: prepare" }');
    }
}
*/



/*
require "model/Validation.php";


if ( Validation::validateEmail($email) && Validation::validatePassword($password) ){

    require "db.php";
    echo '{ "status": "error", "error": "4" }';
    login($email, $password, $mysqli);

   // if (isset($_SESSION['id'])) {

        die ('{ "status": "success", "success": "login avvenuto con successo" }');
  //  }
}
 */









/*
function login($email, $password, $mysqli) {

    $sql = "SELECT * FROM users WHERE email = '{$email}'";

    if ( $result = $mysqli->query($sql) ) {

        if ( $result->num_rows == 1 ) {

          //  die ('{ "status": "success", "success": "login avvenuto con successo" }');

            $user = $result->fetch_object(); // fetch_row() / fetch_object() / fetch_array
          //  $user->view = 'modal';  //  print_r($user);
         
           // echo json_encode($data);

                if ( password_verify($password, $user->password) ) {

                        $_SESSION['id'] = $user->id;
                        $_SESSION['name'] = $user->name;
                       // setcookie("user_id", $user['id'], time()+3600, '/');
               
                } else {

                    die('{ "status": "error", "error":  " La password non corrisponde all\' email '.$email.'" }');

                 //   die("La password non corrisponde all' email <strong>$email</strong>.<br>");
                }

                
            } else {

                die('{ "status": "error", "error":  "All\' email '.$email.' non risulta associato nessun account." }');
            }
        } else {

            die('{ "status": "error", "error":  "Qualcosa è andato storto. Per favore prova più tardi." }');
        }
}
*/
   

<nav aria-label="breadcrumb">
<ol class="breadcrumb">
    <?php if (isset($_SESSION["id"])) : ?>
    <li class="breadcrumb-item"><a class="bt" id="logout" href="/logout">Logout</a></li>
    <?php else : ?> 
    <li class="breadcrumb-item active"><a class="bt" id="type-signin" href="#">Signin</a></li>
    <li class="breadcrumb-item"><a class="bt" id="type-signup" href="#">Signup</a></li>
    <?php endif; ?> 
    <li class="breadcrumb-item"><a class="bt" id="truncate" href="#">Truncate</a></li>
</ol>
</nav>