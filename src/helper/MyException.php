<?php


class MyException extends Exception
{

    private $myMessage;
    private $myCode;
    private $type;

    public function __construct( $myMessage='', int $myCode=0, Throwable $previous=null, string $type='') {

        $this->myMessage = $myMessage;
        $this->myCode = $myCode;
        $this->type = $type;

        switch ($myCode) {

            case -10: $jsonstring = $this->getUserError(); break; // user
            case -15: $jsonstring = $this->getUserMultiError(); break; // user
            case -20: $jsonstring = $this->geDevError(); break; // php
            case -30: $jsonstring = $this->geDevError(); break; // db
        }

        parent::__construct($jsonstring, $myCode, $previous);
    }


    private function getUserError(){

        $arr['code'] = $this->myCode;
        $arr['page'] = basename($this->getFile(), '.php');
        $arr['status'] = 'error';
        $arr['type'] = $this->type;
        // if ($this->type) { $arr['type'] = $this->type; };
        $arr['message'] = $this->myMessage;

        return json_encode($arr);
    }



    private function getUserMultiError(){

        $arr[0]['code'] = $this->myCode;
        $arr[0]['page'] = basename($this->getFile(), '.php');
        $arr[0]['status'] = 'errors';
        $arr[1] = $this->myMessage;

      //  return json_encode($arr);
     // return json_encode($arr,  JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
      // return json_encode($arr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
         return json_encode($arr, JSON_UNESCAPED_UNICODE);
      //  return json_encode($arr, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
    }



    private function geDevError(){

        $arr['code'] = $this->myCode;
        $arr['line'] = $this->getLine();
        if(isset($this->getTrace()[0]['class'])) { $arr['class'] = $this->getTrace()[0]['class']; }
        if(isset($this->getTrace()[0]['function'])) { $arr['function'] = $this->getTrace()[0]['function']; }
        if(isset($this->getTrace()[0]['type'])) { $arr['type'] = $this->getTrace()[0]['type']; }
        //if(isset($this->getTrace()[0]['args'])) { $arr['args'] = $this->getTrace()[0]['args']; }

        $arr['path'] = $this->getFile();
        $arr['page'] = basename($this->getFile(), '.php');
        $arr['status'] = 'error';
        $arr['type'] = $this->type;
        $arr['message'] = $this->myMessage;

        return json_encode($arr, JSON_UNESCAPED_UNICODE);
    }




}