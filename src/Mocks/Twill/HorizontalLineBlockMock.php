<?php

namespace Petrelli\LiveStatics\Mocks\Twill;

use Petrelli\LiveStatics\Interfaces\Twill\HorizontalLineBlockInterface;
use Petrelli\LiveStatics\Mocks\Twill\BaseBlockMock;


class HorizontalLineBlockMock extends BaseBlockMock implements HorizontalLineBlockInterface
{


    public static $baseInterface = HorizontalLineBlockInterface::class;

    public $type = 'horizontal_line';


}
