<?php

namespace App\Traits;

use App\Document;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait DocumentsTrait
{
    /**
     * Get the document path for this expense.
     * We add the ID of the model to the path.
     * 
     * @return string
     */
    public function getDocumentPath()
    {
        $path = rtrim($this->documentPath, '/') ?? 'documents';

        return $path . '/' . $this->id;
    }

    /**
     * Get the document name type.
     * 
     * @return string
     */
    public function getDocumentNameType()
    {
        return $this->documentNameType ?? 'document';
    }

    /**
     * Store a document into storage.
     * 
     * @param string $file
     * @param string $name
     * @return void
     */
    public function storeDocument($file, $name = null)
    {
    	$document = new Document();
    	$document->path = $this->uploadDocument($file);
    	$document->name = $name ?? File::name($document->path);

    	$this->documents()->save($document);
    }

    /**
     * Upload a document.
     * 
     * @param 
     * @return string
     */
    public function uploadDocument($file)
    {
        $path = Storage::putFile($this->getDocumentPath(), $file);
        Storage::setVisibility($path, 'public');

        return $path;
    }

	/**
	 * Eloquent model can have many documents.
	 */
	public function documents()
	{
		return $this
            ->morphMany('App\Document', 'parent')
            ->withTrashed()
			->latest();
	}

    /**
     * Eloquent model can have many public documents.
     */
    public function publicDocuments()
    {
        return $this
            ->morphMany('App\Document', 'parent')
            ->latest();
    }
}