<?php

namespace App\Http\Controllers;

use App\BankAccount;
use App\Http\Requests\BankAccountDestroyRequest;
use App\Http\Requests\BankAccountRestoreRequest;
use App\Http\Requests\BankAccountStoreRequest;
use App\Http\Requests\UpdateBankAccountRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class BankAccountController extends BaseController
{
    /**
     * The eloquent model for this controller.
     * 
     * @var  string
     */
    public $model = 'App\BankAccount';

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->all()) {
            $request->request->add(['archived' => false]);
        }

        $bank_accounts = $this->repository
            ->with('owner')
            ->withTrashed()
            ->filter($request->all())
            ->latest()
            ->paginateFilter();

        return view('bank-accounts.index', compact('bank_accounts'))->with(['full' => true]);
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
     * @param  \App\Http\Requests\BankAccountStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BankAccountStoreRequest $request)
    {
        $account = $this->repository
            ->fill($request->all())
            ->save();

        if ($request->has('users')) {
            $account->users()->attach($request->users);
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @param  string  $show
     * @return \Illuminate\Http\Response
     */
    public function show($id, $show = 'index')
    {
        $account = $this->repository
            ->withTrashed()
            ->findOrFail($id);

        return view('bank-accounts.show', compact('account','show'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $account = $this->repository
            ->withTrashed()
            ->findOrFail($id);

        return view('bank-accounts.edit', compact('account'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBankAccountRequest  $request
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBankAccountRequest $request, $id)
    {
        $account = $this->repository
            ->findOrFail($id)
            ->fill($request->input())
            ->save();

        if ($request->has('users')) {
            $account->users()->sync($request->users);
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        parent::destroy($request, $id);
        return back();
    }
}