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
    | These variables will control your directory structure
    | Default values are usually ok for most projects
    |
    | Given that these values are used to bind elements and generate new mocks,
    | do not to modify them once the project has started.
    |
    | Laravel models don't use namespaces by default, added
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
    | plus the full path to the desired mocked element, and the real class
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
    | Helper to quickly bind mocked models.
    | It will use `path_models` to search for the mocked class,the real class,
    | and it's interface on their respective directories.
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
    | Added as a simple way to change the way to bind models. You usually won't
    | need to modify this
    |
    */

    'base_namespace'  => 'App',



    /*
    |--------------------------------------------------------------------------
    | Faker extra providers
    |--------------------------------------------------------------------------
    |
    | To generate better content for your site you can specify faker providers
    | classes here and they will be added automatically when creating the
    | singleton instance.
    |
    | Here as a working example, you can use a new image provider
    | to generate Picsum URL's instead of the default Lorempixel ones
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
    | These are the options to configure them
    |
    */

    'dynamic_fields' => [

        'enabled' => false,

        'prefix' => 'ls',

        // Edge values for form controls
        'defaults' => [
            'sentence'  => [ 'min' => 3, 'max' => 20 ],
            'text' => [ 'min' => 250, 'max' => 2000 ]
        ]

    ],



    /*
    |--------------------------------------------------------------------------
    | Addons
    |--------------------------------------------------------------------------
    |
    | Space reserved to setup Live Statics Addons if needed
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Twill helpers
    |--------------------------------------------------------------------------
    |
    | Support for images and the block builder
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
    | This is just a shortcut for when you want to instantiate interfaces.
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
