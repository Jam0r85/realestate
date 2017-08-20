<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
	/**
	 * A document has a parent.
	 */
    public function parent()
    {
    	return $this->morphTo();
    }
}
