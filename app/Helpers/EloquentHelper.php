<?php

	function parentModel($value = null)
	{
		if (!$value) {
			return null;
		}

		return studly_case(str_singular($value));
	}

    /*
    |--------------------------------------------------------------------------
    | Plural from Model
    |--------------------------------------------------------------------------
    |
    | Turns a model name into it's plural form which can used for views or
    | links. For example 'App\User' would become 'users'
    |
    */
   
	if (! function_exists('plural_from_model')) {
	    function plural_from_model($model = null)
	    {
	    	if (is_null($model)) {
	    		return null;
	    	}

	        $plural = str_plural(class_basename($model));

	        return kebab_case($plural);
	    }
	}

	/*
    |--------------------------------------------------------------------------
    | Model from Plural
    |--------------------------------------------------------------------------
    |
    | The alternative to the above, returning the model name from the given
    | plural string. For example 'users' would become 'User'
    |
    */
   
	if (! function_exists('model_from_plural')) {
	    function model_from_plural($plural)
	    {
	    	return str_singular(studly_case($plural));
	    }
	}

	/*
    |--------------------------------------------------------------------------
    | Model Name
    |--------------------------------------------------------------------------
    |
    | Return the model name from the given model.
    |
    */
   
	if (! function_exists('model_name')) {
	    function model_name($model = null)
	    {
	    	if (is_null($model)) {
	    		return null;
	    	}

	    	return class_basename($model);
	    }
	}