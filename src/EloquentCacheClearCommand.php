<?php namespace Reshadman\EloquentFaster;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class EloquentCacheClearCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eloquent:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove cache for eloquent class accessor and mutators.';

    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * Create a new command instance.
     *
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->files = $filesystem;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info("Starting to clear cache...");

        if ($this->files->exists($path = EloquentCacheCommand::getCachedEloquentPath())) {

            $this->files->delete($path);

            $this->info("Cache cleared.");

        }else {

            $this->comment("No cache to clear.");

        }
    }
}
