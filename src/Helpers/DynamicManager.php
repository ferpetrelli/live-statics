<?php

namespace Petrelli\LiveStatics\Helpers;

class DynamicManager
{

    // Array to save all of our registres dynamic fields
    protected $dynamicFields = [];


    public function addField($type, $name)
    {

        // Do not register the same field twice
        $exists = collect($this->dynamicFields)->first(function ($item, $key) use ($type, $name) {
            return $item->paramName == $this->resolveParameterName($type, $name);
        });

        if ($exists) { return; }


        // TODO: Move to a class
        $field = new \StdClass();
        $field->name = $name;
        $field->type = $type;
        $field->defaultValues = $this->resolveDefaults($type);
        $field->paramName = $this->resolveParameterName($type, $name);
        $field->value = request($field->paramName);
        // ------

        $this->dynamicFields[] = $field;

    }


    public function parameters()
    {

        return collect($this->dynamicFields);

    }


    public function parametersByType()
    {

        return $this->parameters()->groupBy('type');

    }


    public function hasParameter($type, $element)
    {

        return request()->has($this->resolveParameterName($type, $element));

    }


    public function getParameter($type, $element)
    {

        return request()->get($this->resolveParameterName($type, $element), null);

    }


    public function resolveParameterName($type, $element)
    {

        $prefix = config('live-statics.dynamic_fields.prefix');

        return str_slug(join('-',[$prefix, $type, $element]));

    }


    public function resolveDefaults($type)
    {

        $defaults = config('live-statics.dynamic_fields.defaults');

        if (isset($defaults[$type])) {
            return $defaults[$type];
        } else {
            throw new \InvalidArgumentException(sprintf('Default values are not defined for Faker Formatter "%s". Please add it to dynamic_fields.defaults at your live-statics configuration file', $type));
        }

    }


}

