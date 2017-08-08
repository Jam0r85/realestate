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
     * Update the bank account for the property.
     *
     * @param  integer $account_id
     * @param  App\Property $id
     * @return mixed
     */
    public function updateBankAccount($account_id, $id)
    {
        $property = $this->find($id);

        $property->update(['bank_account_id' => $account_id]);

        $this->successMessage('The bank account was updated');

        return $property;
    }

    /**
     * Update the bank account for the property.
     *
     * @param  integer $account_id
     * @param  App\Property $id
     * @return mixed
     */
    public function updateStatementSendingMethod($method, $id)
    {
        $property = $this->find($id);

        if ($method == 'post') {
            $property->storeSetting('post_rental_statement', true);
        } elseif ($method == 'email') {
            $property->storeSetting('post_rental_statement');
        }

        $this->successMessage('The statement sending method was updated');

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
