<?php 

namespace Johadtech\DeepSeekV3\Exceptions;

use Exception;

class AuthenticationException extends Exception
{
    protected $message = 'DeepSeek API authentication failed.';
}