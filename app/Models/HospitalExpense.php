<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalExpense extends Model
{
    use HasFactory;

    protected $fillable = [
        'expense_type',
        'description',
        'amount',
        'expense_date',
    ];
    public const EXPENSE_TYPES = [
        'Utilities',
        'Salaries',
        'Maintenance',
        'Equipment',
        'Supplies',
        'Transport',
        'Others'
    ];
    protected $casts = [
        'expense_date' => 'date',
        'amount' => 'float',
    ];
}
