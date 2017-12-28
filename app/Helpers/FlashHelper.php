<?php

    /*
    |--------------------------------------------------------------------------
    | Flash a message to the screen
    |--------------------------------------------------------------------------
    |
    | Flash a custom message to the screen such as an alert.
    |
    */
   
	if (! function_exists('flash_message')) {
	    function flash_message($message = null, $class = 'success')
	    {
	    	if (is_null($message)) {
	    		return null;
	    	}

	    	flash($message)->$class();
	    }
	}