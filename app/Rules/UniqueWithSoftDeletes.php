<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use DB;

class UniqueWithSoftDeletes implements Rule
{
    protected $table;
    protected $field;

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
        
        $query = DB::table($this->table)->whereNull('deleted_at')->where($this->field, $value)->get();

        if ($query === null) {
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
        return 'The ' . $this->field . ' has already been taken.';
    }
}
