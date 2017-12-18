<?php

namespace App\Http\Controllers;

use App\Email;
use App\Http\Requests\UserSendEmailRequest;
use App\Notifications\UserEmail;
use App\User;
use Illuminate\Http\Request;

class EmailController extends Controller
{
	/**
	 * Display a listing of all sent emails.
	 * 
	 * @return \Illuminate\Http\Response
	 */
    public function index()
    {
    	$emails = Email::latest()->paginate();
    	return view('emails.index', compact('emails'));
    }

    /**
     * Send a user an email.
     *
     * @param  \App\Http\Requests\UserSendEmailRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sendUserEmail(UserSendEmailRequest $request, $id)
    {
        $user = User::findOrFail($id)
            ->notify(new UserEmail($request->subject, $request->message));
            
        return back();
    }

    /**
     * Preview an email exactly how it was sent.
     * 
     * @param  integer $id
     * @return Illuminate\Http\Responce
     */
    public function preview($id)
    {
    	$email = Email::findOrFail($id);
    	return view('emails.preview', compact('email'));
    }
}
