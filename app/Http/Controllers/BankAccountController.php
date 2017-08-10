<?php

namespace App\Http\Controllers;

use App\BankAccount;
use App\Http\Requests\StoreBankAccountRequest;
use App\Http\Requests\UpdateBankAccountRequest;
use Illuminate\Http\Request;

class BankAccountController extends BaseController
{
    /**
     * Create a new controller instance.
     * 
     * @return  void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = BankAccount::latest()->paginate();
        $title = 'Bank Accounts List';

        return view('bank-accounts.index', compact('accounts','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('bank-accounts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBankAccountRequest $request)
    {
        $account = new BankAccount();
        $account->user_id = Auth::user()->id;
        $account->fill($request->input());
        $account->save();

        if ($request->has('users')) {
            $account->users()->attach($request->users);
        }

        $this->successMessage('The bank account was created');

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function show($id, $section = 'layout')
    {
        $account = BankAccount::withTrashed()->findOrFail($id);
        return view('bank-accounts.show.' . $section, compact('account'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateBankAccountRequest $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBankAccountRequest $request, $id)
    {
        $account = BankAccount::findOrFail($id);
        $account->fill($request->input());
        $account->save();

        $this->successMessage('The bank account was updated');

        return back();
    }

    /**
     * Archive the bank account.
     *
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function archive($id)
    {
        $account = BankAccount::findOrFail($id);
        $account->delete();

        $this->successMessage('The bank account was archived');

        return back();
    }

    /**
     * Restore the bank account.
     *
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $account = BankAccount::onlyTrashed()->findOrFail($id);
        $account->restore();

        $this->successMessage('The bank account was restored');

        return back();
    }
}
