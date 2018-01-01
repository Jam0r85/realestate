<?php

function get_file($path)
{	
	if (config('filesystems.default') == 'public') {
		return Storage::disk('public')->url($path);
	}

	return Storage::url($path);
}

function file_name($file)
{
	return basename($file);
}