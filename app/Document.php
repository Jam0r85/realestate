<?php

namespace App;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;
use Laracasts\Presenter\PresentableTrait;
use Laravel\Scout\Searchable;

class Document extends BaseModel
{
	use SoftDeletes;
    use PresentableTrait;
    use Filterable;
    use Searchable;

    /**
     * The presenter for this model.
     * 
     * @var string
     */
    protected $presenter = 'App\Presenters\DocumentPresenter';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = [
		'name',
		'path',
		'extension'
	];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

	/**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->extension = File::extension($model->path);
        });
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return  array
     */
    public function toSearchableArray()
    {
        $array = $this->only('name');

        if (model_name($this->parent) == 'Expense') {
            $array['parent_name'] = $this->parent->name;
        }

        return $array;
    }

	/**
	 * A document has a parent.
	 */
    public function parent()
    {
    	return $this
            ->morphTo();
    }
}
