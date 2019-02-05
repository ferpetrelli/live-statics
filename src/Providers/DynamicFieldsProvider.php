<?php

namespace Petrelli\LiveStatics\Providers;

use Petrelli\LiveStatics\DynamicManager;
use Faker\Provider\Base as BaseProvider;
use Illuminate\Support\Str;


class DynamicFieldsProvider extends BaseProvider
{

    protected $manager;


    public function __construct(...$parameters)
    {

        // Use a singleton instance so we can access it later to format these parameters
        $this->manager = app('live-statics.manager');

        parent::__construct(...$parameters);

    }


    public function dynamic($method, $name, ...$parameters)
    {

        // Register the dynamic field
        $this->manager->addField($method, $name);

        // Get the parameter
        $paramName = $this->manager->resolveParameterName($method, $name);

        // Call faker generator with corrected value
        if($value = request($paramName)) {
            return $this->generator->$method($value);
        } else {
            return $this->generator->$method(...$parameters);
        }

    }


}
