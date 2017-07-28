<?php

namespace App;

class Setting extends BaseModel
{
	/**
	 * Indicates if the model should be timestamped.
	 * 
	 * @var boolean
	 */
	public $timestamps = false;

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
    public function keys()
    {
    	return [
    		'company_name',
            'invoice_default_terms',
            'invoice_default_group',
            'company_bank_account_id',
            'company_logo'
    	];
    }

}
