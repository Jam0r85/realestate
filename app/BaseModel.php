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
	 * Save an Eloquent model but overwrite the flash alert shown.
	 * 
	 * @param  string  $message
	 * @param  array  $options
	 * @return  void
	 */
	public function saveWithMessage($message, array $options = []) {
		$options = array_add($options, 'flash_message', $message);
		$this->save($options);
	}

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

		// Set the correct action
		if ($this->wasRecentlyCreated) {
			$action = 'created';
		} else {
			$action = 'updated';
		}

		// Check whether options contains an overwrite flash message
		if (array_has($options, 'flash_message')) {
			$this->flashMessage($this->classNameFormatted() . ' #' . $this->id . ' ' . $options['flash_message']);
		} else {
			$this->flashMessage($action);
		}
	}

	/**
	 * Overwrite the Eloquent delete method.
	 * 
	 * @return  void
	 */
	public function delete()
	{
		parent::delete();

		$this->flashMessage('deleted');
	}

	/**
	 * Flash the message to the screen using the correct message method.
	 * 
	 * @param  string  $action
	 * @return void
	 */
	public function flashMessage($action)
	{
		// Set the correct method name
		$method = 'message' . ucwords($action);

		// Check whether the method exists
		if (method_exists($this, $method)) {
			$message = $this->$method();
		} else {
			$message = $action;
		}

		// Providing we have a valid message, flash an alert for it
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
		return 'New ' . $this->classNameFormatted() . ' created';
	}

	/**
	 * Get the model updated message.
	 * 
	 * @return  string
	 */
	public function messageUpdated()
	{
		return $this->classNameFormatted() . ' #' . $this->id . ' was updated';
	}

	/**
	 * Get the model deleted message.
	 * 
	 * @return  string
	 */
	public function messageDeleted()
	{
		return $this->classNameFormatted() . ' #' . $this->id . ' was deleted';
	}

	/**
	 * Get the model restored message.
	 * 
	 * @return  string
	 */
	public function messageRestored()
	{
		return $this->classNameFormatted() . ' #' . $this->id . ' was restored';
	}

	/**
	 * Get the class name.
	 * 
	 * @return string
	 */
	public function className()
	{
		return class_basename($this);
	}

	/**
	 * Get the class name in lower case.
	 * 
	 * @return  string
	 */
	public function classNameLower()
	{
		return strtolower($this->className());
	}

	/**
	 * Get the singular class name.
	 * 
	 * @return string
	 */
	public function classNameSingular()
	{
		return str_singular($this->classNameLower());
	}

	/**
	 * Get the singular class name.
	 * 
	 * @return string
	 */
	public function classNamePlural()
	{
		return str_plural($this->classNameLower());
	}

	/**
	 * Get the formatted class name eg. BankAccount becomes Bank Account
	 * 
	 * @return [type] [description]
	 */
	public function classNameFormatted()
	{
		$slug = snake_case($this->className());
		$clean = str_replace('_', ' ', $slug);
		return ucfirst($clean);
	}
}