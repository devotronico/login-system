<?php

class Email{

    protected $nameSender = 'Daniele Manzi';        // toMe - verify - newpass
    protected $emailSender = 'dmanzi83@gmail.com';  // toMe - verify - newpass
    protected $nameRecipient;                       // toMe - verify
    protected $emailRecipient;                      // toMe - verify - newpass
    protected $site;                                // toMe - verify - newpass

    public function __construct($name, $email){

        $this->nameSender = 'Daniele Manzi';
        $this->emailSender = 'dmanzi83@gmail.com';
        $this->nameRecipient =  $name;
        $this->emailRecipient = $email;
        $this->site = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST']; // "http://localhost/login-system/" | https://www.danielemanzi.it/ | http://localhost:3000/
    }

} // CHIUDE CLASSE EMAIL
