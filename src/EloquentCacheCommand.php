<?php namespace Reshadman\EloquentFaster;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class EloquentCacheCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eloquent:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Caches eloquent class accessors and mutators.';

    /**
     * @var RecursiveRequirer
     */
    protected $requirer;

    /**
     * @var EloquentClassFinder
     */
    protected $finder;

    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * Create a new command instance.
     *
     * @param EloquentClassFinder $eloquentFinder
     * @param Filesystem $filesystem
     */
    public function __construct(EloquentClassFinder $eloquentFinder, Filesystem $filesystem)
    {
        $this->files = $filesystem;
        $this->requirer = new RecursiveRequirer(app_path());
        $this->finder = $eloquentFinder;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // First remove old cache.
        $this->call('eloquent:clear');

        $this->comment("\nStarting to requiring psr4 php classes...\n");

        // We will first require all classes that exist
        // in the project
        $this->requireAllClasses();

        $this->comment("\n\nStarting to find eloquent models...\n");

        // Now all the classes have been loaded
        // we filter the Eloquent model classes now
        // after recognizing cached attributes are set on them
        $this->loadAllEloquentModels();

        // The final step is to put
        // the cache array into the file
        $this->files->put(
            static::getCachedEloquentPath(),
            '<?php return  ' . var_export(FasterModel::getCachedMutatorAttributes(), true) . ';' . PHP_EOL
        );

        $this->comment("\nEloquent cache set.");
    }

    /**
     * Get cached eloquent path
     *
     * @return string
     */
    public static function getCachedEloquentPath()
    {
        return base_path('bootstrap/cache') . '/eloquent.php';
    }

    /**
     * Get directory from path
     *
     * @param $path
     * @return string
     */
    public static function getDirectoryFromPath($path)
    {
        $exploded = explode(DIRECTORY_SEPARATOR, rtrim($path, DIRECTORY_SEPARATOR));

        array_pop($exploded);

        return implode(DIRECTORY_SEPARATOR, $exploded);
    }

    /**
     * Require all classes inside the directory
     *
     * @return void
     */
    protected function requireAllClasses()
    {
        $this->output->progressStart($this->requirer->getCount());

        foreach ($this->requirer->requireOnceAllFiles() as $file) {

            $this->output->progressAdvance();
            $this->info(" Required : [$file]");

        }

        $this->output->progressFinish();
    }

    /**
     * Find all eloquent models and bootstrap them for cache
     *
     * @return void
     */
    protected function loadAllEloquentModels()
    {
        foreach ($this->finder->find() as $eloquentClass) {

            $this->info("Loaded : [" . $eloquentClass . "]");

            FasterModel::cacheMutatedAttributes($eloquentClass);

        }
    }
}
