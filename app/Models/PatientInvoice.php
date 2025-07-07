<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientInvoice extends Model
{
    protected $fillable = [
        'medical_record_id',
        'amount',
        'status',
        'billed_at',
    ];
    protected $casts = [
        'billed_at' => 'datetime',
    ];
    public function medicalRecord()
    {
        return $this->belongsTo(MedicalRecord::class);
    }

    public function payments()
    {
        return $this->hasMany(PatientPayment::class);
    }
}
