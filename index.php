<?php
if(session_status() === PHP_SESSION_NONE) session_start();
// session_start();
// ttdnjfqrubatgukpjl40ccq01o

//echo $_SERVER["PHP_SELF"]; // /login-system/index.php
//if ( count($_SESSION) ) { echo "ci sono ".count($_SESSION)." cookie"; } else { echo "0"; } // 0
if ( count($_COOKIE) ) { echo "ci sono " .count($_COOKIE). " cookie"; } else { echo "0"; } // 0
echo "<br>";
if(filter_has_var(INPUT_COOKIE, 'id')) {  echo "cookie id: ".$_COOKIE["id"]; } else { echo "nessun cookie id"; } // 0
echo "<br>";
if ( count($_SESSION) ) { echo "L' array SESSION è attivo"; } else {  echo "L' array SESSION NON è attivo"; }
echo "<br>";
echo SID;
echo "<br>";
echo "<pre>";print_r($_SESSION);echo "</pre>"; // array vuoto
if ( isset($_SESSION["id"]) )  {  echo "session id: ".$_SESSION["id"]; } else { echo "nessun session id"; } // 0
/*

$_SESSION["id"] = htmlentities($);
unset($_SESSION["id"]);
session_destroy();
print_r($_SESSION);


setcookie("id", $id, time()+3600); // 1 hour
setcookie("username", $username, time()+(86400*30)); // 1 day
$_COOKIE["username"]
setcookie("id", $id, time()-3600); // unset

chrome://settings/cookie

$user = ["name" => "Brad", "email" => "test@mail.it", "age" => 35];
serialize($user);
unserialize();
*/



// OTP SMS 
// registrazione con numero di telefono

// if ( !isset($_GET) ) { header("Location: index.html"); die;} else { var_dump($_GET); die("variabile GET settata");}
 

//die($_SERVER['HTTP_HOST']); // localhost



/**
 * 
 */
$messageRegistration = "";
if(!filter_has_var(INPUT_COOKIE, 'id')){

    // Se è stato cliccato sul link contenuto nel email 
    if(filter_has_var(INPUT_GET, 'email') && filter_has_var(INPUT_GET, 'hash') ){

        $email = $_GET["email"];
        $hash = $_GET["hash"];

        /**
         * SIGNUP VERIFY     metodo = GET   route = auth/signup/verify    COOKIE 
         * Quando all'interno della Mail clicchiamo il link verremo indirizzati di nuovo sul sito per
         * verificare se i parametri del link siano validi e se l'account non era già stato attivato. 
         * Se è andato tutto bene verremo loggati   
         */
        function signupVerify($email, $hash){  

            require "server/db.php";
            require "server/model/EmailLink.php";
            $EmailLink = new EmailLink($mysqli, $email, $hash);
            $messageRegistration = $EmailLink->accountActivation();
           // echo $messageRegistration;
        }

        require "server/model/Validation.php";
        if ( Validation::validateEmail($email) && Validation::validateHash($hash) ){ 

            signupVerify($email, $hash);

            // if ( !isset( $_SESSION['id'] ) ) {  header("Location: index.html"); die;}
        }

    } else {
        // header("Location: login.html");
        // die;
    }
} 



 
/*
if ( $_GET["email"] && $_GET["hash"] ) {

}*/
// $message = "ciao"; die($message);
    // die('{ "status": "error", "error": "variabile GET  con indice signup non trovata"}');



 /*

 
 $obj = json_decode($str); // echo '<pre>';var_dump( $obj ); die;// object(stdClass)
 
 $name = $obj->name;
 $email = $obj->mail;
 $password = $obj->pass;


   <p id="message-registration" style="display:<?= isset($messageRegistration) ? 'block' : 'none' ?>"><?=$messageRegistration?></p>
 */


 
 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <title>Login-System</title>
</head>
<body>
    <div class="container">
        <div class="wrapper">

            <nav aria-label="breadcrumb">
                <?php if ( isset($_SESSION["id"]) ) : ?>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="bt" id="home" href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a class="bt" id="page" href="page.php">Page</a></li>
                    <li class="breadcrumb-item"><a class="bt" id="logout" href="logout">Logout</a></li>
                    <li class="breadcrumb-item"><a class="bt" id="truncate" href="#">Truncate</a></li>
                </ol>
                <?php else : ?>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a class="bt" id="type-signin" href="#">Signin</a></li>
                    <li class="breadcrumb-item"><a class="bt" id="type-signup" href="#">Signup</a></li>
                    <li class="breadcrumb-item"><a class="bt" id="truncate" href="#">Truncate</a></li>
                </ol>
                <?php endif ; ?>
            </nav>

   
            <h1>Home</h1> 
            <p id="message-registration"><?php echo $messageRegistration?></p>
           
           
              
                <div id="form-content" style="display:<?= isset($_SESSION["id"]) ? 'none' : 'block' ?>">
                    <form id="form-signin">
                        <div class="form-group">
                            <label for="email-signin">Email address</label>
                            <input type="email" class="form-control" id="email-signin" aria-describedby="emailHelp" placeholder="Enter email" autocomplete="username">
                        </div>
                        <div class="form-group">
                            <label for="password-signin">Password</label>
                            <input type="password" class="form-control" id="password-signin" placeholder="Password" autocomplete="current-password">
                            <small id="passwordHelp" class="form-text text-muted"><a class="bt" id="pass-emailform" href="pass-emailform">password dimenticata?</a></small>
                        </div>
                        <button type="submit" class="btn btn-primary bt" id="signin">Signin</button>
                    </form>

                    <form id="form-signup" hidden>
                        <div class="form-group">
                            <label for="name-signup">Name</label>
                            <input type="text" class="form-control" id="name-signup" aria-describedby="nameHelp" placeholder="Enter name" autocomplete="username">
                        </div>
                        <div class="form-group">
                            <label for="email-signup">Email address</label>
                            <input type="email" class="form-control" id="email-signup" aria-describedby="emailHelp" placeholder="Enter email" autocomplete="username">
                        </div>
                        <div class="form-group">
                            <label for="password-signup">Password</label>
                            <input type="password" class="form-control" id="password-signup" placeholder="Password" autocomplete="current-password">
                            <small id="passwordHelp" class="form-text text-muted">We'll never share your password with anyone else.</small>
                        </div>
                        <button type="submit" class="btn btn-primary bt" id="signup">Signup</button>
                    </form>
                </div>
         
      
   
        </div>

    </div>
    <script type="module" src="js/app.js"></script>
</body>
</html>