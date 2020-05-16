<?php

namespace App\Services;

use Illuminate\Http\Request;

class ResponsePresentationLayer {
    private $code;
    private $message;
    private $data;
    private $erors;


    public function __construct($code, $message, $data, $erors)
    {
        $this->code = $code;
        $this->message = $message;
        $this->data = $data;
        $this->errors = $erors;
    }

    /**
     * Get the value of code
     */ 
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set the value of code
     *
     * @return  self
     */ 
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get the value of message
     */ 
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set the value of message
     *
     * @return  self
     */ 
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get the value of data
     */ 
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set the value of data
     *
     * @return  self
     */ 
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get the value of erors
     */ 
    public function getErors()
    {
        return $this->erors;
    }

    /**
     * Set the value of erors
     *
     * @return  self
     */ 
    public function setErors($erors)
    {
        $this->erors = $erors;

        return $this;
    }

    public function getResponse(){
        return [
            "code" => $this->code,
            "message" => $this->message,
            "data" => $this->data,
            "errors" => $this->errors
        ];
    }
}