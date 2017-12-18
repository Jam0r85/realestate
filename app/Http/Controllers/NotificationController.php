<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
	/**
	 * Display a list of notifications for the given user.
	 * 
	 * @param  \App\User  $user
	 * @return \Illuminate\Http\Response
	 */
    public function user(User $user)
    {
    	return view('notifications.user-notifications', compact('user'));
    }

   	/**
     * Mark all unread notifications as having been read.
     * 
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function clearNotifications(User $user)
    {
        $user
            ->unreadNotifications
            ->markAsRead();

        return back();
    }
}
