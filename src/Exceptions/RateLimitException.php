<?php 

namespace Johadtech\DeepSeekV3\Exceptions;

use Exception;

class RateLimitException extends Exception
{
    protected $message = 'DeepSeek API rate limit exceeded.';
}