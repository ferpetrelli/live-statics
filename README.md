# About Live-Statics

[![Build Status](https://travis-ci.org/ferpetrelli/live-statics.svg?branch=master)](https://travis-ci.org/ferpetrelli/live-statics)

The `petrelli\live-statics` package provides a quick way to generate and integrate fake prototypes into our system. Mocked objects can easily be model to behave as the real ones, so you won't have to spend any time with integration tasks.

Both real and mocked data sources will live together so you will be able you to switch between them at any time by simply changing the subdomain.

A great secondary effect is that because our fake objects behave as real, a fully functional 'live static' version of your web application will be accessible to explore and click around.

Faker content can be parametrized, so your 'live statics' will change by just passing some URL parameters. This will come incredibly handy to perform visual QA, client presentations, and simply just to have a glance on how your site will behave with different types of content.

# Quick demo

Let's explore a few links:

1. <a href="http://fernandopetrelli.com" target="_blank">Open</a>. A real personal website.
2. <a href="http://static.fernandopetrelli.com" target="_blank">Open</a>. Same URL with a `static` subdomain.

Notice the Projects list. It's just a simple loop within an Eloquent model collection.

On the second link, it's also a collection, but instead of Eloquent, it's using our mocked models. It's using the same views and controller.


# Install

1. Include the package

You can run the command:

```bash
composer require petrelli/live-statics
```

Or directly add it to your composer.json

```json
"petrelli/live-statics": "^0.0.1"
```

And run `composer update`.


2. If you have Package Auto-discovery (Laravel 5.5+ by default) skip to step 3, otherwise you'll have to manually add the service provider to your `config/app.php` file.

```php
'providers' => [
    //...
    Petrelli\LiveStatics\BaseServiceProvider::class,
    //...
]
```

3. Publish configuration files and the Service Provider

```
php artisan vendor:publish --provider="Petrelli\LiveStatics\BaseServiceProvider"
```


# Usage


## Create a new mocked class, and it's interface


1. Generate a new Mocked class (e.g. Project). Run the command:

```bash
php artisan live-statics:class Project
```

This will use the configuration values inside `config/live-statics.php` to generate a base mocked class `Project`, plus an interface `ProjectInterface` that will allow you to bind it to the real or fake implementation.

2. Add binding instructions to `config/live-statics.php`

```php
'mocked_classes' => [
    \App\Interfaces\ProjectInterface::class => [
        \App\Mocks\ProjectMock::class, \App\Project::class
    ],
],
```

Convention is the following:

```
'mocked_classes' => [
    INTERFACE1 => [ MOCKED_CLASS1, REAL_CLASS1 ],
    //...
    INTERFACEn => [ MOCKED_CLASSn, REAL_CLASSn ],
]
```

This will be enough to use your interfaces to inject them properly!

If your real class is not ready yet and you just want a quick prototype, pass `null` as the second element of the array.

```
'mocked_classes' => [
    INTERFACE1 => [ MOCKED_CLASS1, null ],
    //...
]
```


## Once you have your Mocked classes, remember to implement the interface in the real one.

Following our project example:

```php
use App\Interfaces\ProjectInterface;

class Project extends Model implements ProjectInterface
{
    #...
}
```

## Using your newly created mocked elements

Let's use a controller as an example:

```php
use \App\Interfaces\ProjectInterface;

class Controller extends BaseController
{
    public function index(ProjectInterface $model)
    {
        # Use your Project instance as normal
        # $model->all();
        # $model->published()->get();
    }
}

```

Here we inject `ProjectInterface` to the controller. This will bind the real, or mocked implementation depending on the subdomain.

If you are not confortable injecting dependencies as formal parameters you can use Laravels `app` function:

```php
use \App\Interfaces\ProjectInterface;


class Controller extends BaseController
{
    public function index()
    {
        $model = app(ProjectInterface:class);

        # Use your Project instance as normal
        # $model->all();
        # $model->published()->get();
    }
}

```


That's it!

You can change this subdomain modifying the `subdomain` option inside `config/live-statics.php`.


## Shortcut for Eloquent models

This is a special case of a general class.

The package will provide a quick way for you to bind models, as most applications will be mainly mocking Eloquent models.


1. Generate the mocked model

```bash
php artisan live-statics:model Project
```

2. Add binding instructions to `config/live-statics.php`

```php
'mocked_models' => [
    'Project',
]
```

Notice instead of `mocked_classes`, we use `mocked_models`, and just pass the model's name.

The package will use path configurations for models provided on `config/live-statics.php` to bind them properly.





## Add a custom namespace when creating new mocked classes or models

Keep your code organized creating namespaces for your mocked elements. Folders will be generated automatically.

This can be easily done passing by a second parameter to both commands:

```bash
# Prepend Api to the new class namespace
php artisan live-statics:class Project Api

# Prepend Api\Version1 to the new class namespace
php artisan live-statics:class Project Api\\Version1 #or
php artisan live-statics:class Project Api/Version1

# Prepend Api to the new model namespace
php artisan live-statics:model Project Api

# Prepend Api\Version1 to the new model namespace
php artisan live-statics:model Project Api\\Version1 #or
php artisan live-statics:model Project Api/Version1
```

When creating models, the namespace specified within `config/live-statics.php` will be added automatically.


# Extra functionalities

Docs to be completed.

## Dynamic parameters

Docs to be completed.

## Namespaces and directories configuration

Docs to be completed.

## Extending Faker through providers

Docs to be completed.

## Creating different versions of your mocked classes

Docs to be completed.

## Modifying your statics in real time through URL parameters

Docs to be completed.

## Partial mocking

Docs to be completed.


# License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
