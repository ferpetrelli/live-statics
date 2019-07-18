<?php

namespace Petrelli\LiveStatics\Mocks\Twill;

use Petrelli\LiveStatics\Interfaces\Twill\CarouselBlockInterface;
use Petrelli\LiveStatics\Interfaces\Twill\ImageBlockInterface;
use Petrelli\LiveStatics\Mocks\Twill\BaseBlockMock;


class CarouselBlockMock extends BaseBlockMock implements CarouselBlockInterface
{


    public static $baseInterface = CarouselBlockInterface::class;

    public $type = 'carousel';


    public static function define(&$mock)
    {

        /**
         * Emulates the repeater that contains image blocks
         */
        $mock->childs = collect([
            app(ImageBlockInterface::class),
            app(ImageBlockInterface::class),
            app(ImageBlockInterface::class),
            app(ImageBlockInterface::class),
            app(ImageBlockInterface::class),
        ]);

        return $mock;

    }


}
