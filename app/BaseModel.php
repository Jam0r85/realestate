<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

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
		return $this->save($options);
	}

	/**
	 * Overwrite the Eloquent save method.
	 * 
	 * @param  array  $options
	 * @return void
	 */
	public function save (array $options = [])
	{
		// Update settings column
		if (method_exists($this, 'setSetting')) {
			$this->setSetting(request()->input());
		}

		// Update data column
		if (method_exists($this, 'setData')) {
			$this->setData(request()->input());
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

		return $this;
	}

	/**
	 * Overwrite the Eloquent delete method.
	 * 
	 * @return  void
	 */
	public function delete()
	{
		parent::delete();

		if ($this->forceDeleting) {
			$this->flashMessage('forceDeleted');
		} else {
			$this->flashMessage('deleted');
		}

		return $this;
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
		return 'New ' . $this->classNameFormatted() . ' #' . $this->id . ' created';
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
	 * Get the model deleted message.
	 * 
	 * @return  string
	 */
	public function messageForceDeleted()
	{
		return $this->classNameFormatted() . ' #' . $this->id . ' was destroyed';
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
	 * Get the view class name.
	 * 
	 * @return  string
	 */
	public function classViewName()
	{
		return kebab_case(str_plural($this->className()));
	}

	/**
	 * Get the plural class name.
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

	/**
	 * Check whether the model uses Soft Deletes.
	 * 
	 * @return  boolean
	 */
	public function checkSoftDeletes()
	{
		if (!in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses($this))) {
			return false;
		}

		return true;
	}
}