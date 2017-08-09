<?php

namespace App\Services;

use App\Property;
use App\User;

class PropertyService
{
	/**
	 * Update the property owners.
	 * 
	 * @param array $data
	 * @param integer $id
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

    /**
     * Update the statement settings.
     * 
     * @param array $data
     * @param integer $id
     * @return \App\Property
     */
    public function updateStatementSettings(array $data, $id)
    {
        $property = Property::findOrFail($id);

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
}