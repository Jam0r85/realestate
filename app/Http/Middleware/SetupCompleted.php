<?php

namespace App\Http\Middleware;

use Closure;

class SetupCompleted
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
        if (!config('system.staff') || (!array_filter(config('system.staff')))) {
            abort('500', 'Staff not assigned in config');
        }

        return $next($request);
    }
}
