<?php

namespace Reshadman\EloquentFaster;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use RegexIterator;

class RecursiveRequirer {

    /**
     * Iterator
     *
     * @var RegexIterator
     */
    protected $iterator;

    /**
     * Default regex filter
     *
     * @var string
     */
    protected $regexFilter;

    /**
     * @param $path
     * @param null $regexFilter
     */
    public function __construct($path, $regexFilter = null)
    {
        $this->regexFilter = $regexFilter;

        if (null === $regexFilter) {
            $this->regexFilter = static::getStudlyCaseRegex();
        }

        $directoryIterator = new RecursiveDirectoryIterator($path);

        $iterator = new RecursiveIteratorIterator($directoryIterator);

        $this->iterator = new RegexIterator($iterator, $this->regexFilter, RecursiveRegexIterator::GET_MATCH);

    }

    /**
     * Requires files in a directory given by a criteria
     *
     * @return array
     */
    public function requireOnceAllFiles()
    {
        foreach ($this->iterator as $fileArray) {

            $file = $fileArray[0];

            require_once (string) $file;

            yield $file;

        }
    }

    /**
     * Get count of current iterator instance
     *
     * @return int
     */
    public function getCount()
    {
        return iterator_count($this->iterator);
    }

    /**
     * Get default regex filter
     *
     * @return string
     */
    public static function getStudlyCaseRegex()
    {
        return "/.*" . '\\' . DIRECTORY_SEPARATOR . '[A-Z]{1}[A-z]*\.php$/';
    }
}