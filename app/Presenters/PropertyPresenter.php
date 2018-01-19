<?php

namespace App\Presenters;

class PropertyPresenter extends BasePresenter
{
	/**
     * The full address of this property separated by commas. Eg
     * 123 Smith Street, Example Road, New Town, Middle Earth, B12 3GH
     * 
	 * @return string
	 */
	public function fullAddress()
	{
		$name = $this->shortAddress;

		$name .= $this->address2 ? ', ' . $this->address2 : null;
		$name .= $this->address3 ? ', ' . $this->address3 : null;
		$name .= $this->town ? ', ' . $this->town : null;
		$name .= $this->county ? ', ' . $this->county : null;
		$name .= $this->postcode ? ', ' . $this->postcode : null;

		return $name;
	}

    /**
     * Get the inline property address.
     * 
     * @return string
     */
    public function inline()
    {
        return $this->fullAddress;
    }

	/**
     * The short address or name for this property. Eg
     * 123 Smith Street or Basic House
     * 
	 * @return string
	 */
	public function shortAddress()
	{
        $name = '';

    	if ($this->house_name) {
            $name .= $this->house_name;
    	}

        if ($this->house_number && $this->address1) {
            if ($this->house_name) {
                $name .= ', ';
            }
            $name .= $this->house_number . ' ' . $this->address1;
        }

        if (! $this->house_number && $this->address1) {
            $name .= ', ', $this->address1;
        }

        return trim($name);
	}

    /**
     * @return string
     */
    public function slug()
    {
        $name = [
            $this->address1,
            $this->address2,
            $this->address3
        ];

        $clean = array_filter($name);

        return str_slug(implode('-', $clean));
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
            return implode(' & ', $names);
        }
    }

    /**
     * @return string
     */
    public function ownerBadges()
    {
        if (count($this->owners)) {
            foreach ($this->owners as $user) {
                $names[] = $this->badge($user->present()->fullName);
            }
        }

        if (isset($names) && count($names)) {
            return implode(' ', $names);
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