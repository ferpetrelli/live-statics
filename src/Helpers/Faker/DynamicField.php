<?php

namespace Petrelli\LiveStatics\Helpers\Faker;

use Petrelli\LiveStatics\Helpers\Parameters;


/**
 *
 * Simple class to store a dynamic parameter definition
 *
 * Used for future enhancements.
 *
 */

class DynamicField
{

    protected $name;
    protected $type;


    public function __construct($type, $name)
    {

        $this->name = $name;
        $this->type = $type;

    }


    public function name()
    {

        return $this->name;

    }


    public function type()
    {

        return $this->type;

    }


    public function parameterName()
    {

        return Parameters::resolveName($this->type, $this->name);

    }


    public function value()
    {

        return request()->get($this->name(), null);

    }


    public function edgeValues()
    {

        $defaults = config('live-statics.dynamic_fields.defaults');

        if (isset($defaults[$this->type])) {
            return $defaults[$this->type];
        } else {
            throw new \InvalidArgumentException(sprintf('Default values are not defined for Faker Formatter "%s". Please add it to dynamic_fields.defaults at your live-statics configuration file', $this->type));
        }

    }


}
