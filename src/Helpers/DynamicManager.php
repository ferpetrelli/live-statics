<?php

namespace Petrelli\LiveStatics\Helpers;

use Petrelli\LiveStatics\Helpers\Faker\DynamicField;
use Petrelli\LiveStatics\Helpers\Parameters;


/**
 *
 * This manager will be exported as a Facade to be accessed by our
 * Service providers, Views, and for the user to add their own fields
 * By hand if needed.
 *
 */

class DynamicManager
{

    // Array to save all of our registres dynamic fields
    protected $dynamicFields = [];


    /**
     *
     * Add a field to our collection.
     * It also checks we won't add them twice, assuring we can use the same parameter
     * for multiple fields
     *
     * @param string $type field type. Basically faker method name
     * @param string $name Field name
     */
    public function addField($type, $name)
    {

        // Do not register the same field twice
        $exists = collect($this->dynamicFields)->first(function ($item, $key) use ($type, $name) {
            return $item->parameterName() == Parameters::resolveName($type, $name);
        });

        if ($exists) { return; }

        $this->dynamicFields[] = new DynamicField($type, $name);

    }


    public function parameters()
    {

        return collect($this->dynamicFields);

    }


    public function parametersByType()
    {

        return $this->parameters()->groupBy(function($item) {
            return $item->type();
        });

    }


    public function hasParameter($type, $element)
    {

        return Parameters::has($type, $element);

    }


    public function getParameter($type, $element)
    {

        return Parameters::get($type, $element);

    }


}

