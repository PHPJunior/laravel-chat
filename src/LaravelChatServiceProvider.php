<?php

namespace PhpJunior\LaravelChat;

use Illuminate\Support\ServiceProvider;

class LaravelChatServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__.'/../routes/web.php';

        $this->publishes([$this->configPath() => config_path('laravel-chat.php')]);
        $this->publishes([$this->componentsPath() => base_path('resources/assets/js/components/laravel-chat')]);
        $this->publishes([$this->migrationsPath() => database_path('migrations')]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerControllers();
    }

    /**
     * @return string
     */
    protected function configPath()
    {
        return __DIR__.'/../config/laravel-chat.php';
    }

    /**
     * @return string
     */
    protected function componentsPath()
    {
        return  __DIR__.'/../resources/assets/js/components';
    }

    /**
     * @return string
     */
    protected function migrationsPath()
    {
        return  __DIR__.'/../database/migrations';
    }

    private function registerControllers()
    {
        $this->app->make('PhpJunior\LaravelChat\Http\Controllers\ConversationController');
        $this->app->make('PhpJunior\LaravelChat\Http\Controllers\GroupController');
    }
}
