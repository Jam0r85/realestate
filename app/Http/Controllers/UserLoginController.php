<?php

namespace App\Http\Controllers;

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
        $logins = UserLogin::latest()->paginate();
        return view('user-logins.index', compact('logins'));
    }
}
