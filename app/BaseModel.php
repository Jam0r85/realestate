<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
	/**
	 * Set the page limit for pagination.
	 * 
	 * @var integer
	 */
	protected $perPage = 30;

	/**
	 * Overwrite the Eloquent save method.
	 * 
	 * @param  array  $options
	 * @return  void
	 */
	public function save (array $options = [])
	{
		// Update settings trait
		if (method_exists($this, 'setSetting')) {
			$this->setSetting(request()->input());
		}

		parent::save($options);

		if ($this->wasRecentlyCreated) {
			flashy()->success($this->getCreatedMessage());
		} else {
			flashy()->success($this->getUpdatedMessage());
		}
	}

	/**
	 * Overwrite the Eloquent delete method.
	 * 
	 * @return  void
	 */
	public function delete()
	{
		flashy()->success($this->getDeletedMessage());
	}

	/**
	 * Get the model created message.
	 * 
	 * @return  string
	 */
	public function getCreatedMessage()
	{
		return 'New ' . $this->classNameSingular() . ' created';
	}

	/**
	 * Get the model updated message.
	 * 
	 * @return  string
	 */
	public function getUpdatedMessage()
	{
		return 'The ' . $this->classNameSingular() . ' #' . $this->id . ' was updated';
	}

	/**
	 * Get the model deleted message.
	 * 
	 * @return  string
	 */
	public function getDeletedMessage()
	{
		return 'The ' . $this->classNameSingular() . ' #' . $this->id . ' was deleted';
	}

	/**
	 * Get the model restored message.
	 * 
	 * @return  string
	 */
	public function getRestoredMessage()
	{
		return $this->classNameSingular() . ' #' . $this->id . ' was restored';
	}

	/**
	 * Get the class name.
	 * 
	 * @return string
	 */
	public function className()
	{
		return strtolower(class_basename($this));
	}

	/**
	 * Get the singular class name.
	 * 
	 * @return string
	 */
	public function classNameSingular()
	{
		return str_singular($this->className());
	}

	/**
	 * Get the singular class name.
	 * 
	 * @return string
	 */
	public function classNamePlural()
	{
		return str_plural($this->className());
	}
}