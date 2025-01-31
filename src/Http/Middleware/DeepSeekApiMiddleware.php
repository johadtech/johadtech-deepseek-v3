<?php 

namespace Johadtech\DeepSeekV3\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Johadtech\DeepSeekV3\Exceptions\RateLimitException;

class DeepSeekApiMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (app('cache')->get('deepseek_rate_limit')) {
            throw new RateLimitException();
        }

        return $next($request);
    }
}