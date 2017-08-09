<?php

namespace App\Repositories;

use App\Property;
use App\User;

class EloquentPropertiesRepository extends EloquentBaseRepository
{
    /**
     * Get the class name.
     *
     * @return string
     */
    public function getClassPath()
    {
        return 'App\Property';
    }

    /**
     * Create a new property.
     *
     * @param  array  $data
     * @return
     */
    public function createProperty(array $data)
    {
        $property = $this->create($data);

        if (isset($data['owner_id'])) {
            $property->owners()->attach($data['owner_id']);
        }

        return $property;
    }

    /**
     * Update the statement settings for the given property.
     *
     * @param array $data
     * @param integer $id
     * @return \App\Property $property
     */

    /**
     * Update the owners of a property.
     * 
     * @param array $data data given to the method
     * @param integer $id the ID of the property
     * @return \App\Property
     */
    
}
