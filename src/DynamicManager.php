<?php

namespace Petrelli\LiveStatics;

class DynamicManager
{

    // Array to save all of our used dynamic fields
    protected $dynamicFields = [
        // Structure will be:
        // 'type' => [
        //   [ \StdClass(), \StdClass(), \StdClass(), ... ]
        // ]
        //
        // \StdClass() object will contain:
        //   - name
        //   - parameters
    ];


    public function addField($type, $name)
    {

        if (!in_array($type, config('live-statics.dynamic_fields.supported'))) {
            // Throw new exception if this formatter is not supported
            throw new \InvalidArgumentException(sprintf('Faker Formatter not supported "%s". Please add it to dynamic_fields.supported at your live-statics configuration file', $type));
        }



        $exists = collect($this->dynamicFields)->first(function ($item, $key) use ($type, $name) {
            return $item->paramName == $this->resolveParameterName($type, $name);
        });

        if ($exists) { return; }


        // Move to a class
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

