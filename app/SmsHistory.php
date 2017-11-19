<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmsHistory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sms_history';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','recipient_id','phone_number','body','messages'];

    /**
     * The attributes that should be cast to native types.
     * 
     * @var array
     */
    protected $casts = ['messages' => 'array'];

    /**
     * The nexmo message statuses as taken from their API.
     * 
     * @var array
     */
    protected $statuses = [
        '0' => [
            'value' => 'Sent',
            'class' => 'success'
        ],
        '1' => [
            'value' => 'Throttled',
            'class' => 'warning'
        ],
    ];

    /**
     * The user that this SMS was sent to.
     */
    public function recipient()
    {
    	return $this->belongsTo('App\User', 'recipient_id');
    }

    /**
     * The user who sent this SMS message.
     */
    public function owner()
    {
    	return $this->belongsTo('App\User');
    }

    /**
     * The replies to this message.
     */
    public function replies()
    {
        return $this->hasMany('App\SmsHistory', 'parent_id');
    }

    /**
     * Get the status of the message.
     * 
     * @return string
     */
    public function status($return = 'value')
    {
        $status = $this->statuses[0];

        foreach ($this->messages as $message) {
            return $this->statuses[$message['status']][$return];
        }

        return $status[$return];
    }
}