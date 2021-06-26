<?php

namespace App\Exceptions;

use Exception;

class SendEmailException extends Exception
{
    private $data = '';

    protected $code = 500;

    protected $message = 'SendEmail exception';

	public function __construct($message, $data) 
    {
        $this-> data = $data;
        parent::__construct($message);
    }


    public function getData()
    {
        return $this-> data;
    }
}
