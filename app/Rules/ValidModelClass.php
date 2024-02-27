<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidModelClass implements Rule
{
    public function passes($attribute, $value)
    {
        $value = '\App\Models\\' .$value;
        return class_exists($value) && is_subclass_of($value, 'Illuminate\Database\Eloquent\Model');
    }

    public function message()
    {
        return 'The :attribute must be a valid model class.';
    }
}
