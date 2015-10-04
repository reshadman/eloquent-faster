<?php namespace Reshadman\EloquentFaster;

use Illuminate\Database\Eloquent\Model;

class FasterModel extends Model {

    /*
     * This trait handles the duty of setting and getting cached attributes
     * You can use it as stand alone trait, if you don't want your model
     * to extend this class
     */
    use MutatorCacheableTrait;

}
