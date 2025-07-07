<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientPayment extends Model
{
    protected $fillable = [
        'patient_invoice_id',
        'amount_paid',
        'payment_method',
        'paid_at',
    ];
    protected $casts = [
        'paid_at' => 'datetime',
    ];
    public function invoice()
    {
        return $this->belongsTo(PatientInvoice::class, 'patient_invoice_id');
    }
}
