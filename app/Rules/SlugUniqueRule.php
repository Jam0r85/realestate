<?php

namespace App\Rules;

use App\Permission;
use Illuminate\Contracts\Validation\Rule;

class SlugUniqueRule implements Rule
{
    /**
     * The name of the request input to use should the slug field be empty.
     * 
     * @var string
     */
    public $name;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($name = null)
    {
        $this->name = $name;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Should the value be empty, set the value based on the named fields value
        if (! $value) {
            if ($this->name) {
                $value = str_slug(request()->input($this->name));
            }
        }

        // Check whether there is a permission with that slug existing
        if (Permission::where('slug', $value)->exists()) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'A permission with that :attribute value already exists.';
    }
}
