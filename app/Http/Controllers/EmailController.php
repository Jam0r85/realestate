<?php

namespace App\Http\Controllers;

use App\Email;
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
