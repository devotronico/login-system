<?php
// OTP SMS 
// registrazione con numero di telefono



if ( !isset($_GET) ) {
    header("Location: index.html");
    die;
 } 
 
 

if ( $_GET["email"] && $_GET["hash"] ) {

}

 if(!filter_has_var(INPUT_GET, 'signup')){
     die('{ "status": "error", "error": "variabile GET  con indice signup non trovata"}');
 }
 

 /*

 
 $obj = json_decode($str); // echo '<pre>';var_dump( $obj ); die;// object(stdClass)
 
 $name = $obj->name;
 $email = $obj->mail;
 $password = $obj->pass;
 */
$email = $_GET["email"];
$hash = $_GET["hash"];

 if ( Validation::validateEmail($email) && Validation::validateHash($hash) ){ 


/***********************************************************************************************|
* SIGNUP VERIFY     metodo = GET   route = auth/signup/verify    COOKIE                         |                                                              
* Quando all'interno della Mail clicchiamo il link verremo indirizzati di nuovo sul sito per    |
* verificare se i parametri del link siano validi e se l'account non era già stato attivato.    |
* Se è andato tutto bene verremo loggati                                                        |
************************************************************************************************/
function signupVerify() {  
   
    require "model/EmailLink.php";
    $EmailLink = new EmailLink($this->conn, $_GET);
    $EmailLink->accountActivation();
 
    $message = !empty( $EmailLink->getMessage()) ? $EmailLink->getMessage() : "Complimenti <strong>".$_SESSION['user_name']."</strong> la tua registrazione è avvenuta con successo!";
 
}

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
    <title>Login-System</title>
</head>
<body>
    <div class="container">
        <div class="wrapper">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a class="bt" id="type-signin" href="#">Signin</a></li>
                    <li class="breadcrumb-item"><a class="bt" id="type-signup" href="#">Signup</a></li>
                    <li class="breadcrumb-item"><a class="bt" id="logout" href="#">Logout</a></li>
                    <li class="breadcrumb-item"><a class="bt" id="truncate" href="#">Truncate</a></li>
                </ol>
            </nav>

            <form id="form-signin">
                <div class="form-group">
                    <label for="email-signin">Email address</label>
                    <input type="email" class="form-control" id="email-signin" aria-describedby="emailHelp" placeholder="Enter email" autocomplete="email">
                </div>
                <div class="form-group">
                    <label for="password-signin">Password</label>
                    <input type="password" class="form-control" id="password-signin" placeholder="Password" autocomplete="current-password">
                    <small id="passwordHelp" class="form-text text-muted">We'll never share your password with anyone else.</small>
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
                    <input type="email" class="form-control" id="email-signup" aria-describedby="emailHelp" placeholder="Enter email" autocomplete="email">
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
    <script type="module" src="js/app.js"></script>
</body>
</html>