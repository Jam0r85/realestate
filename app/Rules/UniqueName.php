<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UniqueName implements Rule
{
    public $table;
    public $field;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($table, $field)
    {
        $this->table = $table;
        $this->field = $field;
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
        if (empty($value)) {
            return true;
        }
        
        $query = DB::table($this->table)
            ->whereNull('deleted_at')
            ->where($this->field, 'like', $value)->get();

        if (count($query)) {
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
        return 'That name has already been taken.';
    }
}
