<?php namespace Reshadman\EloquentFaster\Tests;

use Reshadman\EloquentFaster\FasterModel;

class FasterModelTest extends \PHPUnit_Framework_TestCase {

    public function test_get_cached_attributes_method()
    {
        FasterModel::cacheMutatedAttributes(User::class);

        $this->assertTrue(isset(FasterModel::getCachedMutatorAttributes()[User::class]));

        $this->assertContains('url', FasterModel::getCachedMutatorAttributes()[User::class]);
    }

    public function test_load_array_from_cache()
    {
        $array = [
            User::class => [
                'url'
            ]
        ];

        FasterModel::loadArrayIntoCachedMutatorAttributes($array);

        $this->assertEquals(FasterModel::getCachedMutatorAttributes(), $array);
    }

}


class User extends FasterModel {

    public function getUrlAttribute()
    {

    }

}