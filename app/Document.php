<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends BaseModel
{
	use SoftDeletes;

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
	 * A document has a parent.
	 */
    public function parent()
    {
    	return $this->morphTo();
    }
}
