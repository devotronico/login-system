<?php
header( "Content-type: application/json" );


// https://github.com/redeluni/blog/blob/master/app/models/Signup.php

 //echo "SERVER"; die;

 
 
 
 if ( !isset($_POST) ) {
     header("Location: index.html");
     die;
    } 
    
if(!filter_has_var(INPUT_POST, 'signin')){
    die('{ "status": "error", "error": "variabile POST con indice signin non trovata"}');
}



$str = $_POST["signin"];

$obj = json_decode($str); // echo '<pre>';var_dump( $obj ); die;// object(stdClass)

$email = $obj->mail;
$password = $obj->pass;





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
function login($email, $password, $mysqli) 
{

    $sql = "SELECT * FROM users WHERE email = '{$email}'";

    if ( $result = $mysqli->query($sql) ) {

        if ( $result->num_rows == 1 ) {

          //  die ('{ "status": "success", "success": "login avvenuto con successo" }');

            $user = $result->fetch_object(); // fetch_row() / fetch_object() / fetch_array
          //  $user->view = 'modal';  //  print_r($user);
         
           // echo json_encode($data);



/*
                if ( password_verify($password, $user->password) ) {

                        $_SESSION['id'] = $user->id;
                        $_SESSION['name'] = $user->name;
                       // setcookie("user_id", $user['id'], time()+3600, '/');
               
                } else {

                    die('{ "status": "error", "error":  " La password non corrisponde all\' email '.$email.'" }');

                 //   die("La password non corrisponde all' email <strong>$email</strong>.<br>");
                }

                */
            } else {

                die('{ "status": "error", "error":  "All\' email '.$email.' non risulta associato nessun account." }');
            }
        } else {

            die('{ "status": "error", "error":  "Qualcosa è andato storto. Per favore prova più tardi." }');
        }
        
}




require "model/Validation.php";


if ( Validation::validateEmail($email) && Validation::validatePassword($password) ){

    require "db.php";

    login($email, $password, $mysqli);

   // if (isset($_SESSION['id'])) {

        die ('{ "status": "success", "success": "login avvenuto con successo" }');
  //  }
}
 
   