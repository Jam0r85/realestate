<?php

namespace App;

use App\Property;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;
use Laravel\Scout\Searchable;

class Note extends BaseModel
{
	use SoftDeletes,
		Searchable,
		PresentableTrait;

    /**
     * The presenter for this model.
     * 
     * @var string
     */
    protected $presenter = 'App\Presenters\NotePresenter';

	/**
	 * The attributes that are mass assignable.
	 * 
	 * @var array
	 */
	protected $fillable = [
		'body'
	];

    /**
     * Get the indexable data array for the model.
     *
     * @return  array
     */
    public function toSearchableArray()
    {
    	$array = $this->only('note');
    	$array['user'] = $this->user->present()->fullName;

    	return $array;
    }

	/**
	 * A note belongs to a parent.
	 */
    public function parent()
    {
    	return $this
    		->morphTo();
    }

    public function property()
    {
    	return $this
    		->belongsTo(Property::class)
    		->withTrashed();
    }

    /**
     * A note belongs to a user.
     */
    public function user()
    {
    	return $this
    		->belongsTo(User::class)
    		->withTrashed();
    }
}
