<?php namespace Reshadman\EloquentFaster\Tests;

use Reshadman\EloquentFaster\RecursiveRequirer;

class RecursiveRequirerTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var RecursiveRequirer
     */
    protected $_object;

    public function setUp()
    {
        $this->_object = new RecursiveRequirer(__DIR__ . '/../src');
    }

    public function test_require_once_method()
    {
        iterator_to_array($this->_object->requireOnceAllFiles());
        $this->assertContains('Reshadman\EloquentFaster\FasterModel', $classes = get_declared_classes());
        $this->assertContains('Reshadman\EloquentFaster\EloquentCacheClearCommand', $classes);
    }

}