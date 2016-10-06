<?php
namespace Xdroid\Translation;

use Illuminate\Routing\Router;
use Illuminate\Translation\TranslationServiceProvider as ServiceProvider;

class TranslationServiceProvider extends ServiceProvider
{
    protected function registerLoader()
    {
        $this->app->singleton('translation.loader', function ($app) {
            return new TranslationLoader($app['files'], $app['path.lang']);
        });
    }

    public function register()
    {
        $this->registerLoader();
        $this->app->singleton('translator', function ($app) {
            $loader = $app['translation.loader'];
            // When registering the translator component, we'll need to set the default
            // locale as well as the fallback locale. So, we'll grab the application
            // configuration so we can easily get both of these values from there.
            $locale = $app['config']['app.locale'];
            $trans = new \Xdroid\Translation\Translator($loader, $locale);
            $trans->setFallback($app['config']['app.fallback_locale']);
            return $trans;
        });

        $this->app['command.translator.import'] = $this->app->share(function($app)
        {
            return new Console\ImportCommand($app['translator']);
        });
        $this->commands('command.translator.import');
    }

    public function boot(Router $router)
	{
        $viewPath = __DIR__.'/../resources/views';
        $this->loadViewsFrom($viewPath, 'translation');

        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/xdroid/translation'),
        ], 'xdroid-translation');

        $migrationPath = __DIR__.'/../database/migrations';
        $this->publishes([
            $migrationPath => base_path('database/migrations'),
        ], 'migrations');

        $config= [
            'namespace' => 'Xdroid\Translation',
            'prefix' => 'translations',
            'middleware' => [
                'web',
                'auth',
            ],
        ];

        $router->group($config, function($router)
        {
            $router->get('{group?}', 'Controller@index')->where(['group' => '.*']);
            $router->post('update-or-create', 'Controller@updateOrCreate');
        });
    }
}
