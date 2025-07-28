<?php

namespace App\Http\Controllers;

use App\Models\{Recruitment,Department};
use Illuminate\Http\Request;

class RecruitmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recruitments = Recruitment::with('department')->paginate(10);
        return view('recruitments.index', compact('recruitments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();
        return view('recruitments.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'position' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'vacancies' => 'required|integer|min:1',
            'status' => 'required|string|in:open,closed',
        ]);

        Recruitment::create($request->all());

        return redirect()->route('recruitments.index')->with('success', 'Recruitment created!');
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
    public function edit(Recruitment $recruitment)
    {
        $departments = Department::all();
        return view('recruitments.edit', compact('recruitment', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Recruitment $recruitment)
    {
        $request->validate([
            'position' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'vacancies' => 'required|integer|min:1',
            'status' => 'required|string|in:open,closed',
        ]);

        $recruitment->update($request->all());

        return redirect()->route('recruitments.index')->with('success', 'Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recruitment $recruitment)
    {
        $recruitment->delete();

        return redirect()->route('recruitments.index')->with('success', 'Deleted!');
    }
}
