<?php 

namespace Johadtech\DeepSeekV3\Facades;

use Illuminate\Support\Facades\Facade;

class DeepSeek extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'deepseek';
    }
}