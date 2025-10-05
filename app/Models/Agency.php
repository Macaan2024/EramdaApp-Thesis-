<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Agency extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'agencyNames',
        'agencyTypes',
        'email',
        'barangay',
        'city',
        'address',
        'longitude',
        'latitude',
        'zipcode',
        'activeStatus',
        'logo'
    ];

    public function user(): HasMany
    {
        return $this->hasMany(User::class, 'agency_id', 'id');
    }

    public function personnelResponder(): HasMany
    {
        return $this->hasMany(PersonnelResponder::class);
    }
}
