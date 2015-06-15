<?php namespace Reshadman\EloquentFaster;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string hello
 */
class EloquentClassFinder {

    /**
     * Finds eloquent models in the current script declared class
     *
     * @return \Generator|array
     */
    public static function find()
    {
        $classes = get_declared_classes();

        foreach($classes as $class) {

            if (is_a($class, Model::class, true)) {

                yield $class;

            }

        }
    }

}