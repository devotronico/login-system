<?php
header( "Content-type: application/json" );


// https://github.com/redeluni/blog/blob/master/app/models/Signup.php

 //echo "SERVER"; die;

 
if(!filter_has_var(INPUT_POST, 'signin')){
    die('{ "status": "error", "error": "variabile POST con indice signin non trovata"}');
}

 
if ( !isset($_POST) ) {
   header("Location: index.html");
   die;
} 




$str = $_POST["signin"];

$obj = json_decode($str);

$email = $obj->mail;
$password = $obj->pass;
// echo '<pre>';var_dump( $obj ); die;// object(stdClass)
require "db.php";

// SELECT
$sql = "SELECT * FROM users WHERE email = '{$obj->mail}' AND password = '{$obj->pass}' "; 

if ($result = $mysqli->query($sql) ) {

    if ($result->num_rows === 1 ) {

        die ('{ "status": "success", "success": "login avvenuto con successo" }');
    
   } else {
   
       
    die ('{ "status": "error", "error": "la combinazione di email e password sono errate" }');
   }
   $result->close();
} else {
    die('{ "status": "error", "error": "query non eseguita" }');
}

$mysqli->close();
// {name: insert_name, mail: insert_mail, city: insert_city, phone: insert_tel};
 
   