<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class VerifyStaffMember
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
        if (App::environment('production')) {

            $staff = config('system.staff');

            if (!in_array(Auth::user()->id, $staff)) {
                abort('403', 'Invalid permissions to access this area');
            }
        }

        return $next($request);
    }
}
