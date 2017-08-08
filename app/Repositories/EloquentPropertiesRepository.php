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

    public function updateOwners(array $data, $id)
    {
        $property = Property::findOrFail($id);

        if (isset($data['remove'])) {
            // Remove the owners from the property.
            $property->owners()->detach($data['remove']);

            // Reset the home address for each user.
            User::whereIn('id', $data['remove'])->where('property_id', $id)->update(['property_id' => NULL]);
        }

        if (isset($data['new_owners'])) {
            $property->owners()->attach($data['new_owners']);
        }

        return $property;
    }
}
