<?php
if(session_status() === PHP_SESSION_NONE) session_start();

$bytes = random_bytes(32);
$token = bin2hex($bytes);
$_SESSION['csrf'] = $token;

// manzoantonio5@gmail.com
// PHP Version: 7.2.11 
// include_once(dirname(__FILE__) . '/database.class.php'); 

// session_start();
// ttdnjfqrubatgukpjl40ccq01o
//echo $_SERVER["PHP_SELF"]; // /login-system/index.php
//if ( count($_SESSION) ) { echo "ci sono ".count($_SESSION)." cookie"; } else { echo "0"; } // 0
/*
if ( count($_COOKIE) ) { echo "ci sono " .count($_COOKIE). " cookie"; } else { echo "0"; } // 0
echo "<br>";
if(filter_has_var(INPUT_COOKIE, 'id')) {  echo "cookie id: ".$_COOKIE["id"]; } else { echo "nessun cookie id"; } // 0
echo "<br>";
if ( count($_SESSION) ) { echo "L' array SESSION è attivo"; } else {  echo "L' array SESSION NON è attivo"; }
echo "<br>";
echo "<pre>";print_r($_SESSION);echo "</pre>"; // array vuoto
if ( isset($_SESSION["id"]) )  {  echo "session id: ".$_SESSION["id"]; } else { echo "nessun session id"; } // 0

*/

/*
echo "<br><br><br>";
$site = (isset($_SERVER['HTTPS']) ? "https" : "http"); // http
echo $site;
echo "<br>";
$site = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST']; // http://localhost
echo $site;
echo "<br>";
$site = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; // http://localhost/job-01/
echo $site;
*/

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
 * SIGNUP VERIFY     metodo = GET   route = auth/signup/verify    COOKIE
 * Quando all'interno della Mail clicchiamo il link verremo indirizzati di nuovo sul sito per
 * verificare se i parametri del link siano validi e se l'account non era già stato attivato.
 * Se è andato tutto bene verremo loggati
 */
/*
$messageRegistration = "";
if(!filter_has_var(INPUT_COOKIE, 'id')){

    // Se è stato cliccato sul link contenuto nel email
    if(filter_has_var(INPUT_GET, 'email') && filter_has_var(INPUT_GET, 'hash') ){

        $email = $_GET["email"];
        $hash = $_GET["hash"];


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
*/



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
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous"> -->
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
                    <li class="breadcrumb-item"><a class="bt" id="logout" href="#">Logout</a></li>
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


            <h1>home</h1>


            <div class="alert alert-danger alert-fatal-error" role="alert" hidden>
                <div class="box-btn box-btn-fatal-error text-right">
                    <button type="submit" class="btn btn-primary text-right bt" id="fatal-error">Alert Webmaster</button>
                </div>
            </div>



            <?php if ( isset($_GET["result"]) && isset($_GET["message"]) ) : ?>
            <div class="alert alert-<?=$_GET["result"]?>" role="alert"><?=$_GET["message"]?></div>
            <?php endif; ?>



                <div id="form-content" style="display:<?= isset($_SESSION["id"]) ? 'none' : 'block' ?>">

                    <form id="form-signin">
                        <div class="alert alert-warning alert-verify-email" role="alert" hidden>
                            <div class="box-btn box-btn-verify-email text-right">
                            <button type="submit" class="btn btn-primary text-right bt" id="verify">Verify</button>
                            </div>
                        </div>
                        <input type="email" class="form-control" id="email-verify" aria-describedby="emailHelp" placeholder="Enter verify" autocomplete="username" hidden>

                        <input type="hidden" id="token-signin" value="<?=$token?>">
                        <div class="form-group">
                            <label for="email-signin">Email address</label>
                            <input type="email" class="form-control" id="email-signin" aria-describedby="emailHelp" placeholder="Enter email" autocomplete="username">
                            <div class="alert alert-danger alert-signin-email" role="alert" hidden></div>
                        </div>
                        <div class="form-group">
                            <label for="password-signin">Password</label>
                            <input type="password" class="form-control" id="password-signin" placeholder="Password" autocomplete="current-password">
                            <small id="passwordHelp" class="form-text text-muted"><a class="bt" id="pass-emailform" href="pass-emailform">password dimenticata?</a></small>
                            <div class="alert alert-danger alert-signin-password" role="alert" hidden></div>
                        </div>
                        <div class="box-btn text-center">
                            <button type="submit" class="btn btn-primary bt" id="signin">Signin</button>
                        </div>
                    </form>

                    <form id="form-signup" hidden>
                        <div class="form-group">
                            <label for="name-signup" data-toggle="tooltip" data-placement="top" title="Non deve contenere i simboli: €#$%^&*()+=-[]';,./{}|:<>?~">Name</label>
                            <input type="text" class="form-control" id="name-signup" aria-describedby="nameHelp" placeholder="Enter name" autocomplete="username">
                            <div class="alert alert-danger alert-signup-name" role="alert" hidden></div>
                        </div>
                        <div class="form-group">
                            <label for="email-signup">Email address</label>
                            <input type="email" class="form-control" id="email-signup" aria-describedby="emailHelp" placeholder="Enter email" autocomplete="username">
                            <div class="alert alert-danger alert-signup-email" role="alert" hidden></div>
                        </div>
                        <div class="form-group">
                            <label for="password-signup">Password</label>
                            <input type="password" class="form-control" id="password-signup" placeholder="Password" autocomplete="current-password">
                            <div class="alert alert-danger alert-signup-password" role="alert" hidden></div>
                            <small id="passwordHelp" class="form-text text-muted">La password deve avere almeno 8 caratteri</small>
                        </div>
                        <div class="box-btn text-center">
                            <button type="submit" class="btn btn-primary bt" id="signup">Signup</button>
                        </div>
                    </form>
                </div>



        </div>

    </div>
    <script type="module" src="js/app.js"></script>
</body>
</html>