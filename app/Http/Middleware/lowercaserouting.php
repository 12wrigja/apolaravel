<?php

namespace APOSite\Http\Middleware;

use Illuminate\Http\Request;
use Closure;

class LowercaseRouting
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $request->uri = strtolower($request->getUri());
        return $next($request);
    }
}
