<?php namespace Reshadman\EloquentFaster\Tests;

use Illuminate\Database\Eloquent\Model;
use Reshadman\EloquentFaster\EloquentClassFinder;
use Reshadman\EloquentFaster\FasterModel;

class EloquentClassFinderTest extends \PHPUnit_Framework_TestCase {

    public function test_eloquent_class_is_detected()
    {
        $testClasses = [
            SomeExampleModelClass::class,
            SomeExampleModelClassWithEloquent::class
        ];

        $finder = new EloquentClassFinder();

        $classes = iterator_to_array($finder->find());

        foreach ($testClasses as $testClass) {
            $this->assertContains($testClass, $classes);
        }
    }


}

class SomeExampleModelClass extends FasterModel {

}

class SomeExampleModelClassWithEloquent extends Model {

}