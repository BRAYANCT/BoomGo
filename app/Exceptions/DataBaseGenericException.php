<?php

namespace App\Exceptions;

use Exception;

class DataBaseGenericException extends Exception
{	
	protected $code = 500;

	protected $message = 'DataBase exception';

}
