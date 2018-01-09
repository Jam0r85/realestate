<?php

namespace App;

use App\Agreement;
use App\Events\StatementWasCreated;
use App\Statement;
use App\TenancyRent;
use Carbon\Carbon;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Laracasts\Presenter\PresentableTrait;
use Laravel\Scout\Searchable;

class Tenancy extends BaseModel
{
    use SoftDeletes,
        Searchable,
        PresentableTrait,
        Filterable;

    /**
     * The presenter for this model.
     * 
     * @var string
     */
    protected $presenter = 'App\Presenters\TenancyPresenter';    

    /**
     * Get the indexable data array for the model.
     *
     * @return  array
     */
    public function toSearchableArray()
    {
        $array = $this->only('vacated_on');
        $array['name'] = $this->present()->name;
        $array['property'] = $this->property->present()->fullAddress;
        $array['rent'] = $this->present()->rentAmountPlain;
        $array['started'] = $this->first_agreement ? $this->first_agreement->starts_at : null;
        $array['landlords'] = $this->property->owners->pluck('name');
        $array['service'] = $this->service->name;

        return $array;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = [
		'property_id',
		'service_id',
        'is_overdue',
		'vacated_on',
        'rent_balance',
        'started_on'
	];

    /**
     * The attributes that should be mutated to dates.
     * 
     * @var array
     */
    protected $dates = [
        'started_on',
        'vacated_on',
        'deleted_at'
    ];

    /**
     * The attributes that should be eager loaded.
     * 
     * @var array
     */
    protected $with = [
        'users',
        'property'
    ];

    /**
     * Scope a query to include eager loading dependencies.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return  \Illuminate\Database\Eloquent
     */
    public function scopeEagerLoading($query)
    {
        return $query
            ->with('property','currentRent','service','deposit','rent_payments','statements');
    }

    /**
     * Scope a query to only include tenancies which are archive.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return  \Illuminate\Database\Eloquent
     */
    public function scopeArchived($query)
    {
        return $query
            ->eagerLoading()
            ->onlyTrashed();
    }

    /**
     * Scope a query to only include tenancies which are overdue.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return  \Illuminate\Database\Eloquent
     */
    public function scopeOverdue($query)
    {
        return $query
            ->eagerLoading()
            ->where('is_overdue', '>', '0')
            ->orderBy('is_overdue', 'desc');
    }

    /**
     * Scope a query to only include tenancies which have a positive rent amount.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return  \Illuminate\Database\Eloquent
     */
    public function scopeHasRent($query)
    {
        return $query
            ->eagerLoading()
            ->where('rent_balance', '>', 0)
            ->orderBy('rent_balance', 'desc');
    }

    /**
     * Scope a query to only include tenancies which have a negative rent amount.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return  \Illuminate\Database\Eloquent
     */
    public function scopeOwesRent($query)
    {
        return $query
            ->eagerLoading()
            ->where('rent_balance', '<', 0)
            ->orderBy('rent_balance');
    }

    /**
     * Scope a query to only include tenancies which have a deposit but wrong deposit balance.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return  \Illuminate\Database\Eloquent
     */
    public function scopeOwesDeposit($query)
    {
        return $query
            ->eagerLoading()
            ->whereHas('deposit', function ($query) {
                $query->where('balance', '!=', 'amount');
            });
    }

    /**
     * Scope a query to only include tenancies which are active.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return  \Illuminate\Database\Eloquent
     */
    public function scopeActive($query)
    {
        return $query
            ->eagerLoading()
            ->whereNull('vacated_on')
            ->orWhere('vacated_on', '>', Carbon::now());
    }

    /**
     * Scope a query to only include tenancies which have been vacated.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return  \Illuminate\Database\Eloquent
     */
    public function scopeVacated($query)
    {
        return $query
            ->eagerLoading()
            ->where('vacated_on', '<=', Carbon::now());
    }

	/**
	 * The property that this tenancy belongs to.
	 */
    public function property()
    {
    	return $this
            ->belongsTo('App\Property')
            ->withTrashed();
    }

    /**
     * The rent amounts that this tenancy has.
     */
    public function rents()
    {
    	return $this
            ->hasMany('App\TenancyRent')
            ->withTrashed()
            ->latest('starts_at');
    }

    /**
     * The current rent amount of this tenancy.
     */
    public function currentRent()
    {
        return $this
            ->hasOne('App\TenancyRent')
            ->where('starts_at', '<=', Carbon::now())
            ->latest('starts_at');
    }

    /**
     * The tenants of the tenancy.
     */
    public function users()
    {
    	return $this
            ->belongsToMany('App\User');
    }

    /**
     * The rent payments for this tenancy.
     */
    public function rent_payments()
    {
    	return $this
            ->morphMany('App\Payment', 'parent')
            ->latest();
    }

    /**
     * The latest rent payment for this tenancy.
     */
    public function latestRentPayment()
    {
        return $this
            ->rent_payments
            ->first();
    }

    /**
     * A tenancy can have many rental statements.
     */
    public function statements()
    {
        return $this
            ->hasMany('App\Statement')
            ->latest('period_start');
    }

    /**
     * A tenancy can have a latest rental statement.
     */
    public function latestStatement()
    {
        return $this
            ->hasOne('App\Statement')
            ->latest('period_start');
    }

    /**
     * The tenancy agreements for this tenancy.
     */
    public function agreements()
    {
        return $this
            ->hasMany('App\Agreement')
            ->withTrashed()
            ->latest('starts_at');
    }

    /**
     * A tenancy can have many pending agreements.
     */
    public function pendingAgreements()
    {
        return $this
            ->hasMany('App\Agreement')
            ->where('starts_at', '>', Carbon::now())
            ->latest('starts_at');
    }

    /**
     * The current agreement for this tenancy.
     */
    public function currentAgreement()
    {
        return $this
            ->hasOne('App\Agreement')
            ->where('starts_at', '<=', Carbon::now())
            ->whereNull('deleted_at');
    }

    /**
     * The first agreement for this tenancy.
     */
    public function firstAgreement()
    {
        return $this
            ->hasOne('App\Agreement')
            ->oldest('starts_at');
    }

    /**
     * A tenancy can belong to a service.
     */
    public function service()
    {
        return $this
            ->belongsTo('App\Service');
    }

    /**
     * A tenancy has an owner.
     */
    public function owner()
    {
        return $this
            ->belongsTo('App\User', 'user_id');
    }

    /**
     * A tenancy belongs to a branch.
     */
    public function branch()
    {
        return $this
            ->property
            ->branch;
    }

    /**
     * A tenancy can belong to many discounts.
     */
    public function discounts()
    {
        return $this
            ->belongsToMany('App\Discount')
            ->withPivot('for');
    }

    /**
     * A tenancy can have many service discounts applied to it.
     */
    public function serviceDiscounts()
    {
        return $this
            ->belongsToMany('App\Discount')
            ->wherePivot('for', 'service');
    }

    /**
     * A tenancy can have a single deposit.
     */
    public function deposit()
    {
        return $this
            ->hasOne('App\Deposit');
    }

    /**
     * Get the service charge net amount for this tenancy by multiplying
     * the current rent amount with the calculated service charge.
     * 
     * @return integer
     */
    public function getServiceChargeNetAmount($rentAmount = null)
    {
        if (is_null($rentAmount)) {
            $rentAmount = $this
                ->present()
                ->rentAmountPlain;
        }

        return $rentAmount * $this->getServiceChargeWithDiscounts();
    }

    /**
     * Get the service charge including discounts applied for this tenancy.
     * 
     * @return int
     */
    public function getServiceChargeWithDiscounts()
    {
        if ($this->service) {
            return $this->service->charge - $this->serviceDiscounts->sum('amount');
        }
    }

    /**
     * Get the tenancy start date.
     * 
     * @return string
     */
    public function getStartedAtAttribute()
    {
        if ($this->firstAgreement) {
            return $this->firstAgreement->starts_at;
        }

        return null;
    }

    /**
     * Get the tenancy landlord names in a readable format.
     * 
     * @return string
     */
    public function getLandlordNameAttribute()
    {
        if (count($this->landlords)) {
            foreach ($this->landlords as $landlord) {
                $names[] = $landlord->name;
            }
            return implode(' & ', $names);
        }

        return null;
    }

    /**
     * Get the landlord's address for this tenancy.
     */
    public function getLandlordAddressAttribute()
    {
        if (count($this->landlords)) {
            return $this->landlords->first()->home;
        }

        return null;
    }

    /**
     * Check whether the tenancy is managed or not.
     * 
     * @return boolean
     */
    public function isManaged()
    {
        if (!$this->service) {
            return false;
        }

        // Do we have a service charge?
        if ($this->service->charge == 0) {
            return false;
        }

        // Have the tenants vacated the tenancy?
        if ($this->vacated_on) {
            return false;
        }

        return true;
    }

    /**
     * Check whether this tenancy allows new statements.
     * 
     * @return bool
     */
    public function canCreateStatement()
    {
        // Rent balance is less than the rent amount required.
        if ($this->rent_balance < $this->rent_amount) {
            return false;
        }

        // Tenancy is trashed.
        if ($this->trashed()) {
            return false;
        }

        return true;
    }

    /**
     * Check whether you can record new rent payments for this tenancy.
     * 
     * @return bool
     */
    public function canRecordRentPayment()
    {
        // Tenancy is trashed.
        if ($this->trashed()) {
            return false;
        }

        return true;
    }

    /**
     * Check whether the tenancy is overdue.
     *
     * @param  int  $overdue
     * @return int
     */
    public function checkWhetherOverdue($overdue = 0)
    {
        if (!$this->hasVacated()) {

            if ($this->isManaged()) {

                // Secondly make sure there have been previous rental statements.
                if ($this->latestStatement) {

                    $overdueCheckDate = $this->latestStatement->period_end->addDay();

                    // Check whether the next statement date has been passed.
                    if ($overdueCheckDate < Carbon::now()) {
                        $overdue = $this->latestStatement->period_end->diffInDays(Carbon::now());
                    }
                }
            }
        }

        return $overdue;
    }

    /**
     * Set and store whether this tenancy is overdue.
     */
    public function setOverdue($save = true)
    {
        $this->is_overdue = $this->checkWhetherOverdue();

        if ($save == true) {
            $this->save();
        }

        return $this;
    }

    /**
     * Check whether this tenancy has a custom letting fee by looking
     * for the setting in the property owners.
     * 
     * @return boolean
     */
    public function hasCustomUserLettingFee()
    {
        if (count($this->getCustomUserLettingFees())) {
            return true;
        }

        return false;
    }

    /**
     * Get the custom letting fees for this tenancy from it's owners.
     * 
     * @return array
     */
    public function getCustomUserLettingFees()
    {
        $fees = [];

        foreach ($this->property->owners as $user) {
            if ($amount = $user->getSetting('tenancy_service_letting_fee')) {
                $fees[] = [
                    'user_name' => $user->name,
                    'user_id' => $user->id,
                    'amount' => $amount
                ];
            }
        }

        return $fees;
    }

    /**
     * Check whether this tenancy has a custom re-letting fee by looking
     * for the setting in the property owners.
     * 
     * @return boolean
     */
    public function hasCustomUserReLettingFee()
    {
        if (count($this->getCustomUserReLettingFees())) {
            return true;
        }

        return false;
    }

    /**
     * Get the custom re-letting fees for this tenancy from it's owners.
     * 
     * @return array
     */
    public function getCustomUserReLettingFees()
    {
        $fees = [];

        foreach ($this->property->owners as $user) {
            if ($amount = $user->getSetting('tenancy_service_re_letting_fee')) {
                $fees[] = [
                    'user_name' => $user->name,
                    'user_id' => $user->id,
                    'amount' => $amount
                ];
            }
        }

        return $fees;
    }

    /**
     * Get this tenancy's letting fee.
     * 
     * @return  int
     */
    public function getLettingFee($custom = false)
    {
        // Check we have a service assigned
        if ($this->service) {

            // Set the default fee to the service letting fee
            $defaultFee = $this->service->letting_fee;

            // Do we want to check for custom letting fees?
            if ($custom == true) {
                // Does this tenancy have a property and owners?
                if ($this->property && count($this->property->owners)) {
                    // Loop through each of the owners
                    foreach ($this->property->owners as $user) {
                        // Set the custom fee to the one in the user's settings
                        $customFee = $user->getSetting('tenancy_service_letting_fee');
                    }
                }
            }

            return $customFee ?? $defaultFee;
        }
    }

    /**
     * Get the letting fee or custom fee instead.
     * 
     * @return  int
     */
    public function getLettingFeeWithCustom()
    {
        return $this->getLettingFee(true);
    }

    /**
     * Get this tenancy's re-letting fee.
     * 
     * @return  int
     */
    public function getReLettingFee($custom = false)
    {
        // Check we have a service assigned
        if ($this->service) {

            // Set the default fee to the service letting fee
            $defaultFee = $this->service->re_letting_fee;

            // Do we want to check for custom letting fees?
            if ($custom == true) {
                // Does this tenancy have a property and owners?
                if ($this->property && count($this->property->owners)) {
                    // Loop through each of the owners
                    foreach ($this->property->owners as $user) {
                        // Set the custom fee to the one in the user's settings
                        $customFee = $user->getSetting('tenancy_service_re_letting_fee');
                    }
                }
            }

            return $customFee ?? $defaultFee;
        }
    }

    /**
     * Get the re letting fee with custom fee included.
     * 
     * @return  int
     */
    public function getReLettingFeeWithCustom()
    {
        return $this->getReLettingFee(true);
    }

    /**
     * Store an old statement to this tenancy.
     * 
     * @param  Statement $statement [description]
     * @return \App\Statement
     */
    public function storeOldStatement(Statement $statement)
    {
        return $this->storeStatement($statement, true);
    }

    /**
     * Store a statement to this tenancy.
     * 
     * @param  \App\Statement  $statement
     * @param  bool  $old
     * @return \App\Statement
     */
    public function storeStatement(Statement $statement, $old = false)
    {
        // Save the statement
        $this->statements()->save($statement);

        // Attach property owners to the statement
        $statement->users()->attach($this->property->owners);

        if ($old == false) {
            if ($statement->needsInvoiceCheck()) {
                $invoice = new Invoice();
                $invoice->property_id = $this->property->id;
                $invoice = $statement->storeInvoice($invoice);
            }
        }

        event(new StatementWasCreated($statement));

        return $statement;
    }

    /**
     * Store a rent amount to this tenancy.
     * 
     * @param  \App\TenancyRent  $rent  the rent amount we are storing.
     * @return \App\TenancyRent
     */
    public function storeRentAmount(TenancyRent $rent)
    {
        return $this->rents()->save($rent);
    }

    /**
     * Store an agreement to this tenancy.
     * 
     * @param  \App\Agreement  $agreement
     * @return \App\Agreement
     */
    public function storeAgreement(Agreement $agreement)
    {
        return $this
            ->agreements()
            ->save($agreement);
    }

    /**
     * Store a rent payment to this tenancy.
     * 
     * @param  \App\Payment  $payment
     * @return  \App\Payment
     */
    public function storeRentPayment(Payment $payment)
    {
        // Store the payment as a rent payment
        $this->
            rent_payments()
            ->save($payment);

        // Make sure we attach the tenants to this payment
        $payment
            ->users()
            ->attach($this->users);

        return $payment;
    }

    /**
     * Is this tenancy active?
     * 
     * @return boolean
     */
    public function isActive()
    {
        if ($this->vacated_on && $this->vacated_on < Carbon::now()) {
            return false;
        }

        return true;
    }

    /**
     * Get the rent payments total income for this tenancy.
     * 
     * @return  int
     */
    public function getRentPaymentsReceivedTotal()
    {
        return $this->rent_payments->sum('amount');
    }

    /**
     * Get the statements total for this tenancy.
     * 
     * @return  int
     */
    public function getStatementsTotal()
    {
        return $this->statements->sum('amount');
    }

    /**
     * Get the rent balance for this tenancy.
     * 
     * @return  int
     */
    public function getRentBalance()
    {
        return $this->getRentPaymentsReceivedTotal() - $this->getStatementsTotal();
    }

    /**
     * Update the rent balance held for this tenancy.
     * 
     * @return void
     */
    public function updateRentBalance()
    {
        $this->rent_balance = $this->getRentBalance();
        $this->saveWithMessage('balances updated');
    }

    /**
     * Has this tenancy vacated?
     * 
     * @return boolean
     */
    public function hasVacated()
    {
        if ($this->vacated_on && $this->vacated_on <= Carbon::now()) {
            return true;
        }

        return false;
    }
}
