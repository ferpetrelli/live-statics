<?php

namespace Petrelli\LiveStatics\Facades;

use Illuminate\Support\Facades\Facade;


class InterfaceMapperFacade extends Facade
{


    protected static function getFacadeAccessor()
    {

        return 'live-statics.interface-mapper';

    }


}
