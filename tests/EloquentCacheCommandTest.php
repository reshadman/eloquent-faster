<?php

namespace Reshadman\EloquentFaster {
    function base_path($path) {
        return '/home/' . $path;
    }
}

namespace Reshadman\EloquentFaster\Tests {

    use Reshadman\EloquentFaster\EloquentCacheCommand;

    class EloquentCacheCommandTest extends \PHPUnit_Framework_TestCase {

        public function test_get_directory_from_path()
        {
            $array = [
                'some',
                'sample',
                'dir'
            ];

            $path = implode(DIRECTORY_SEPARATOR, $array);

            array_pop($array);

            $dir = implode(DIRECTORY_SEPARATOR, $array) .DIRECTORY_SEPARATOR;

            $this->assertEquals($dir, EloquentCacheCommand::getDirectoryFromPath($path));
        }

        public function test_get_cache_path_method()
        {
            $abPath = 'bootstrap/cache/eloquent.php';

            $path = EloquentCacheCommand::getCachedEloquentPath();

            $replaced = str_replace($abPath, '', $path);

            $this->assertNotEquals($replaced, $path);
        }

    }


}