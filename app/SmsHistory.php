<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use Laravel\Scout\Searchable;

class SmsHistory extends Model
{
    use Searchable;
    use PresentableTrait;

    /**
     * The presenter for this model.
     * 
     * @var string
     */
    protected $presenter = 'App\Presenters\SmsPresenter';

    /**
     * Get the indexable data array for the model.
     *
     * @return  array
     */
    public function toSearchableArray()
    {
        $array = $this->only('body');
        $array['recipient'] = $this->recipient->present()->fullName;
        $array['sender'] = $this->owner ? $this->owner->present()->fullName : null;
        $array['phone_number'] = [
            $this->phone_number,
            $this->recipient->phone_number
        ];

        return $array;
    }

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
     * The nexmo message status codes as taken from their API.
     * 
     * @var array
     */
    protected $statusCodes = [
        '0' => [
            'value' => 'Sending',
            'class' => 'info'
        ],
        '1' => [
            'value' => 'Throttled',
            'class' => 'warning'
        ],
    ];

    /**
     * The nexmo message status messages as taken from their API.
     * 
     * @var array
     */
    protected $statusMessages = [
        'delivered' => [
            'value' => 'Delivered',
            'class' => 'success'
        ],
        'expired' => [
            'value' => 'Expired',
            'class' => 'danger'
        ],
        'failed' => [
            'value' => 'Failed',
            'class' => 'danger'
        ],
        'rejected' => [
            'value' => 'Rejected',
            'class' => 'warning'
        ],
        'accepted' => [
            'value' => 'Accepted',
            'class' => 'info'
        ],
        'buffered' => [
            'value' => 'Buffered',
            'class' => 'info'
        ],
        'unknown' => [
            'value' => 'Unknown',
            'class' => 'warning'
        ]
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
    	return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * The replies to this message.
     */
    public function replies()
    {
        return $this->hasMany('App\SmsHistory', 'parent_id');
    }

    /**
     * Get the message IDs linked to this message.
     * 
     * @return string
     */
    public function getMessageIds()
    {
        if ($this->messages) {
            foreach ($this->messages as $message) {
                if (array_has($message, 'message-id')) {
                    $ids[] = $message['message-id'];
                } elseif (array_has($message, 'messageId')) {
                    $ids[] = $message['messageId'];
                }
            }

            return $ids;
        }
    }

    /**
     * Get the status of the message.
     * 
     * @return string
     */
    public function status($return = 'value')
    {
        if ($this->messages) {
            // Loop through the messages
            foreach ($this->messages as $message) {

                if (is_numeric($message['status'])) {
                    return $this->statusCodes[$message['status']][$return];
                }

                return $this->statusMessages[$message['status']][$return];
            }
        }
    }
}