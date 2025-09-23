<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Log extends Model
{
    protected $fillable = [
        'interaction_type',
        'user_id',
        'personnel_responder_id',
        'emergency_vehicle_id',
        'incident_type_id',
        'injury_id',
        'barangay_id',
        'agency_id',
        'attendance_id',
        'deployment_id',
        'treatment_service_id',
        'submit_report_id',
        'report_action_id',
        'emergency_room_bed_id',
        'request_id',
    ];


    public function personnelResponder()
    {
        return $this->belongsTo(PersonnelResponder::class, 'personnel_responder_id', 'id');
    }
    public function emergencyVehicle()
    {
        return $this->belongsTo(EmergencyVehicle::class, 'emergency_responder_id', 'id');
    }
}
