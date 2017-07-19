<?php

namespace App;

class UserGroup extends BaseModel
{
	/**
	 * Indicates if the model should be timestamped.
	 * 
	 * @var bool
	 */
    public $timestamps = false;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug'
    ];

    /**
     * A group can belong to many users.
     */
    public function users()
    {
    	return $this->belongsToMany('App\User');
    }

    /**
     * Scope a query to return a name ordered list of groups.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent
     */
    public function scopeList($query)
    {
        return $query->orderBy('name')->get();
    }

    /**
     * Set the group's slug.
     * 
     * @param   string $value
     * @return  void
     */
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = str_slug($value);
    }
}
