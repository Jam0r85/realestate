<?php

namespace App\Http\Controllers;

use App\UserFailedLogin;
use App\UserLogin;
use Illuminate\Http\Request;

class UserLoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $successful = UserLogin::with('user')->latest()->paginate();
        $failed = UserFailedLogin::latest()->paginate();

        $sections = ['Successful','Failed'];

        return view('user-logins.index', compact('successful','failed','sections'));
    }
}
