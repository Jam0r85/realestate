<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyLogoRequest;
use App\Http\Requests\DestroyTaxRateRequest;
use App\Http\Requests\RestoreTaxRateRequest;
use App\Http\Requests\StoreTaxRateRequest;
use App\Http\Requests\UpdateLogoRequest;
use App\Http\Requests\UpdateTaxRateRequest;
use App\Setting;
use App\TaxRate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class SettingController extends BaseController
{
    /**
     * The eloquent model for this controller.
     * 
     * @var string
     */
    public $model = 'App\Setting';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($show = 'index')
    {
        $settings = $this->repository
            ->all();

        return view('settings.index', compact('settings','show'));
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
        $data = $request->except('_token','_method');

        foreach ($data as $key => $value) {

            $setting = $this->repository
                ->where('key', $key)
                ->first();

            if ($setting) {

                $setting = $this->repository
                    ->where('key', $key)
                    ->update(['value' => $value]);

            } else {

                $this->repository
                    ->create(['key' => $key, 'value' => $value]);
            }
        }

        Cache::forget('app_settings');

        flash_message('The settings were updated');

        return back();
    }

    /**
     * Update the logo.
     *
     * @param \App\Http\Requests\UpdateLogoRequest $request
     * @return \Illuminate\Http\Request
     */
    public function uploadLogo(UpdateLogoRequest $request)
    {
        // The path we are storing logos
        $folder_path = 'logos';
 
        // Store the logo as it is
        $path = $request->file('company_logo')->store($folder_path);

        // Set the visability to public
        Storage::setVisibility($path, 'public');

        // Get the new hashed file name of the logo
        $file_name = file_name($path);

        // Create a path and name for the smaller logo
        $small_logo_path = 'logos/small/' . $file_name;

        // Copy the original logo and resize it
        if (Storage::copy($path, $small_logo_path)) {
            Image::make(Storage::get($small_logo_path))
                ->resize(null, 300, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

            // Set the visability to public
            Storage::setVisibility($small_logo_path, 'public');
        }

        if ($this->repository->where('key', 'company_logo')->count()) {
            $this->repository
                ->where('key', 'company_logo')
                ->update(['value' => $path]);
        } else {
            $this->repository
                ->create(['key' => 'company_logo', 'value' => $path]);
        }

        if ($this->repository->where('key', 'company_logo_small')->count()) {
            $this->repository
                ->where('key', 'company_logo_small')
                ->update(['value' => $small_logo_path]);
        } else {
            $this->repository
                ->create(['key' => 'company_logo_small', 'value' => $small_logo_path]);
        }

        Cache::forget('app_settings');

        flash_message('The logo was uploaded');

        return back();
    }

    /**
     * Destroy the logo.
     * 
     * @param \App\Http\Requests\DestroyLogoRequest $request
     * @return \Illuminate\Http\Response
     */
    public function destroyLogo(DestroyLogoRequest $request)
    {
        if (Storage::exists(get_setting('company_logo'))) {
            Storage::delete(get_setting('company_logo'));
        } else {
            $this->errorMessage('The logo file could not be found');
        }

        if (!Storage::exists(get_setting('company_logo'))) {
            Setting::where('key', 'company_logo')
                ->update(['value' => null]);

            $this->successMessage('The logo was removed');
        } else {
            $this->errorMessage('The logo file still exists and the settings could not be updated');
        }

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
