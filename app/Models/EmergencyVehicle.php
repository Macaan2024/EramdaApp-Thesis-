<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmergencyVehicle extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'agencies_id',
        'vehicleTypes',
        'plateNumber',
        'vehicle_photo',
        'availabilityStatus',
    ];
}
