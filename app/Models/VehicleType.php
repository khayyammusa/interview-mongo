<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class VehicleType extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'vehicleTypes';

    protected $fillable = [
        'number',
        'cost_km',
        'minimum'
    ];

    public $timestamps = false;
}
