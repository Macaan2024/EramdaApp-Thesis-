<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IncidentType extends Model
{
    use HasFactory;
    use SoftDeletes;

      protected $fillable = [
        'category',
        'incident_name'
    ];
}
