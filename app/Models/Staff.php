<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'position',
        'department_id',
        'job_description',
        'hired_date',
        'status'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    protected $statuses = [
        'active' => 'Active',
        'on_leave' => 'On Leave', 
        'inactive' => 'Inactive'
        // Add other statuses as needed
    ];
}
