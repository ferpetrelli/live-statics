<?php

namespace Petrelli\LiveStatics\Mocks\Twill;

use Petrelli\LiveStatics\Interfaces\Twill\DoubleImageBlockInterface;
use Petrelli\LiveStatics\Mocks\Twill\BaseBlockMock;


class DoubleImageBlockMock extends BaseBlockMock implements DoubleImageBlockInterface
{

    use HasImages;


    public static $baseInterface = DoubleImageBlockInterface::class;

    public $type = 'double_image';

    protected $random;


    public function __construct($mock)
    {

        $this->mockedObject = $mock;

        // Save a random number per instance
        // This will allow us to call to Image on this block multiple times and
        // always get the same image
        $this->random   = rand(1,1000);
        $mock->title    = app('faker')->sentence();
        $mock->alt_text = app('faker')->sentence();
        $mock->caption  = app('faker')->dynamic('Block: Image/Video Caption')->sentence();

    }


    public static function define(&$mock)
    {

        $mock->caption  = app('faker')->dynamic('Block: Image/Video Caption')->sentence();
        $mock->caption2 = app('faker')->dynamic('Block: Image/Video Caption')->sentence();

        return $mock;

    }

    public function imageObject($role, $crop = 'default')
    {

        return $this;

    }

}
