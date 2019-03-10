<?php
if (!isset($_POST)) {header("Location: index.php");die;}
header( "Content-type: application/json" );

$file = basename(__FILE__); // DEBUG

$page = 'truncate';

if (!file_exists("../../config/db.php")) { die('{ "page": "' . $page . '", "status": "error", "error": "php", "message": "Errore: file db.php non trovato" }'); }
require "../../config/db.php";

$sql = "TRUNCATE TABLE users";

if ($mysqli->query($sql) === false) { die('{ "page": "' . $page . '", "status": "error", "error": "truncate", "message": "La tabella utenti NON è stata resettata" }'); }

die('{ "page": "' . $page . '", "status": "success", "success": "truncate", "message": "La tabella utenti è stata resettata" }');

$mysqli->close();



