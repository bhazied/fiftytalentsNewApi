<?php

namespace App\Http\Middleware;

use Closure;
use Zend\Diactoros\Response;

class checkIp
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
        $myIp = $request->getClientIp();
        $myHost = $request->getHost();
        if ($myHost != 'localhost' && $myIp != $myIp) {
            return response('not authorise', 401);
        }
        return $next($request);
    }
}
