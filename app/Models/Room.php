<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['room_number', 'capacity', 'current_occupancy', 'status'];

    public function updateStatus()
    {
        if ($this->current_occupancy >= $this->capacity) {
            $this->status = 'full';
        } elseif ($this->current_occupancy > 0) {
            $this->status = 'occupied';
        } else {
            $this->status = 'available';
        }
        $this->save();
    }
    public function assignments()
    {
        return $this->hasMany(RoomAssignment::class);
    }
    public function patients()
    {
        return $this->belongsToMany(Patient::class, 'room_assignments')
                    ->withPivot(['admitted_at', 'discharged_at'])
                    ->withTimestamps();
    }
}
