<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;

class PropertyPresenter extends Presenter
{
	/**
	 * @return string
	 */
	public function fullAddress($postcode = true)
	{
		$name = $this->shortAddress;
		$name .= $this->address2 ? ', ' . $this->address2 : null;
		$name .= $this->address3 ? ', ' . $this->address3 : null;
		$name .= $this->town ? ', ' . $this->town : null;
		$name .= $this->county ? ', ' . $this->county : null;

        if ($postcode == true) {
		  $name .= $this->postcode ? ', ' . $this->postcode : null;
        }

		return $name;
	}

	/**
	 * @return string
	 */
	public function shortAddress()
	{
    	// House name is present, we return that.
    	if ($this->house_name) {
    		// Add the house name.
    		$name = $this->house_name;

    		// Add the house number if we have one.
    		if ($this->house_number) {
    			$name .= ', ' . $this->house_number;
    		}

    		// Add the address line 1 if we have one.
    		if ($this->address1) {
    			if ($this->house_number) {
    				$name .= ' ' . $this->address1;
    			} else {
    				$name .= ', ' . $this->address1;
    			}
    		}

    		return trim($name);
    	}

    	// Otherwise we return the house number and the first line of the address.
    	return trim($this->house_number . ' ' . $this->address1 ?: '');
	}

    /**
     * @return string
     */
    public function withoutPostcode()
    {
        return $this->fullAddress(false);
    }

    /**
     * @return string
     */
    public function letter()
    {
        return str_replace(', ', '<br />', $this->fullAddress);
    }

    /**
     * @return string
     */
    public function ownerNames()
    {
        if (count($this->owners)) {
            foreach ($this->owners as $user) {
                $names[] = $user->present()->fullName;
            }
        }

        if (isset($names) && count($names)) {
            return implode(', ', $names);
        } else {
            return null;
        }
    }

    /**
     * @return string
     */
    public function selectName()
    {
        $value = $this->fullAddress;

        foreach ($this->owners as $user) {
            $users[] = $user->present()->fullName;
        }

        if (isset($users) && count($users)) {
            $value .= ' (' . implode(' & ', $users) . ')';
        }

        return $value;
    }
}