<?php namespace Reshadman\EloquentFaster;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class EloquentFasterServiceProvider extends ServiceProvider {

    /**
     * Name of the key for command binding
     *
     * @var string
     */
    const CACHE_COMMAND_NAME = 'commands.faster_eloquent.cache';

    /*
     * Name of the key for command binding
     *
     * @var string
     */
    const CACHE_CLEAR_COMMAND_CLEAR = 'commands.faster_eloquent.clear';

    /**
     * Booting
     *
     * @return void
     */
    public function boot()
    {
        $this->tryLoadingEloquentCache();

        $this->addCommands();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(static::CACHE_COMMAND_NAME, function($app) {

            return new EloquentCacheCommand(new EloquentClassFinder(), $app['files']);

        });

        $this->app->singleton(static::CACHE_CLEAR_COMMAND_CLEAR, function($app) {

            /** @var Application $app */
            return new EloquentCacheClearCommand($app['files']);

        });
    }

    /**
     * Try loading eloquent cache
     *
     * @return void
     */
    protected function tryLoadingEloquentCache()
    {
        $this->app->booted(function() {

            $array = (array) @include_once EloquentCacheCommand::getCachedEloquentPath();

            if (!empty($array)) {
                FasterModel::loadArrayIntoCachedMutatorAttributes($array);
            }
        });
    }

    /**
     * Add commands to the command container
     *
     * @return void
     */
    protected function addCommands()
    {
        $this->commands([
            self::CACHE_COMMAND_NAME,
            self::CACHE_CLEAR_COMMAND_CLEAR
        ]);
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