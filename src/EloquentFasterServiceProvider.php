<?php namespace Reshadman\EloquentFaster;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;

class FasterEloquentServiceProvider extends ServiceProvider {

    /**
     * Name of the key for command binding
     *
     * @var string
     */
    const CACHE_COMMAND_NAME = 'commands.faster_eloquent.cache';

    /**
     * Booting
     *
     * @return void
     */
    public function boot()
    {
        $this->commands(self::CACHE_COMMAND_NAME);

        $this->tryLoadingEloquentCache();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(self::CACHE_COMMAND_NAME, EloquentCacheCommand::class);
    }

    /**
     * Try loading eloquent cache
     *
     * @return void
     */
    protected function tryLoadingEloquentCache()
    {
        $this->app->booted(function() {

            @require_once EloquentCacheCommand::getCachedEloquentPath();

        });
    }

    /**
     * Get file system
     *
     * @return Filesystem
     */
    protected function getFilesystem()
    {
        return $this->app['files'];
    }
}