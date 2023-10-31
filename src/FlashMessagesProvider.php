<?php

namespace CyberPunkCodes\FlashMessages;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

use CyberPunkCodes\FlashMessages\Facades\FlashMessages;
use CyberPunkCodes\FlashMessages\Views\Components\Container;
use CyberPunkCodes\FlashMessages\Views\Components\Message;

class FlashMessagesProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('flashmessages', function($app) {
            return new FlashMessages();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::componentNamespace('CyberPunkCodes\\FlashMessages\\Views\\Components', 'flashmessages');

        if ($this->app->runningInConsole()) {

            /**
             * Publishing config files
             */


            // config: bootstrap 4
            $this->publishes([
                __DIR__. '/../resources/bootstrap4/config/config.php' => config_path('flashmessages.php'),
            ], 'bootstrap4-config');

            // config: bootstrap 5
            $this->publishes([
                __DIR__. '/../resources/bootstrap5/config/config.php' => config_path('flashmessages.php'),
            ], 'bootstrap5-config');

            // config: tailwind v2
            $this->publishes([
                __DIR__. '/../resources/tailwind2/config/config.php' => config_path('flashmessages.php'),
            ], 'tailwind2-config');


            /**
             * Publishing view files
             */


            // view: bootstrap v4
            $this->publishes([
                __DIR__ . '/../resources/bootstrap4/views' => resource_path('views/vendor/flashmessages'),
            ], 'bootstrap4-views');

            // view: bootstrap v5
            $this->publishes([
                __DIR__ . '/../resources/bootstrap5/views' => resource_path('views/vendor/flashmessages'),
            ], 'bootstrap5-views');

            // view: tailwind v2
            $this->publishes([
                __DIR__ . '/../resources/tailwind2/views' => resource_path('views/vendor/flashmessages'),
            ], 'tailwind2-views');

        }

        $this->loadViewComponentsAs('flashmessages', [
            Container::class,
            Message::class,
        ]);

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'flashmessages');

        // create our `flash()` macro
        RedirectResponse::macro('flash', function (string $type, string $message, array $config = []) {
            FlashMessages::addFlashMessage($type, $message, $config);
            return $this;       // returns the Redirector
        });
    }
}
