<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Repositories\EloquentSettingsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends BaseController
{
    /**
     * @var  App\Repositories\EloquentSettingsRepository
     */
    protected $settings;
    protected $branches;

    /**
     * Create a new controller instance.
     * 
     * @param   EloquentSettingsRepository $users
     * @return  void
     */
    public function __construct(EloquentSettingsRepository $settings)
    {
        $this->middleware('auth');
        $this->settings = $settings;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('settings.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function logo()
    {
        return view('settings.logo');
    }

    /**
     * Display a listing of permissions.
     * 
     * @return \Illuminate\Http\Response
     */
    public function permissions()
    {
        $permissions = Permission::orderBy('slug')->get();
        return view('settings.permissions', compact('permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->except('_token');
        $this->settings->save($data);
        return back();
    }

    /**
     * Upload and update the company logo.
     * 
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function updateLogo(Request $request)
    {
        $path = Storage::putFile('logos', $request->file('company_logo'));
        $this->settings->save(['key' => 'company_logo', 'value' => $path]);
        return back();
    }
}
