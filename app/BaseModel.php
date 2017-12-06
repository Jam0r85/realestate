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
			$this->flashMessage('created');
		} else {
			$this->flashMessage('updated');
		}
	}

	/**
	 * Overwrite the Eloquent delete method.
	 * 
	 * @return  void
	 */
	public function delete()
	{
		$this->flashMessage('deleted');
	}

	/**
	 * Flash the message to the screen using the correct message method.
	 * 
	 * @param  string  $name
	 * @return void
	 */
	public function flashMessage($name)
	{
		$method = 'message' . ucwords($name);
		$message = $this->$method();

		if ($message) {
			flash($message)->success();
		}
	}

	/**
	 * Get the model created message.
	 * 
	 * @return  string
	 */
	public function messageCreated()
	{
		return 'New ' . class_basename($this) . ' created';
	}

	/**
	 * Get the model updated message.
	 * 
	 * @return  string
	 */
	public function messageUpdated()
	{
		return class_basename($this) . ' #' . $this->id . ' was updated';
	}

	/**
	 * Get the model deleted message.
	 * 
	 * @return  string
	 */
	public function messageDeleted()
	{
		return class_basename($this) . ' #' . $this->id . ' was deleted';
	}

	/**
	 * Get the model restored message.
	 * 
	 * @return  string
	 */
	public function messageRestored()
	{
		return class_basename($this) . ' #' . $this->id . ' was restored';
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