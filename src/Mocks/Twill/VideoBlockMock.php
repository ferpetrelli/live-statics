<?php

namespace Petrelli\LiveStatics\Mocks\Twill;

use Petrelli\LiveStatics\Interfaces\Twill\VideoBlockInterface;
use Petrelli\LiveStatics\Interfaces\Twill\ImageBlockInterface;
use Petrelli\LiveStatics\Mocks\Twill\BaseBlockMock;


class VideoBlockMock extends BaseBlockMock implements VideoBlockInterface
{


    public static $baseInterface = VideoBlockInterface::class;

    public $type = 'video';


    public static function define(&$mock)
    {

        $mock->url = 'https://www.youtube.com/watch?v=XrDUTpeGW0A';
        $mock->caption = app('faker')->dynamic('Block: Image/Video Caption')->sentence();

        return $mock;

    }


    public function image($role = "main", $crop = "default", $params = [], $has_fallback = false, $cms = false, $media = null)
    {

        return app(ImageBlockInterface::class)->image(...func_get_args());

    }


}
