<?php

namespace Petrelli\LiveStatics\Mocks\Twill;

use Petrelli\LiveStatics\Interfaces\Twill\IntroBlockInterface;
use Petrelli\LiveStatics\Mocks\Twill\BaseBlockMock;


class IntroBlockMock extends BaseBlockMock implements IntroBlockInterface
{


    public static $baseInterface = IntroBlockInterface::class;

    public $type = 'intro';


    public static function define(&$mock)
    {

        $mock->intro = app('faker')->dynamic('Block: Intro')->sentence(20, 50);

        return $mock;

    }


}
