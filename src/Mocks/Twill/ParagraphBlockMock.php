<?php

namespace Petrelli\LiveStatics\Mocks\Twill;

use Petrelli\LiveStatics\Interfaces\Twill\ParagraphBlockInterface;
use Petrelli\LiveStatics\Mocks\Twill\BaseBlockMock;


class ParagraphBlockMock extends BaseBlockMock implements ParagraphBlockInterface
{


    public static $baseInterface = ParagraphBlockInterface::class;

    public $type = 'paragraph';


    public static function define(&$mock)
    {

        $mock->id = rand(1,1000);
        $mock->paragraph = '<p> ' . app('faker')->dynamic('Block: Paragraph')->sentence(rand(10, 100)) . '</p>';

        return $mock;

    }


}
