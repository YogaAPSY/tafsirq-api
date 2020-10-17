<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class ApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $appIdHeaderVal = $request->header('APP-ID');
        $appIdWhitelist = explode(',', config('tafsirq.app_client_id'));

        if (in_array($appIdHeaderVal, $appIdWhitelist)) {
            return $next($request);
        }

        throw new UnauthorizedHttpException('Basic APP-ID='.$appIdHeaderVal);
    }
}
