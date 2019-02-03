<?php
header( "Content-type: application/json" );

 
if ( !isset($_POST) ) {
     header("Location: index.html");
     die;
} 


require "db.php";

$sql = "TRUNCATE TABLE users"; //    TRUNCATE TABLE table_name

if ($mysqli->query($sql) === TRUE) {

    echo '{ "status": "success", "success": "Tutte le righe sono state cancellate!" }';
} else {

    echo '{ "status": "error", "error": "Le righe NON sono state cancellate!" }';
}

$mysqli->close();

   
