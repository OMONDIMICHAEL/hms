<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recruitment extends Model
{
    protected $fillable = [
        'position',
        'department_id',
        'vacancies',
        // 'open_date',
        'close_date',
        'status'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
