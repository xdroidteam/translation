<?php
namespace XdroidTeam\Translation;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

class TranslationServiceProvider extends ServiceProvider implements DeferrableProvider
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
            if($app instanceof \Laravel\Lumen\Application){
                //Lumen
                $app->configure('app');
                $app->configure('xdroidteam-translation');
                $app->instance('path.lang', $this->getLanguagePath());
            }
            $loader = $app['translation.loader'];
            // When registering the translator component, we'll need to set the default
            // locale as well as the fallback locale. So, we'll grab the application
            // configuration so we can easily get both of these values from there.
            $locale = $app['config']['app.locale'];
            $trans = new \XdroidTeam\Translation\Translator($loader, $locale);
            $trans->setFallback($app['config']['app.fallback_locale']);
            return $trans;
        });

        $app = $this->app;

        if ($app instanceof \Illuminate\Foundation\Application) {
            // Laravel   
            $this->app['command.translator.import'] = new Console\ImportCommand($this->app['translator']);
            $this->commands('command.translator.import');
        } 

    }

    public function boot()
	{
        if ($this->app instanceof \Illuminate\Foundation\Application) {
            // Laravel
            $viewPath = __DIR__.'/../resources/views';
            $this->loadViewsFrom($viewPath, 'translation');

            $this->publishes([
                __DIR__.'/../database/migrations' => base_path('database/migrations'),
                __DIR__.'/../config/xdroidteam-translation.php' => config_path('xdroidteam-translation.php'),
            ], 'xdroidteam-translation');
            
            $config = array_merge(['namespace' => 'XdroidTeam\Translation'], config('xdroidteam-translation.route', []));
            $router = app()->router;
            $router->group($config, function($router)
            {
                $router->get('/', function(){
                    return redirect()->to(url()->current() . '/missing');
                });
                $router->get('/missing', 'Controller@missing');
                $router->get('/all', 'Controller@all');
                $router->get('/group/{group?}', 'Controller@index')->where(['group' => '.*']);
                $router->post('update-or-create', 'Controller@updateOrCreate');
            });
    
            view()->composer(['translation::index', 'translation::group'], 'XdroidTeam\Translation\ViewComposer');
        }

    }

    public function provides()
    {
        return ['translator', 'translation.loader'];
    }

    /**
     * Get the path to the application's language files.
     *
     * @return string
     */
    protected function getLanguagePath()
    {
        if (is_dir($langPath = $this->app->basePath().'/resources/lang')) {
            return $langPath;
        } else {
            return __DIR__.'/../resources/lang';
        }
    }
}
