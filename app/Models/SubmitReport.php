<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubmitReport extends Model
{
    protected $fillable = [
        'agency_id',
        'barangay_id',
        'incident_types_id',
        'incidentLatitude',
        'incidentLongitude',
        'numberOfDeaths',
        'numberOfInjuries',
        'time',
        'day',
        'month',
        'status',
        'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_id', 'id');
    }

    public function log()
    {
        return $this->hasMany(Log::class, 'submit_report_id', 'id');
    }

    public function incidentType()
    {
        return $this->belongsTo(IncidentType::class, 'incident_types_id', 'id');
    }
}
