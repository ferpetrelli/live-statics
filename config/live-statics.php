<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Subdomain acting as a switch
    |--------------------------------------------------------------------------
    |
    | Whenever this subdomain, or any versioned variations are present
    | live statics will be activated.
    |
    */

    'subdomain' => 'static',



    /*
    |--------------------------------------------------------------------------
    | Path configurations
    |--------------------------------------------------------------------------
    |
    | These variables will control your directory structure.
    | Default values are usually ok for most projects.
    |
    | Given that these values are used to bind elements and generate new mocks,
    | if modified you will have to update your namespaces.
    |
    | Laravel models don't use namespaces by default.
    |
    */

    'path_interfaces' => 'Interfaces',
    'path_models'     => '',
    'path_mocks'      => 'Mocks',



    /*
    |--------------------------------------------------------------------------
    | Mocked Classes
    |--------------------------------------------------------------------------
    |
    | To mock specific classes you will need to add the interface name,
    | plus a full path to the desired mocked element, and a real class
    |
    | Format of each item is:
    |
    |     INTERFACE => [ MOCKED_CLASS, REAL_CLASS ]
    |
    |
    | Example:
    |
    | 'mocked_classes' => [
    |
    |   \App\Interfaces\ThemeInterface::class => [
    |       \App\Mocks\Models\Theme::class, \App\Models\Theme::class
    |   ],
    |   ...
    |
    | ]
    |
    |
    */

    'mocked_classes' => [
    ],



    /*
    |--------------------------------------------------------------------------
    | Mocked Models
    |--------------------------------------------------------------------------
    |
    | Quick shortcut to bind models.
    |
    | It will use all `path_*` options to search for the real class, the mock model
    | and it's interface.
    |
    | 'mocked_models' => [
    |
    |   'Theme',
    |   'Book',
    |
    |   ...
    |
    | ]
    |
    */

    'mocked_models' => [
    ],



    /*
    |--------------------------------------------------------------------------
    | Base Namespace
    |--------------------------------------------------------------------------
    |
    | Added to support complex namespacing. You most likely won't have to
    | modify this value
    |
    */

    'base_namespace'  => 'App',



    /*
    |--------------------------------------------------------------------------
    | Faker extra providers
    |--------------------------------------------------------------------------
    |
    | To generate better fake content for your application, you can specify here
    | faker provider classes, and they will be added automatically when creating
    | our singleton faker instance.
    |
    | Below as a working example, we created a provider to generate images
    | based on Picsum instead of Lorempixel default ones.
    |
    */

    'faker_providers' => [
        // \Petrelli\LiveStatics\Providers\FakerImagePicsumProvider::class,
    ],




    /*
    |--------------------------------------------------------------------------
    | Dynamic fields
    |--------------------------------------------------------------------------
    |
    | When generating dynamic fields, we use URL parameters to modify them
    | These are the options to configure them.
    |
    */

    'dynamic_fields' => [

        // Enable/disable dynamically controlled fields
        'enabled' => false,

        // URL prefix for field names
        'prefix' => 'ls',

        // Edge values to setup our panel controls
        'defaults' => [
            'sentence' => [ 'min' => 3, 'max' => 20 ],
            'text' => [ 'min' => 250, 'max' => 2000 ]
        ]

    ],




    /*
    |--------------------------------------------------------------------------
    | Twill helpers
    |--------------------------------------------------------------------------
    |
    | Twill is a CMS solution developed by Area17. Here we setup a few defaults
    | to help you getting started quickly.
    |
    */

    'twill' => [
        'default_width'  => 640,
        'default_height' => 400,

        'blocks' => [
            Petrelli\LiveStatics\Interfaces\Twill\CarouselBlockInterface::class => [
                Petrelli\LiveStatics\Mocks\Twill\CarouselBlockMock::class, null
            ],
            Petrelli\LiveStatics\Interfaces\Twill\DoubleImageBlockInterface::class => [
                Petrelli\LiveStatics\Mocks\Twill\DoubleImageBlockMock::class, null
            ],
            Petrelli\LiveStatics\Interfaces\Twill\HorizontalLineBlockInterface::class => [
                Petrelli\LiveStatics\Mocks\Twill\HorizontalLineBlockMock::class, null
            ],
            Petrelli\LiveStatics\Interfaces\Twill\ImageBlockInterface::class => [
                Petrelli\LiveStatics\Mocks\Twill\ImageBlockMock::class, null
            ],
            Petrelli\LiveStatics\Interfaces\Twill\IntroBlockInterface::class => [
                Petrelli\LiveStatics\Mocks\Twill\IntroBlockMock::class, null
            ],
            Petrelli\LiveStatics\Interfaces\Twill\ParagraphBlockInterface::class => [
                Petrelli\LiveStatics\Mocks\Twill\ParagraphBlockMock::class, null
            ],
            Petrelli\LiveStatics\Interfaces\Twill\QuoteBlockInterface::class => [
                Petrelli\LiveStatics\Mocks\Twill\QuoteBlockMock::class, null
            ],
            Petrelli\LiveStatics\Interfaces\Twill\SubtitleBlockInterface::class => [
                Petrelli\LiveStatics\Mocks\Twill\SubtitleBlockMock::class, null
            ],
            Petrelli\LiveStatics\Interfaces\Twill\TitleBlockInterface::class => [
                Petrelli\LiveStatics\Mocks\Twill\TitleBlockMock::class, null
            ],
            Petrelli\LiveStatics\Interfaces\Twill\VideoBlockInterface::class => [
                Petrelli\LiveStatics\Mocks\Twill\VideoBlockMock::class, null
            ]
        ]

    ],




    /*
    |--------------------------------------------------------------------------
    | Interface mapper
    |--------------------------------------------------------------------------
    |
    | Shortcut to instantiate interfaces.
    | Sometimes namespaces gets too long, this way we can shorten them.
    | A Facade is provided for this task:
    |
    | \InterfaceMapper::resolve('twill.carousel')
    |
    | will return an instance of Petrelli\LiveStatics\Interfaces\Twill\CarouselBlockInterface::class,
    |
    */

    'mapper' => [
        'twill' => [
            'carousel'       => Petrelli\LiveStatics\Interfaces\Twill\CarouselBlockInterface::class,
            'doubleImage'    => Petrelli\LiveStatics\Interfaces\Twill\DoubleImageBlockInterface::class,
            'horizontalLine' => Petrelli\LiveStatics\Interfaces\Twill\HorizontalLineBlockInterface::class,
            'image'          => Petrelli\LiveStatics\Interfaces\Twill\ImageBlockInterface::class,
            'intro'          => Petrelli\LiveStatics\Interfaces\Twill\IntroBlockInterface::class,
            'paragraph'      => Petrelli\LiveStatics\Interfaces\Twill\ParagraphBlockInterface::class,
            'quote'          => Petrelli\LiveStatics\Interfaces\Twill\QuoteBlockInterface::class,
            'subtitle'       => Petrelli\LiveStatics\Interfaces\Twill\SubtitleBlockInterface::class,
            'title'          => Petrelli\LiveStatics\Interfaces\Twill\TitleBlockInterface::class,
            'video'          => Petrelli\LiveStatics\Interfaces\Twill\VideoBlockInterface::class,
        ]
    ],



];
