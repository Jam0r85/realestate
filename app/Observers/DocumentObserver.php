<?php

namespace App\Observers;

use App\Document;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class DocumentObserver
{
	/**
	 * Listen to the Document creating event.
	 * 
	 * @param \App\Document $document
	 * @return void
	 */
	public function creating(Document $document)
	{
		$document->user_id = Auth::user()->id;
		$document->key = str_random(30);
		$document->extension = File::extension($document->path);
	}
}