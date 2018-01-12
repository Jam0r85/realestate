<?php

namespace App;

class Setting extends BaseModel
{
    /**
     * primaryKey 
     * 
     * @var integer
     * @access protected
     */
    protected $primaryKey = null;

    /**
     * Set the public key column to null.
     * 
     * @var null
     */
    public $publicKeyColumn = null;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

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
        'default_country'
    ];

    /**
     * Overwrite the updated message.
     * 
     * @return  string
     */
    public function messageUpdated()
    {
        return 'Setting <b>' . ucfirst(str_replace('_', ' ', $this->key)) . '</b> was updated';
    }

    /**
     * Overwrite the updated message.
     * 
     * @return  string
     */
    public function messageCreated()
    {
        return 'Setting <b>' . ucfirst(str_replace('_', ' ', $this->key)) . '</b> was created';
    }
}
