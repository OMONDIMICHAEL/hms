<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $rooms = Room::all();
        $rooms = Room::paginate(10);
        return view('facility.rooms.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('facility.rooms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'room_number' => 'required|unique:rooms',
            'capacity' => 'required|integer|min:1',
        ]);

        Room::create([
            'room_number' => $request->room_number,
            'capacity' => $request->capacity,
            'current_occupancy' => 0,
        ]);

        return redirect()->route('rooms.index')->with('success', 'Room created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        return view('facility.rooms.edit', compact('room'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        $request->validate([
            'room_number' => 'required|unique:rooms,room_number,' . $room->id,
            'capacity' => 'required|integer|min:1',
        ]);

        $room->update($request->only(['room_number', 'capacity']));
        $room->updateStatus();

        return redirect()->route('rooms.index')->with('success', 'Room updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('rooms.index')->with('success', 'Room deleted.');
    }
    public function dashboard()
    {
        $totalRooms = Room::count();
        $availableRooms = Room::where('status', 'available')->count();
        $fullRooms = Room::where('status', 'full')->count();
        $occupiedRooms = Room::where('status', 'occupied')->count();

        // Data for Room Status Chart (doughnut)
        $chartData = [
            'labels' => ['Available', 'Full', 'Occupied'],
            'data' => [$availableRooms, $fullRooms, $occupiedRooms]
        ];

        // Calculate average occupancy rates by status for the second chart
        $statuses = ['available', 'full', 'occupied'];
        
        $occupancyData = [
            'labels' => [],
            'data' => []
        ];

        foreach ($statuses as $status) {
            $rooms = Room::where('status', $status)->get();
            $totalCapacity = $rooms->sum('capacity');
            $totalOccupancy = $rooms->sum('current_occupancy');
            
            $occupancyRate = $totalCapacity > 0 ? round(($totalOccupancy / $totalCapacity) * 100) : 0;
            
            $occupancyData['labels'][] = ucfirst($status);
            $occupancyData['data'][] = $occupancyRate;
        }

        $rooms = Room::with('assignments.patient')->paginate(10);

        return view('facility.rooms.dashboard', compact(
            'totalRooms', 
            'availableRooms', 
            'fullRooms', 
            'occupiedRooms', 
            'chartData', 
            'occupancyData',
            'rooms'
        ));
    }
    public function occupancyData()
    {
        $rooms = Room::withCount(['assignments as current_occupancy' => function ($query) {
            $query->whereNull('discharged_at');
        }])->get();

        return response()->json($rooms);
    }
}
