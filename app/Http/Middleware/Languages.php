<?php

namespace App\Http\Middleware;

use Closure;

class Languages
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
        if(!in_array($request->segment(1), config('translatable.locales'))){;
            $segments = $request->segments();
            $segments = array_prepend($segments, config('app.fallback_locale'));
            return redirect()->to(implode('/', $segments));
        }
        return $next($request);
    }
}
