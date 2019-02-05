<?php

namespace Petrelli\LiveStatics\Helpers\Faker;

use Petrelli\LiveStatics\Helpers\Faker\Generator as MiddlewareGenerator;


class Factory extends \Faker\Factory
{

    public static function create($locale = self::DEFAULT_LOCALE)
    {

        $generator = new MiddlewareGenerator();

        foreach (static::$defaultProviders as $provider) {
            $providerClassName = self::getProviderClassname($provider, $locale);
            $generator->addProvider(new $providerClassName($generator));
        }

        return $generator;

    }


}
