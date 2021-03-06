<?php

namespace Petrelli\LiveStatics;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

use Petrelli\LiveStatics\Commands\CreateMockedModel;
use Petrelli\LiveStatics\Commands\CreateMockedClass;
use Petrelli\LiveStatics\Facades\DynamicParams;
use Petrelli\LiveStatics\Facades\InterfaceMapperFacade;
use Petrelli\LiveStatics\Helpers\DynamicManager;
use Petrelli\LiveStatics\Helpers\InterfaceMapper;
use Petrelli\LiveStatics\Helpers\Faker\Factory as MiddlewareFactory;

class BaseServiceProvider extends ServiceProvider
{


    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        // Register laravel directives
        $this->registerLaravelDirectives();

        // Register command to publish the configuration file
        $this->publishConfig();

        // Load extra views - Specifically for the dynamic menu
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'live-statics');

    }


    public function publishConfig()
    {

        $this->publishes([
            __DIR__.'/../config/live-statics.php' => config_path('live-statics.php'),
        ]);

        $this->publishes([
            __DIR__.'/Providers/LiveStaticsServiceProvider.php' => app_path('Providers/LiveStaticsServiceProvider.php'),
        ]);

    }


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        // Merge configurations
        $this->mergeConfigs();

        // Enable mocked elements when the configured subdomain is present
        // Also save which version we are trying to load

        $domain = $this->app->request->getHttpHost();
        $fullSubdomain = explode('.', $domain)[0];

        $subdomain = preg_replace('/[^a-zA-Z]/', '', $fullSubdomain);
        $version = (Integer) preg_replace('/[^0-9]/', '', $fullSubdomain);

        $enabled = explode('.', $subdomain)[0] == config('live-statics.subdomain');

        \Config::set(['live-statics' => array_merge(config('live-statics'), [
            'enabled' => $enabled,
            'version' => $version,
        ])]);


        // Bind Dynamic manager for attributes
        $this->app->singleton('live-statics.manager', function($app) {
            return new DynamicManager();
        });

        // Register dynamic fields manager Facade
        AliasLoader::getInstance()->alias('DynamicManager', DynamicParams::class);

        // Bind Class Resolver
        $this->app->singleton('live-statics.interface-mapper', function($app) {
            return new InterfaceMapper();
        });

        // Bind Interface Mapper Facade
        AliasLoader::getInstance()->alias('InterfaceMapper', InterfaceMapperFacade::class);

        // Bind helper libraries to be used when mocking entities
        $this->bindHelpers($version);


        // Bind elements automatically using mockedModels, mockedRepositories variables
        $this->bindElements($enabled, $version);

        // Register Commands
        $this->commands([
            CreateMockedModel::class,
            CreateMockedClass::class
        ]);

    }


    protected function bindElements($enabled = false, $version = 0)
    {

        /**
         *
         *  Bind elements automatically. It uses a simple filename convention.
         *  See mockedModels, mockedRepositories, mockedBlocks variables definitions
         *
         */

        if (is_array(config('live-statics.mocked_models'))) {

            foreach (config('live-statics.mocked_models') as $model) {

                $interface = join('\\', array_filter([config('live-statics.base_namespace'), config('live-statics.path_interfaces'), config('live-statics.path_models'), $model . 'Interface']));

                $this->app->bind($interface, function () use ($enabled, $model, $version) {
                    if ($enabled) {

                        $entity = join('\\', array_filter([config('live-statics.base_namespace'), config('live-statics.path_mocks'), config('live-statics.path_models'), $model . 'Mock']));

                        if ($version) {
                            $versionedEntity = $entity . $version;

                            if (class_exists($versionedEntity)) {
                                $entity = $versionedEntity;
                            }
                        }

                        return $entity::create();
                    } else {
                        return app(join('\\', array_filter([config('live-statics.base_namespace'), config('live-statics.path_models'), $model])));
                    }
                });
            }

        }

        if (is_array(config('live-statics.mocked_classes'))) {

            foreach (config('live-statics.mocked_classes') as $interface => $items) {

                $classes = collect($items);
                $mocked  = $classes->first();
                $real    = $classes->last();

                if ($enabled || (!$enabled && $real)) {
                    $this->bindVersionedClass($enabled, $version, $interface, $mocked, $real);
                }

            }

        }

        /**
         *
         * Add-on: Build twill blocks
         *
         */
        if (is_array(config('live-statics.twill.blocks'))) {

            foreach (config('live-statics.twill.blocks') as $interface => $items) {

                $classes = collect($items);
                $mocked  = $classes->first();
                $real    = $classes->last();

                if ($enabled || (!$enabled && $real)) {
                    $this->bindVersionedClass($enabled, $version, $interface, $mocked, $real);
                }

            }

        }

    }


    protected function bindHelpers($version = 0)
    {

        $this->app->singleton('faker', function ($app) use ($version) {
            $faker = MiddlewareFactory::create();

            // Add all providers specified at the configuration file.
            // If you want to extend this functionality please refer to
            // LiveStaticsServiceProvider, there you will find advanced examples

            foreach (config('live-statics.faker_providers') as $provider) {
                $faker->addProvider(new $provider($faker));
            }

            return $faker;
        });

    }


    protected function bindVersionedClass($enabled, $version, $interface, $mocked, $real)
    {

        $this->app->bind($interface, function () use ($enabled, $version, $mocked, $real) {
            if ($enabled) {

                if ($version) {
                    $versionedEntity = $mocked . $version;

                    if (class_exists($versionedEntity)) {
                        $mocked = $versionedEntity;
                    }
                }

                return $mocked::create();
            } else {
                return app($real);
            }
        });

    }


    protected function registerLaravelDirectives()
    {

        Blade::directive('static', function ($key) {
            return "<?php if (config('live-statics.enabled')): ?>";
        });

        Blade::directive('endstatic', function ($key) {
            return "<?php endif; ?>";
        });

        Blade::directive('nonstatic', function ($key) {
            return "<?php if (!config('live-statics.enabled')): ?>";
        });

        Blade::directive('endnonstatic', function ($key) {
            return "<?php endif; ?>";
        });

    }


    private function mergeConfigs()
    {

        $this->mergeConfigFrom(__DIR__ . '/../config/live-statics.php', 'live-statics');

    }


}

