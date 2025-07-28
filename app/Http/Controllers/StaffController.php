<?php

namespace App\Http\Controllers;

use App\Models\{Staff, Department, Recruitment};
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staff = Staff::with('department')->paginate(10);
        return view('staff.index', compact('staff'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();
        return view('staff.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'required|email|unique:staff,email',
            'position'   => 'required',
            'department_id' => 'nullable|exists:departments,id',
        ]);

        Staff::create($request->all());
        return redirect()->route('staff.index')->with('success', 'Staff added successfully.');
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
    public function edit($id)
    {
        $staff = Staff::findOrFail($id);  // Get only one record
        $departments = Department::all();
        return view('staff.edit', compact('staff', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Staff $staff)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'required|email|unique:staff,email,' . $staff->id,
            'position'   => 'required',
        ]);

        $staff->update($request->all());
        return redirect()->route('staff.index')->with('success', 'Staff updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Staff $staff)
    {
        $staff->delete();
        return redirect()->route('staff.index')->with('success', 'Staff deleted.');
    }
    public function dashboard()
    {
        // Total staff count
        $totalStaff = Staff::count();

        // Staff per department
        $staffPerDept = Department::withCount('staff')->get();

        // Active recruitment positions (assuming 'status' column: open/closed)
        $activeRecruitments = Recruitment::where('status', 'open')->count();

        return view('staff.dashboard', compact('totalStaff', 'staffPerDept', 'activeRecruitments'));
        // dd($totalStaff, $staffPerDept, $activeRecruitments);
    }
}
