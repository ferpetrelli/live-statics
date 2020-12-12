<?php

namespace Petrelli\LiveStatics;

use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;

// Base Traits
use \Petrelli\LiveStatics\Traits\Pagination;


class BaseMock implements Arrayable, UrlRoutable
{

    use Pagination;

    public static $baseClass;
    public static $baseInterface;

    // Used to store the actual mocked object
    public $mockedObject;

    // Set 'slug' as the default attribute to build URL's
    protected $primaryKey = 'id';

    // Appends these attribute/relations when serializing this object
    protected $appends = [];

    // Methods that should return $this
    // This is used mostly to mock the use of scopes
    protected $returnSelfMethods = [];

    public static function create()
    {

        // Create a mocked object
        // Pass the interface as the second argument (for dependency injection to work)

        if (static::$baseClass) {
            $mock = \Mockery::mock(static::$baseClass, static::$baseInterface)->makePartial();
        } else {
            $mock = \Mockery::mock(static::$baseInterface);
        }

        // Define base methods and attributes for the mocked model
        static::define($mock);

        // Return a new container object using an underline mocked instance.
        // We provide a layer on top of the mocked object so we can define there
        // new functions and/or attributes that can be used at execution time.
        // This will solve a problem presented when we want to use an instance of
        // ourselves creating a stack overflow.
        return new static($mock);

    }

    public static function define(&$mock)
    {

        return $mock;

    }

    public function __construct($mock)
    {

        $this->mockedObject = $mock;

    }

    /**
     * ---------------------------------------------------------------------------------
     *
     *  The following functions are php magic method implementations that will
     *  provide us with more flexibility when defining methods and attributes.
     *
     *
     *  If the called method or requested attribute doesn't exists in our mocked object,
     *  we bypass it to the underline mockery object.
     *
     *  We also provide Laravels functionality to define attributes using a function:
     *  function get[NAME]Attribute() will enable the [NAME] attribute.
     *
     * ---------------------------------------------------------------------------------
     */

    /**
     * Dynamically handle calls into the mocked instance if not defined.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     *
     */
    public function __call($method, $parameters)
    {

        if (method_exists($this, $method)) {
            return $this->$method(...$parameters);
        }

        if (in_array($method, $this->returnSelfMethods)) {
            return $this;
        }

        return $this->mockedObject->{$method}(...$parameters);

    }

    /**
     * Dynamically retrieve attributes. Defined here or at the mocked object.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {

        if ($this->hasGetMutator($key)) {
            return $this->mutateAttribute($key);
        } else {
            return $this->$key ?? $this->mockedObject->$key;
        }

    }

    /**
     * Determine if a get mutator exists for an attribute.
     *
     * @param  string  $key
     * @return bool
     */
    public function hasGetMutator($key)
    {

        return method_exists($this, 'get' . Str::studly($key) . 'Attribute');

    }

    /**
     * Get the value of an attribute using its mutator.
     *
     * @param  string  $key
     * @return mixed
     */
    protected function mutateAttribute($key)
    {

        return $this->{'get' . Str::studly($key) . 'Attribute'}();

    }

    /**
     *
     *  When transforming to an array just use the mocked Object
     *  and then add all new local mutated attributes
     *  (get[NAME]Attribute() like function)
     *
     */
    public function toArray()
    {
        $object = $this->mockedObject;

        // Get all mutated attributes
        $attributes = static::listMutatedAttributes(get_class($this));

        // Add them to the base object
        foreach ($attributes as $name) {
            if (in_array($name, $this->appends)) {
                $object->$name = $this->$name;
            }
        }

        return $object;
    }

    /**
     *
     * Extract all mutated attributes names
     *
     */
    public static function listMutatedAttributes($class)
    {
        $mutatedAttributes = [];

        if (preg_match_all('/(?<=^|;)get([^;]+?)Attribute(;|$)/', implode(';', get_class_methods($class)), $matches)) {
            foreach ($matches[1] as $match) {
                $mutatedAttributes[] = lcfirst($match);
            }
        }

        return $mutatedAttributes;
    }

    /**
     * ---------------------------------------------------------------------------------
     *
     * UrlRoutable interface implementation
     * This is used to be passed into a route() and generate correct URL's
     *
     * ---------------------------------------------------------------------------------
     */

    public function getRouteKey()
    {

        $attributeName = $this->getRouteKeyName();

        return $this->$attributeName;

    }

    public function getRouteKeyName()
    {

        return $this->getKeyName();

    }

    public function getKeyName()
    {

        return $this->primaryKey;

    }

    public function resolveRouteBinding($value, $field = null)
    {

        return $this;

    }

    public function resolveChildRouteBinding($childType, $value, $field)
    {

        return $this;
    }

}
