<?php 

namespace Johadtech\DeepSeekV3\Exceptions;

use Exception;

class InvalidParameterException extends Exception
{
    protected $message = 'Invalid parameters provided for DeepSeek API request.';
}