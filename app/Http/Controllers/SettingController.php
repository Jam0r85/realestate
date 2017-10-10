<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyTaxRateRequest;
use App\Http\Requests\RestoreTaxRateRequest;
use App\Http\Requests\StoreTaxRateRequest;
use App\Http\Requests\UpdateTaxRateRequest;
use App\Setting;
use App\TaxRate;
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
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

    /**
     * Display the list of tax rates.
     * 
     * @return \Illuminate\Http\Response
     */
    public function taxRates()
    {
        $rates = TaxRate::withTrashed()->get();
        return view('settings.tax-rates.list', compact('rates'));
    }

    /**
     * Store a new tax rate.
     * 
     * @param \App\Http\Requests\StoreTaxRate $request]
     * @return \Illuminate\Http\Response
     */
    public function storeTaxRate(StoreTaxRateRequest $request)
    {
        $rate = new TaxRate();
        $rate->name = $request->name;
        $rate->amount = $request->amount;
        $rate->save();

        Cache::tags('tax_rates')->flush();

        $this->successMessage('The tax rate "' . $rate->name . '" was created');

        return back();
    }

    /**
     * Show the form for editing a tax rate.
     * 
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function editTaxRate($id)
    {
        $rate = TaxRate::withTrashed()->findOrFail($id);
        return view('settings.tax-rates.edit', compact('rate'));
    }

    /**
     * Update a tax rate.
     * 
     * @param \App\http\Requests\UpdateTaxRateRequest $request
     * @param integer $id
     * @return \Illuminate\Http\Request
     */
    public function updateTaxRate(UpdateTaxRateRequest $request, $id)
    {
        $rate = TaxRate::withTrashed()->findOrFail($id);
        $rate->name = $request->name;
        $rate->save();

        $this->successMessage('The changes were saved');

        return back();
    }

    /**
     * Destroy a tax rate.
     * 
     * @param \App\Http\Requests\DestroyTaxRateRequest $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function destroyTaxRate(DestroyTaxRateRequest $request, $id)
    {
        $rate = TaxRate::findOrFail($id);
        $rate->delete();

        Cache::tags('tax_rates')->flush();

        $this->successMessage('The tax rate "' . $rate->name . '" was deleted');

        return back();
    }

    /**
     * Restore a tax rate.
     * 
     * @param \App\Http\Requests\RestoreTaxRateRequest $request
     * @param integer $id
     * @return \Illuminate\Http\Response
     */
    public function restoreTaxRate(RestoreTaxRateRequest $request, $id)
    {
        $rate = TaxRate::onlyTrashed()->findOrFail($id);
        $rate->restore();

        Cache::tags('tax_rates')->flush();

        $this->successMessage('The tax rate "' . $rate->name . '" was restored');

        return back();
    }
}
