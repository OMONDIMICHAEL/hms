<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'appointments';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'patient_id',
        'doctor_name',
        'appointment_date',
        'appointment_time',
        'reason',
        'status',
    ];
    
}
