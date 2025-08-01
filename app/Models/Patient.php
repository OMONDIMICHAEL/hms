<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
protected $table = 'patients';
/**
 * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'date_of_birth',
        'phone',
        'email',
        'address',
        'medical_history',
        'insurance_provider',
        'insurance_number',
    ];
    public function roomAssignments()
    {
        return $this->hasMany(RoomAssignment::class);
    }
    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'room_assignments')
                    ->withPivot(['admitted_at', 'discharged_at'])
                    ->withTimestamps();
    }
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

}
