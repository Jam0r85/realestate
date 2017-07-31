<?php

namespace App\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class EloquentBaseRepository
{
    /**
     * Get the class name for the repository.
     *
     * @return null
     */
    public function getClassPath()
    {
        return null;
    }

    /**
     * Get the class name of the parent.
     *
     * @return string
     */
    public function getClassName()
    {
        return class_basename($this->getClassPath());
    }

    /**
     * Get a new instance of the class.
     *
     * @return mixed
     */
    public function getInstance($withTrashed = true)
    {
        $className = $this->getClassPath();
        $instance = new $className();

        return $instance;
    }

    /**
     * Get the table columns from an eloquent instance.
     *
     * @param   $instance [description]
     * @return [type]           [description]
     */
    public function getTableColumns()
    {
        return $this->getInstance()->getConnection()->getSchemaBuilder()->getColumnListing($this->getInstance()->getTable());
    }

    /**
     * Check whether the table has a column with the given name,
     *
     * @param  string  $column
     * @return boolean
     */
    public function hasTableColumn($column)
    {
        return (boolean) in_array($column, $this->getTableColumns());
    }

    /**
     * Check whether the eloquent model has a user_id field
     *
     * @return boolean
     */
    public function hasUserIdColumn()
    {
        return (boolean) $this->hasTableColumn('user_id');
    }

    /**
     * Set the user_id column.
     *
     * @param array $data
     * @param eloquent $model
     */
    public function setUserIdColumn($data, $model)
    {
        if (!$this->hasUserIdColumn()) {
            return $model;
        }

        if (!isset($data['user_id'])) {
            $model->user_id = Auth::id();
        } else {
            $model->user_id = $data['user_id'];
        }

        return $model;
    }

    /**
     * Check whether the eloquent model has a branch_id column.
     *
     * @return boolean
     */
    public function hasBranchIdColumn()
    {
        return (boolean) $this->hasTableColumn('branch_id');
    }

    /**
     * Set the branch_id column.
     *
     * @param [type] $data  [description]
     * @param [type] $model [description]
     */
    public function setBranchIdColumn($data, $model)
    {
        if (!$this->hasBranchIdColumn()) {
            return $model;
        }

        if (!isset($data['branch_id'])) {
            $branch = Auth::user()->branch;
            $model->branch_id = $branch ? $branch->id : null;
        } else {
            $model->branch_id = $data['branch_id'];
        }

        return $model;
    }

    /**
     * Check whether the instance has the 'SoftDeletes' trait implemented.
     *
     * @param  \Illuminate\Database\Builder  $instance
     * @return \Illuminate\Database\Builder
     */
    public function hasSoftDeletes($instance)
    {
        if (in_array('Illuminate\Database\Eloquent\SoftDeletes', $this->getInstanceTraits($instance))) {
            $instance = $instance->withTrashed();
        }

        return $instance;
    }

    /**
     * Get the traits used by the instance.
     *
     * @param  \Illuminate\Database\Builder $instance
     * @return array
     */
    public function getInstanceTraits($instance)
    {
        return class_uses($instance);
    }

    /**
     * Get all records in the repository.
     *
     * @return mixed
     */
    public function getAll($columns = null)
    {
        $instance = $this->getInstance();

        if ($columns) {
            $instance = $instance->select($columns);
        }

        return $instance->get();
    }

    /**
     * Get all records in the repo and paginate them.
     *
     * @return mixed
     */
    public function getAllPaged($with = [])
    {
        return $this->getInstance()->with($with)->latest()->paginate();
    }

    /**
     * Get all archive records in the repo and paginate them.
     *
     * @return mixed
     */
    public function getArchivedPaged($with = [])
    {
        return $this->getInstance()->with($with)->onlyTrashed()->latest()->paginate();
    }

    /**
     * Find a record in the repository.
     *
     * @return mixed
     */
    public function find($model = null, $with = [])
    {
        if (is_null($model)) {
            return null;
        }
        
        if (!is_numeric($model)) {
            return $model;
        }

        $instance = $this->getInstance();
        $instance = $this->hasSoftDeletes($instance);

        if (count($with)) {
            $instance = $instance->with($with);
        }

        return $instance->findOrFail($model);
    }

    /**
     * Find a record in the repository by it's slug.
     *
     * @param  string $slug
     * @return mixed
     */
    public function findBySlug($slug)
    {
        return $this->getInstance()->where('slug', $slug)->first();
    }

    /**
     * Search through the repository.
     *
     * @param  string $search_term
     * @return mixed
     */
    public function search($search_term)
    {
        request()->session()->flash('search_term', $search_term);        
        return $this->getInstance()->search($search_term)->get();
    }

    /**
     * @param  array  $data
     * @return mixed
     */
    public function create($data = [])
    {
        // Create a new instance
        $model = $this->getInstance();

        // Fill the instance with the data provided
        $model->fill($data);

        // Set the user_id and branch_id columns
        $model = $this->setUserIdColumn($data, $model);
        $model = $this->setBranchIdColumn($data, $model);

        // Save the instance
        $model->save();

        // Flash the message
        $this->flashMessage('Created');

        // Clear the cache
        $this->clearCache();

        return $model;
    }

    /**
     * @param   array   $data
     * @param   $model
     * @return  mixed
     */
    public function update($data = [], $id)
    {
        $model = $this->find($id);

        $model->fill($data);
        $model->save();

        $this->flashMessage('Updated');

        $this->clearCache();

        return $model;
    }

    /**
     * Archive a record.
     *
     * @param  mixed $model
     * @return mixed
     */
    public function archive($id, $data = [])
    {
        // Find the model.
        $model = $this->find($id);

        // Do we have data to update the model with?
        if (count($data)) {
            $this->update($data, $model);
        }

        // If the model is already archived, return
        if ($model->trashed()) {
            return;
        }

        // Archive the model
        $model->delete();

        // Show the message
        $this->flashMessage('Archived');

        // Clear the cache
        $this->clearCache();

        return $model;
    }

    /**
     * Restore a record.
     *
     * @param  mixed $model
     * @return mixed
     */
    public function restore($model)
    {
        $model = $this->find($model);

        if (!$model->trashed()) {
            return;
        }

        $model->restore();

        $this->flashMessage('Restored');

        $this->clearCache();

        return $model;
    }

    /**
     * Delete a record.
     *
     * @param  mixed $model
     * @return mixed
     */
    public function delete($model)
    {
        $model = $this->find($model);

        if (!$model->trashed()) {
            return;
        }

        $model->forceDelete();

        $this->flashMessage('Deleted');

        $this->clearCache();

        return $model;
    }

    /**
     * Clear the cache.
     * 
     * @return void
     */
    public function clearCache()
    {
        $tags = [
            str_slug($this->getClassName()),
            str_plural(str_slug($this->getClassName()))
        ];

        return cache()->tags($tags)->flush();
    }

    /**
     * Show a success flash message.
     *
     * @param  string $message
     * @return
     */
    public function successMessage($message)
    {
        return $this->customFlashMessage($message, 'success');
    }

    /**
     * Show a custom flash message.
     *
     * @param  string $message
     * @param  string $level
     * @return flash message
     */
    public function customFlashMessage($message, $level = 'info')
    {
        return $this->flashMessage('custom', $message, $level);
    }

    /**
     * Show the flash message.
     *
     * @param  string $activity
     * @return mixed
     */
    public function flashMessage($activity = null, $message = null, $level = 'success')
    {
        if ($activity == 'custom') {
            $message = $message;
        } else {
            $message = 'The ' . $this->getClassName() . ' was ' . $activity;
        }

        flash($message)->$level();
    }
}
