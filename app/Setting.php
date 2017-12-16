<?php

namespace App;

class Setting extends BaseModel
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key', 'value'
    ];

    /**
     * List of setting keys that can be updated.
     * 
     * @return array
     */
    public static $allowedKeys = [
		'company_name',
        'company_user_id',
        'company_bank_account_id',
        'company_logo',
        'invoice_default_terms',
        'invoice_default_group',
        'default_tax_rate_id',
    ];

    /**
     * Overwrite the updated message.
     * 
     * @return  string
     */
    public function messageUpdated()
    {
        return 'Setting ' . studly_case($this->key) . ' was updated';
    }

}
