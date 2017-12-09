<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFailedLogin extends Model
{
    public $casts = [
    	'request' => 'array'
   	];
}
