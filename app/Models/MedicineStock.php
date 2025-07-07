<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicineStock extends Model
{
    protected $fillable = [
        'user_id',
        'medicine_name',
        'batch_number',
        'quantity',
        'expiry_date',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function dispensedMedications()
    {
        return $this->hasMany(DispensedMedication::class);
    }
}
