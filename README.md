# Eloquent Faster
Simple none-I/O cache for eloquent model accessor and mutators.

### Installation

```php
composer require "reshadman/eloquent-faster"
```
### Usage

First you need to add the following service provider to your application

```php
return [
     //.. other config

     'providers' => [
        // other providers
        \Reshadman\EloquentFaster\EloquentFasterServiceProvider::class
     ]

];
```

Then run the following artisan command
```
php artisan eloquent:cache
```

For clearing cache
```
php artisan eloquent:clear
```

### Problem
Simply the problem begins from [this issuge](https://github.com/laravel/framework/issues/9276).


Currently the eloquent model class contains a cache strategy for getters which first fetches all class methods and runs a loop on them filtering them by a regular expression.
This occurs [only once](https://github.com/laravel/framework/blob/5.1/src/Illuminate/Database/Eloquent/Model.php#L3207) per unique eloquent final object.
The getter cache container is only filled up with the [processed snake case attribute key](https://github.com/laravel/framework/blob/5.1/src/Illuminate/Database/Eloquent/Model.php#L3238).

Each time a new model class is created for first time a loop with 50 to 100 iterations with processing a regular expression is run.

Wouldn't it be cool to have something like ```php artisan eloquent:cache``` for this ?

If you use *OPCACHE* in your PHP installation, this class will not use I/O for each script run, as opcache loads code into memory.

### Running unit tests

Clone the repo

```
git clone git@github.com:reshadman/eloquent-faster.git
```

Then run ```composer update```

Now you can run phpunit in the repo folder.
```
vendor/bin/phpunit
```

