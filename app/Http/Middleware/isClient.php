<?php

namespace Fickrr\Http\Middleware;

use Closure;

class IsClient
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
        if(auth()->user()->isClient()) {
            return $next($request);
        }
		return redirect('/');
    }
}
