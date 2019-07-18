<?php

namespace Petrelli\LiveStatics\Mocks\Twill;

use Petrelli\LiveStatics\BaseMock;


abstract class BaseBlockMock extends BaseMock
{


    // Store the type of block it will be rendered.
    // This option is used by Twill to render the correct views as well
    public $type;


    public function setType($type)
    {

        $this->type = $type;

        return $this;

    }


    /**
     *
     * This function is defined by Twill to retrieve the value of the block field
     * Here it just returns the mocked value from our underline object
     * defined on the static function 'define'
     *
     */
    public function input($name)
    {

        return $this->$name;

    }


    public function translatedInput($name)
    {

        return $this->$name;

    }


    public function browserIds($name)
    {

        return $this->$name;

    }


}
