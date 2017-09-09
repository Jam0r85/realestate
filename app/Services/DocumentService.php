<?php

namespace App\Services;

use App\Document;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentService
{
	public $storage_folder = 'documents/';

	/**
	 * Create a new document.
	 * 
	 * @param array $data
	 * @param Eloquent $model
	 * @param string $parent
	 * @return \App\Document
	 */
	public function createDocument(array $data)
	{
        $document = new Document();
        $document->user_id = Auth::user()->id;
        $document->key = str_random(30);
        $document->fill($data);

        return $document;
	}

	/**
	 * Store a file.
	 * 
	 * @param string $file
	 * @param string $path
	 * @return string
	 */
	public function storeFile($file, $folder = null)
	{
		if ($folder) {
			$this->storage_folder = $this->storage_folder . $folder;
		}

		$document['path'] = Storage::putFile($this->storage_folder, $file);
		$document['extension'] = $file->getClientOriginalExtension();

		return $document;
	}

	/**
	 * Retreive and download a document from storage.
	 * 
	 * @param integer $id
	 * @return
	 */
	public function downloadDocument($id)
	{
		$document = Document::findOrFail($id);
		return true;
	}

	/**
	 * Update a document in storage.
	 * 
	 * @param array $data
	 * @param integer $id
	 * @return void
	 */
	public function updateDocument($data, $id)
	{
		$document = Document::findOrFail($id);
		$document->fill($data);
		$document->save();
	}

	/**
	 * Delete a document from storage.
	 * 
	 * @param integer $id
	 * @return void
	 */
	public function deleteDocument($id, $file = false)
	{
		$document = Document::findOrFail($id);

		// Delete the file from storage
		if ($file == true) {
			Storage::delete($document->path);
		}

		$document->delete();
	}
}