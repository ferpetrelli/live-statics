<?php

namespace Petrelli\LiveStatics\Mocks\Twill;

use Petrelli\LiveStatics\Interfaces\Twill\TitleBlockInterface;
use Petrelli\LiveStatics\Mocks\Twill\BaseBlockMock;


class TitleBlockMock extends BaseBlockMock implements TitleBlockInterface
{


    public static $baseInterface = TitleBlockInterface::class;

    public $type = 'title';


    public static function define(&$mock)
    {

        $mock->title = app('faker')->dynamic('Block: Title')->sentence(rand(3, 6));

        return $mock;

    }


}
