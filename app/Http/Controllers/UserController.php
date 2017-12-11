<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserEmailRequest;
use App\Http\Requests\UpdateUserPhoneRequest;
use App\Http\Requests\{UserStoreRequest, UserUpdateRequest, UserSendEmailRequest};
use App\Notifications\UserEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class UserController extends BaseController
{
    /**
     * The model for this controller.
     * 
     * @var string
     */
    public $model = 'App\User';

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = $this->repository
            ->with('home','tenancies','tenancies.property')
            ->withTrashed()
            ->filter($request->all())
            ->latest()
            ->paginateFilter();
            
        $title = 'Users List';
        return view('users.index', compact('users','title','sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $latestUsers = $this->repository
            ->latest()
            ->limit(15)
            ->get();

        return view('users.create', compact('latestUsers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\UserStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $user = $this->repository;
        $user->title = $request->title;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->company_name = $request->company_name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->phone_number_other = $request->phone_number_other;
        $user->password = bcrypt($request->password ?? str_random(10));
        $user->save();

        return redirect()->route('users.show', $user->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @param  string  $page
     * @return \Illuminate\Http\Response
     */
    public function show($id, $page = 'layout')
    {
        $user = $this->repository
            ->withTrashed()
            ->findOrFail($id);

        $bank_accounts = $user->bankAccounts;
        $properties = $user->properties()->with('owners')->get();
        $tenancies = $user->tenancies()->with('tenants')->get();
        $invoices = $user->invoices()->with('users','property','items','items.taxRate')->paginate();
        $sms_messages = $user->sms()->with('user','owner')->get();
        $emails = $user->emails()->paginate();

        return view('users.pages.' . $page, compact(
            'user',
            'bank_accounts',
            'properties',
            'tenancies',
            'invoices',
            'sms_messages',
            'emails'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return  \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = $this->repository
            ->findOrFail($id)
            ->fill($request->input())
            ->setSetting($request->input())
            ->save();

        return back();
    }

    /**
     * Update the user's email address in storage.
     *
     * @param  \App\Http\Requests\UpdateUserEmailRequest  $request
     * @param  \App\User  $id
     * @return \Illuminate\Http\Response
     */
    public function updateEmail(UpdateUserEmailRequest $request, $id)
    {
        $user = $this->repository
            ->findOrFail($id);

        if ($user->email && $request->has('remove_email')) {
            $service = new UserService();
            $service->removeUserEmail($user);

            $this->successMessage('The e-mail for this user was removed');

            return back();
        }

        $user->email = $request->email;
        $user->save();

        return back();
    }

    /**
     * Send the user an email message.
     *
     * @param \App\Http\Requests\UserSendEmailRequest $request
     * @param  \App\User  $id
     * @return \Illuminate\Http\Response
     */
    public function sendEmail(UserSendEmailRequest $request, $id)
    {
        $user = $this->repository
            ->findOrFail($id)
            ->notify(new UserEmail($request->subject, $request->message));
            
        return back();
    }

    /**
     * Mark all unread notifications as having been read.
     * 
     * @param  \App\User  $user
     * @return  \Illuminate\Http\Response
     */
    public function clearNotifications($id)
    {
        $user = $this->repository
            ->findOrFail($id)
            ->unreadNotifications
            ->markAsRead();

        $this->successMessage('All notifications have been marked as read');
        return back();
    }
}
