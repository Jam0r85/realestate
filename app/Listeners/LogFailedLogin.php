<?php

namespace App\Listeners;

use App\UserFailedLogin;
use Illuminate\Auth\Events\Failed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogFailedLogin
{
    /**
     * Handle the event.
     *
     * @param  Failed  $event
     * @return void
     */
    public function handle(Failed $event)
    {
        $login = new UserFailedLogin();
        $login->ip = request()->ip();
        $login->request = request()->only('email');
        $login->save();
    }
}
