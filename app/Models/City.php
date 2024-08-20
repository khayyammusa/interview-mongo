<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class City extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'cities';

    protected $fillable = [
        'name',
        'zipCode',
        'country'
    ];

    public $timestamps = false;
}
