<?php
if(session_status() === PHP_SESSION_NONE) session_start();

if ( !isset($_SESSION["id"]) ) {

    header("Location: index.php");
    die;
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <title>Pagina</title>
</head>
<body>
    <div class="container">
        <div class="wrapper">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a class="bt" id="home" href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a class="bt" id="page" href="page.php">Page</a></li>
                <li class="breadcrumb-item"><a class="bt" id="logout" href="logout">Logout</a></li>
                <li class="breadcrumb-item"><a class="bt" id="truncate" href="#">Truncate</a></li>
                </ol>
            </nav>
            <h1>Pagina</h1>
        </div>
    </div>
</body>
</html>