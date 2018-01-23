<?php

namespace App;

use App\Note;
use App\Property;
use App\Tenancy;
use App\Traits\DataTrait;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;
use Laravel\Scout\Searchable;

class Maintenance extends BaseModel
{
	use SoftDeletes,
		DataTrait,
		Filterable,
		Searchable,
        PresentableTrait;

    /**
     * The presenter for this model.
     * 
     * @var string
     */
    protected $presenter = 'App\Presenters\MaintenancePresenter';

    /**
     * The keys allowed in the data column.
     * 
     * @var array
     */
    public $dataKeys = [
    	//
  	];

    /**
     * Get the indexable data array for the model.
     *
     * @return  array
     */
    public function toSearchableArray()
    {
        return $this->only(
        	'name',
        	'description'
        );
    }

    /**
     * The attributes that should be cast to native types.
     * 
     * @var array
     */
    protected $casts = [
        'data' => 'array'
   ];

    /**
     * The attributes that should be mutated to dates.
     * 
     * @var array
     */
    protected $dates = [
        'completed',
        'deleted_at'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'property_id',
        'tenancy_id',
        'name',
        'description',
        'data'
    ];

    /**
     * A maintenance issue belongs to a property.
     */
    public function property()
    {
        return $this
            ->belongsTo(Property::class);
    }

    /**
     * A maintenance issue belongs to a tenancy.
     */
    public function tenancy()
    {
        return $this
            ->belongsTo(Tenancy::class);
    }

    /**
     * A maintenance issue can have many notes.
     */
    public function notes()
    {
        return $this
            ->morphMany(Note::class, 'parent')
            ->latest();
    }

    /**
     * Store a note to this maintenance issue.
     * 
     * @param  \App\Note  $issue
     * @return \App\Note
     */
    public function storeNote(Note $note)
    {
        $note->property_id = $this->property_id;

        return $this->notes()->save($note);
    }
}
