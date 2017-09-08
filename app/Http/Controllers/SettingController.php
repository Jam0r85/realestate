<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SettingController extends BaseController
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
     * Display the settings layout and different sections
     *
     * @param string $section
     * @return \Illuminate\Http\Response
     */
    public function index($section = 'general')
    {
        $settings = Setting::all();
        return view('settings.' . $section);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function updateGeneral(Request $request)
    {
        $values = $request->except('_token');
        $this->updateSettingsTable($values);

        $this->successMessage('Changes were saved');

        return back();
    }

    /**
     * Update the settings table.
     *
     * @param array $data
     * @return void
     */
    protected function updateSettingsTable($data)
    {
        foreach ($data as $key => $value) {
            if (Setting::where('key', $key)->exists()) {
                $setting = Setting::where('key', $key)->update(['value' => $value]);
            } else {
                $new = new Setting();
                $new->key = $key;
                $new->value = $value;
                $new->save();
            }
        }

        Cache::forget('site.settings');
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

        $data[] = [
            'key' => 'company_logo',
            'value' => $path
        ];

        $this->settings->save($data);
        return back();
    }
}
