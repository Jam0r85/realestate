<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;

class Discount extends Model
{
    use SoftDeletes,
        PresentableTrait;

    /**
     * The presenter for this model.
     * 
     * @var string
     */
    protected $presenter = 'App\Presenters\DiscountPresenter';

    /**
     * The attributes that should be cast to native types.
     * 
     * @var array
     */
    public $cast = [
        'is_percent' => 'boolean'
    ];
}
