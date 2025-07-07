<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'notes',
        'comments',
        'diagnosis',
        'prescription',
        'amount',
        'attachment',
        'recorded_at',
    ];

    // public function patient() {
    //     return $this->belongsTo(User::class, 'patient_id');
    // }
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor() {
        return $this->belongsTo(User::class, 'doctor_id');
    }
    // public function doctor() {
    //     return $this->belongsTo(User::class);
    // }
    public function invoice()
    {
        return $this->hasOne(PatientInvoice::class);
    }
    public function dispensations()
    {
        return $this->hasMany(Dispensation::class);
    }
}
