<?php

/**
 * Classe customizzata per gestire le eccezioni
 * Estende la classe interna di php Exception
 */
class MyException extends Exception
{

    private $myMessage;
    private $myCode;
    private $kind;
    private $data;

    /**
     * Undocumented function
     *
     * @param string $myMessage: messaggio di errore
     * @param integer $myCode: [ (da -10 a -19 -> errori utente) | (da -20 a -29 errori programmazione) | (da -30 a -39 errori databse) ]
     * @param Throwable $previous: da commentare
     * @param string $kind: il tipo di errore. viene utilizzato per creare il nome dei file di log
     */
    public function __construct( $myMessage='', int $myCode=0, Throwable $previous=null, string $kind='') {

        $this->myMessage = $myMessage;
        $this->myCode = $myCode;
        $this->kind = $kind;

        switch ($myCode) {

            case -10: $arr = $this->getUserError(); break; // user
            case -15: $arr = $this->getUserMultiError(); break; // user multierror
            case -20: $arr = $this->getDevError(); break; // php
            case -30: $arr = $this->getDevError(); break; // db
        }

        $this->data = $arr;

        $jsonstring = json_encode($arr, JSON_UNESCAPED_UNICODE);
        parent::__construct($jsonstring, $myCode, $previous);
    }



    public function getData() {

        return $this->data;
    }



    public function getKind() {

        return $this->kind;
    }



    private function getUserError(){

        $arr['date'] = date("YmdHis");
        $arr['code'] = $this->myCode;
        $arr['status'] = 'error';
        $arr['page'] = basename($this->getFile(), '.php');
        $arr['kind'] = $this->kind;

        $arr['message'] = $this->myMessage;

        return $arr;
    }



    private function getUserMultiError(){

        $arr[0]['date'] = date("YmdHis");
        $arr[0]['code'] = $this->myCode;
        $arr[0]['status'] = 'errors';
        $arr[0]['page'] = basename($this->getFile(), '.php');
        $arr[0]['kind'] = $this->kind;

        $arr[1] = $this->myMessage;

        return $arr;
    }



    private function getDevError(){

        $arr['date'] = date("YmdHis");
        $arr['code'] = $this->myCode;
        $arr['status'] = 'error';
        $arr['page'] = basename($this->getFile(), '.php');
        $arr['kind'] = $this->kind;
        $arr['path'] = $this->getFile();

        if(isset($this->getTrace()[0]['class'])) { $arr['class'] = $this->getTrace()[0]['class']; }
        if(isset($this->getTrace()[0]['function'])) { $arr['function'] = $this->getTrace()[0]['function']; }
        // if(isset($this->getTrace()[0]['type'])) { $arr['kind'] = $this->getTrace()[0]['type']; }
        // if(isset($this->getTrace()[0]['args'])) { $arr['args'] = $this->getTrace()[0]['args']; }

        $arr['file'] = basename($this->getFile());
        $arr['line'] = $this->getLine();
        $arr['message'] = $this->myMessage;

        return $arr;
    }

/*
private function writeErrorLog(array $arr){


    $baseURL = $_SERVER['DOCUMENT_ROOT'] . '/login-system/'; // C:/xampp/htdocs

    $annoCorrente = date("y"); // 19
    $meseCorrente = date("m"); // 01
    $file_Json = '/log_' . $this->kind . '.json';
    $filename = $baseURL . 'logs/' . $annoCorrente . '/' . $meseCorrente . $file_Json;


    if(!is_dir(dirname($filename))) {   // die('{ "status": "test", "num": "1" }'); // DEBUG C:/xampp/htdocs

        mkdir(dirname($filename).'/', 0777, TRUE);

        $arrayOfArr[] = $arr;

    } else {   // die('{ "status": "test", "num": "2" }');

        $jsonstring = file_get_contents($filename); // Save contents of file into a variable

        $arrayOfArr = json_decode($jsonstring, true);

        array_push($arrayOfArr, $arr);
    }

    $jsonstring = json_encode($arrayOfArr, JSON_UNESCAPED_UNICODE, JSON_PRETTY_PRINT);

    file_put_contents($filename, $jsonstring);

    //file_put_contents($filename, $jsonstring.PHP_EOL, FILE_APPEND | LOCK_EX);
}

*/



}







