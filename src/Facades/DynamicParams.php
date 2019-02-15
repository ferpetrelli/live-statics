<?php

namespace Petrelli\LiveStatics\Facades;

use Illuminate\Support\Facades\Facade;


class DynamicParams extends Facade
{


    protected static function getFacadeAccessor()
    {

        return 'live-statics.manager';

    }


}
