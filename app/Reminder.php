<?php

namespace App;

use App\Traits\DataTrait;
use Illuminate\Database\Eloquent\Model;

class Reminder extends BaseModel
{
    use DataTrait;

    /**
     * The attributes that should be cast to native types.
     * 
     * @var array
     */
    public $casts = [
        'data' => 'array'
    ];

    /**
     * A reminder has a type.
     */
    public function type()
    {
        return $this
            ->belongsTo('App\ReminderType');
    }

	/**
	 * A reminder has a parent model.
	 */
    public function parent()
    {
    	return $this
            ->morphTo();
    }

    /**
     * A reminder was created by a user.
     */
    public function owner()
    {
    	return $this
            ->belongsTo('App\User', 'user_id');
    }
}
