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
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $accounts = BankAccount::with('owner')
            ->withTrashed()
            ->filter($request->all())
            ->latest()
            ->paginateFilter();

        $title = 'Bank Accounts List';

        return view('bank-accounts.index', compact('accounts','title'))->with(['full' => true]);
    }

    /**
     * Display a listing of archived bank accounts.
     * 
     * @return \Illuminate\Http\Response
     */
    public function archived()
    {
        $accounts = BankAccount::onlyTrashed()->latest()->paginate();
        $title = 'Archived Bank Accounts';

        return view('bank-accounts.index', compact('accounts','title'))->with(['archived' => true]);
    }

    /**
     * Search through the bank accounts and display the results.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        // Clear the search term.
        if ($request && $request->has('clear_search')) {
            Session::forget('bank_accounts_search_term');
            return redirect()->route('bank-accounts.index');
        }

        Session::put('bank_accounts_search_term', $request->search_term);

        $accounts = BankAccount::search(Session::get('bank_accounts_search_term'))->get();
        $title = 'Search Results';

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
     * @param \App\Http\Requests\BankAccountStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(BankAccountStoreRequest $request)
    {
        $account = new BankAccount();
        $account->user_id = Auth::user()->id;
        $account->bank_name = $request->bank_name;
        $account->account_name = $request->account_name;
        $account->sort_code = $request->sort_code;
        $account->account_number = $request->account_number;
        $account->save();

        if ($request->has('users')) {
            $account->users()->attach($request->users);
        }

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

        $account->users()->sync($request->users);

        return back();
    }

    /**
     * Update the users attached to a bank account.
     * 
     * @param  Request $request [description]
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function updateUsers(Request $request, $id)
    {
        $account = BankAccount::findOrFail($id);

        // Remove the owners.
        if ($request->has('remove')) {
            $account->users()->detach($request->remove);
        }

        // Attach new users to the account.
        if ($request->has('new_users')) {
            $account->users()->attach($request->new_users);
        }

        return back();
    }

    /**
     * Destroy/archive the bank account.
     *
     * @param \App\Http\Requests\BankAccountDestroyRequest $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BankAccountDestroyRequest $request, $id)
    {
        $account = BankAccount::findOrFail($id);
        $account->delete();
        return back();
    }

    /**
     * Restore the bank account.
     *
     * @param \App\Http\Requests\BankAccountRestoreRequest $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function restore(BankAccountRestoreRequest $request, $id)
    {
        $account = BankAccount::onlyTrashed()->findOrFail($id);
        $account->restore();
        return back();
    }
}
