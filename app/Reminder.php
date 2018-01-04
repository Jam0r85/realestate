<?php

namespace App;

use App\Traits\DataTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reminder extends BaseModel
{
    use SoftDeletes;
    use DataTrait;

    /**
     * The keys to be allowed in the data column.
     * 
     * @var array
     */
    public $dataKeys = [
        //
    ];

    /**
     * The attributes that should be cast to native types.
     * 
     * @var array
     */
    public $casts = [
        'data' => 'array'
    ];

    /**
     * The attributes that should be mutated to dates.
     * 
     * @var array
     */
    public $dates = [
        'due_at',
        'deleted_at'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'reminder_type_id',
        'data',
        'due_at'
    ];

    /**
     * A reminder has a type.
     */
    public function reminderType()
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
