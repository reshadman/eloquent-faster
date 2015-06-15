<?php namespace Reshadman\EloquentFaster;

/**
 * Class MutatorCacheableTrait
 * @package Reshadman\EloquentFaster
 * @property array mutatorCache
*/
trait MutatorCacheableTrait {

    /**
     * Get cached mutator attributes
     *
     * @return array
     */
    public static function getCachedMutatorAttributes()
    {
        return static::$mutatorCache;
    }

    /**
     * Load array of cached mutators into the cache container
     *
     * @param array $array
     */
    public static function loadArrayIntoCachedMutatorAttributes(array &$array)
    {
        static::$mutatorCache = $array;
    }

}