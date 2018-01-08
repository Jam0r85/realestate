<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class BaseModel extends Model
{
	/**
	 * Set the page limit for pagination.
	 * 
	 * @var integer
	 */
	protected $perPage = 30;

	/**
	 * The UUID column required for public access to a record.
	 */
	public $publicKeyColumn = 'key';

	/**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
		parent::boot();
		
		// When creating a new model
		static::creating(function ($model) {

			$tableColumns = $model->getTableColumns();

			// Set the owner of this record.
			if (in_array('user_id', $tableColumns)) {
				$model->user_id = auth()->user()->id;
			}

			// Set the public key for this record.
			if (in_array($model->publicKeyColumn, $tableColumns)) {
				$column = $model->publicKeyColumn;
				$model->$column = Uuid::uuid1()->toString();
			}
		});
	}

	/**
	 * Get the table name for this model.
	 * 
	 * @return string
	 */
	public function getTableName()
	{
		return $this->getTable();
	}

	/**
	 * Get the table columns for this model.
	 * 
	 * @return array
	 */
	public function getTableColumns()
	{
		return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTableName());
	}
	
	/**
	 * Save an eloquent instance along with a custom message.
	 * 
	 * @param  string  $message
	 * @param  array  $options
	 * @return \Illuminate\Database\Eloquent\Model
	 */
	public function saveWithMessage($message, array $options = []) {
		$options = array_add($options, 'flash_message', $message);
		return $this->save($options);
	}

    /**
     * Save the model to the database.
     *
     * @param  array  $options
     * @return bool
     */
	public function save (array $options = [])
	{
		// Check if we have the SettingsTrait, attach the data to that column.
		if (method_exists($this, 'setSetting')) {
			$this->setSetting(request()->input());
		}

		// Check if we have the DataTrait, attach the data to that column.
		if (method_exists($this, 'setData')) {
			$this->setData(request()->input());
		}

		// Save the model
		parent::save($options);

		// Decide whether we updated or created this record
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
	 * @param  string  $class
	 * @return void
	 */
	public function flashMessage($action, $class = 'success')
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
			flash_message($message, $class);
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