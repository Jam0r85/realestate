<?php

namespace App;

use Illuminate\Support\Facades\Storage;

class FileModel extends BaseModel
{
	/**
	 * The folder path for storing files.
	 * 
	 * @return string
	 */
	public function storagePath()
	{
		if (!$this->storageFolder) {
			$this->storageFolder = $this->classNamePlural();
		}

		return $this->storageFolder;
	}

	/**
	 * The default file name to use when storing the file.
	 * 
	 * @param string $fileType
	 * @return string
	 */
	public function storageFileName($fileType = '.pdf')
	{
		if (!$this->fileName) {
			$this->storageFileName = $this->id . '/' . $this->updated_at->toIso8601String() . $fileType;
		}

		return $this->storageFileName;
	}

	/**
	 * The combined folder path and file name for the file.
	 * 
	 * @return string
	 */
	public function storageFileNameWithPath()
	{
		return $this->storagePath() . '/' . $this->storageFileName();
	}
}