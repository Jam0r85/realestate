<?php

namespace App\Repositories;

use App\Property;

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
}
