<?php

namespace Legalworks\IsbnTools;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Nicebooks\Isbn\Isbn as IsbnClass;

class IsbnCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  string  $value
     * @param  array  $attributes
     * @return array
     */
    public function get($model, $key, $value, $attributes)
    {
        return IsbnClass::of($value)->format();
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  string  $value
     * @param  array  $attributes
     * @return string
     */
    public function set($model, $key, $value, $attributes)
    {
        return IsbnClass::of($value)->format();
    }
}
