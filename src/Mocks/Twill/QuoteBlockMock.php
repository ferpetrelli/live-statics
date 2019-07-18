<?php

namespace Petrelli\LiveStatics\Mocks\Twill;

use Petrelli\LiveStatics\Interfaces\Twill\QuoteBlockInterface;
use Petrelli\LiveStatics\Mocks\Twill\BaseBlockMock;


class QuoteBlockMock extends BaseBlockMock implements QuoteBlockInterface
{


    public static $baseInterface = QuoteBlockInterface::class;

    public $type = 'quote';


    public static function define(&$mock)
    {

        $mock->quote = app('faker')->dynamic('Block: Quote')->sentence(20, 50);

        return $mock;

    }


}
