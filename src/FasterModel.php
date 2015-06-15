<?php namespace Reshadman\EloquentFaster;

use Illuminate\Database\Eloquent\Model;

class FasterModel extends Model {

    /*
     * This trait handle the duty of setting and getting cached attributes
     * You can use it as stand alone if you don't want your model
     * to extends this class
     */
    use MutatorCacheableTrait;

}