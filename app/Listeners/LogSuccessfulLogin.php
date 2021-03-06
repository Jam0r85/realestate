<?php

namespace App\Listeners;

use App\UserLogin;
use Carbon\Carbon;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Request;

class LogSuccessfulLogin
{
    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        UserLogin::create([
            'user_id' => $event->user->id,
            'ip' => Request::ip(),
            'url' => Request::fullUrl()
        ]);
    }
}
