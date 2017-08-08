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
    public function updateStatementSettings(array $data, $id)
    {
        $property = $this->find($id);

        if (isset($data['sending_method'])) {
            if ($data['sending_method'] == 'post') {
                $property->storeSetting('post_rental_statement', true);
            } elseif ($data['sending_method'] == 'email') {
                $property->storeSetting('post_rental_statement');
            }
        }

        if (isset($data['bank_account_id'])) {
            $property->update(['bank_account_id' => $data['bank_account_id']]);
        } else {
            $property->update(['bank_account_id' => null]);
        }

        $this->successMessage('The statement settings were updated.');

        return $property;
    }

    /**
     * Update the owners of a property.
     * 
     * @param array $data data given to the method
     * @param integer $id the ID of the property
     * @return \App\Property
     */
    public function updateOwners(array $data, $id)
    {
        $property = Property::findOrFail($id);

        // Remove the owners.
        if (isset($data['remove'])) {
            $property->owners()->detach($data['remove']);
            // Should the owner's home be set to the property, we reset it too.
            User::whereIn('id', $data['remove'])->where('property_id', $id)->update(['property_id' => null]);
        }

        // Set as the home address.
        if (isset($data['home_address'])) {
            // Should we want to remove owners, compare them so that we only update the owners not being removed.
            if (isset($data['remove'])) {
                $data['home_address'] = array_diff($data['home_address'], $data['remove']);
            }
            // Update the owner's home addresses'
            User::whereIn('id', $property->owners()->pluck('id')->toArray())->where('property_id', $id)->update(['property_id' => null]);
            User::whereIn('id', $data['home_address'])->update(['property_id' => $id]);
        } else {
            // No home address' were provided, remove them all.
            User::whereIn('id', $property->owners()->pluck('id')->toArray())->where('property_id', $id)->update(['property_id' => null]);
        }

        // Attach new owners to the property.
        if (isset($data['new_owners'])) {
            $property->owners()->attach($data['new_owners']);
        }

        return $property;
    }
}
