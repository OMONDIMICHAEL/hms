<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DispensedMedication extends Model
{
    protected $fillable = [
        'stock_id',
        'medical_record_id',
        'user_id',
        // 'itemId',
        'quantity',
    ];
}
