<?php

namespace Petrelli\LiveStatics\Helpers;

/**
 *
 * Helpers to resolve parameter names and to
 * retrieve data
 *
 */

class Parameters
{

    public static function resolveName($type, $element)
    {

        $prefix = config('live-statics.dynamic_fields.prefix');

        return str_slug(join('-',[$prefix, $type, $element]));

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
