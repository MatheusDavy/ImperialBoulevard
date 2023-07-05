<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Lang implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function get($model, string $key, $value, array $attributes)
    {
        $lang = _session('language');
        if (!$lang) {
            $lang = 'pt';
        }

        $decoded = json_decode($value, true);

        if ($lang == 1) $lang = 'pt';
        if ($lang == 2) $lang = 'en';
        if ($lang == 3) $lang = 'es';

        if (isset($decoded[$lang])) {
            return $decoded[$lang];
        }

        if (!$decoded) {
            return $value;
        }

        return $decoded;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return mixed
     */
    public function set($model, string $key, $value, array $attributes)
    {
        return json_decode($value, true);
    }
}
