<?php

namespace Petrelli\LiveStatics\Helpers\Faker;


class Generator extends \Faker\Generator
{

    // Temporary variable to save the Dynamic name
    protected $name;
    protected $dynamicFlag = false;

    const ALLOWED_METHODS = [
        'sentence', 'text'
    ];


    public function dynamic($name)
    {

        $this->name = $name;
        $this->dynamicFlag = true;

        return $this;

    }


    public function __call($method, $attributes)
    {

        if ($this->dynamicFlag) {

            // Check Faker method is supported
            $this->checkValidMethod($method);

            // Register the dynamic field
            \DynamicManager::addField($method, $this->name);

            // Disable dynamic flag for next call
            $this->dynamicFlag = false;

            // Check we have available parameters
            if (\DynamicManager::hasParameter($method, $this->name)) {
                $params = \DynamicManager::getParameter($method, $this->name);

                return $this->format($method, is_array($params) ? $params : [$params]);
            }

        }

        return $this->format($method, $attributes);


    }


    protected function checkValidMethod($method)
    {

        if (!in_array($method, static::ALLOWED_METHODS)) {
            // Throw new exception if this formatter is not supported
            throw new \InvalidArgumentException(sprintf('"%s" is not supported as a Faker dynamic method. Please change it to any of the following: %s', $method, join(', ', static::ALLOWED_METHODS)));
        }

    }


}
