<?php

namespace Petrelli\LiveStatics\Mocks\Twill;

use \Petrelli\LiveStatics\Interfaces\Twill\SubtitleBlockInterface;
use Petrelli\LiveStatics\Mocks\Twill\BaseBlockMock;


class SubtitleBlockMock extends BaseBlockMock implements SubtitleBlockInterface
{


    public static $baseInterface = SubtitleBlockInterface::class;

    public $type = 'subtitle';


    public static function define(&$mock)
    {

        $mock->title = app('faker')->dynamic('Block: Subtitle')->sentence(rand(3, 6));

        return $mock;

    }


}
