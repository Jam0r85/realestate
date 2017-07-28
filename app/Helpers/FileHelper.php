<?php

function get_file($path)
{
	return Storage::url($path);
	
	if (env('FILESYSTEM_DRIVER') == 'public') {
		return asset('storage/' . $path);
	}

	if (env('FILESYSTEM_DRIVER') == 'local') {
		return Storage::url($path);
	}
}