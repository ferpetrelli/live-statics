<?php

use Illuminate\Support\Str;

namespace Petrelli\LiveStatics\Helpers;

/**
 *
 * Helpers to resolve parameter names and their data
 *
 */

class Parameters
{


    public static function resolveName($type, $element)
    {

        $prefix = config('live-statics.dynamic_fields.prefix');

        return \Str::slug(join('-',[$prefix, $type, $element]));

    }


    public static function has($type, $element)
    {

        return request()->has(static::resolveName($type, $element));

    }


    public static function get($type, $element)
    {

        return request()->get(static::resolveName($type, $element), null);

    }


}
