<?php

namespace App\Http\Controllers;

use App\Models\{Room,RoomAssignment,Patient};
use Illuminate\Http\Request;

class RoomAssignmentController extends Controller
{
    public function index()
    {
        $rooms = Room::whereColumn('current_occupancy', '<', 'capacity')->get();
        $patients = Patient::all();
        return view('facility.rooms.assign_room', compact('rooms', 'patients'));
    }
    // admit patient
    public function assignPatientToRoom(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'patient_id' => 'required|exists:patients,id',
        ]);

        $room = Room::find($request->room_id);

        // Count active patients
        $currentOccupants = $room->assignments()->whereNull('discharged_at')->count();

        if ($currentOccupants >= $room->capacity) {
            return back()->with('error', 'Room is already full.');
        }

        RoomAssignment::create([
            'room_id' => $room->id,
            'patient_id' => $request->patient_id,
            'assigned_at' => now(),
        ]);
        $room = Room::find($request->room_id);
        $room->increment('current_occupancy');
        $room->updateStatus();
        // on patient discharge add this below after discharging
        // $room->decrement('current_occupancy');
        // $room->updateStatus();

        return back()->with('success', 'Patient admitted successfully.');
    }
    public function dischargePatient($id)
    {
        $assignment = RoomAssignment::findOrFail($id);
        $room = $assignment->room;

        $assignment->update(['discharged_at' => now()]);

        $room->current_occupancy -= 1;
        // $room->status = 'available';
        $room->updateStatus();
        // $room->save();
        $RoomAssignment = RoomAssignment::findOrFail($id)->delete();
        return redirect()->route('rooms.dashboard')->with('success', 'Patient discharged.');
        // i should use the admit function in my assignpatienttoroom above, its more logical.
    }
}
