<?php

namespace Legalworks\IsbnTools;

use Illuminate\Contracts\Validation\Rule;
use Nicebooks\Isbn\IsbnTools as NiceIsbnTools;

class IsbnValidator implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return (new NiceIsbnTools)->isValidIsbn($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute is not a valid isbn.';
    }
}
