<?php

namespace App;

use App\Traits\DataTrait;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

class ReminderType extends BaseModel
{
    use DataTrait;
    use PresentableTrait;

    /**
     * The presenter for this model.
     * 
     * @var string
     */
    protected $presenter = 'App\Presenters\ReminderTypePresenter';

    /**
     * The keys to be allowed in the data column.
     * 
     * @var array
     */
    public $dataKeys = [
        'automatic_reminders',
        'frequency',
        'frequency_type'
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
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    public $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'parent_type'
    ];

	/**
	 * A reminder type can have many reminders.
	 */
    public function reminders()
    {
    	return $this
            ->hasMany('App\Reminder');
    }

    /**
     * Get the reminder types for the given parent.
     * 
     * @param  mixed  $parent
     * @return \App\ReminderType
     */
    public function getByParent($parent)
    {
    	if (!$parent) {
    		return $this->get();
    	}

        $parentTypes = [
            model_from_plural($parent),
            plural_from_model($parent)
        ];

    	return $this->whereIn('parent_type', $parentTypes)->get();
    }

    /**
     * Has this reminder type been setup to automatically create reminders?
     * 
     * @return boolean
     */
    public function hasAutoReminders()
    {
        if (!$this->getData('automatic_reminders')) {
            return false;
        }

        if (!$this->getAutoReminderFrequency() || !$this->getAutoReminderFrequencyType()) {
            return false;
        }

        return true;
    }

    /**
     * Get the frequency for automatically creating reminders.
     * 
     * @return string
     */
    public function getAutoReminderFrequency()
    {
        return $this->getData('frequency');
    }

    /**
     * Get the frequency type for automatically creating reminders.
     * 
     * @return string
     */
    public function getAutoReminderFrequencyType()
    {
        return $this->getData('frequency_type');
    }
}
