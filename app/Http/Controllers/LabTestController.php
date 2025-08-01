<?php

namespace App\Http\Controllers;

use App\Models\LabTest;
use App\Models\MedicalRecord;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Exception;
use Illuminate\Http\Request;

class LabTestController extends Controller
{
    public function index()
    {
        $labTests = LabTest::with('medicalRecord.patient')->latest()->paginate(10);
        return view('lab_tests.index', compact('labTests'));
    }

    public function create(MedicalRecord $record)
    {
        return view('lab_tests.create', compact('record'));
    }

    public function store(Request $request)
    {
        try{
        $validated = $request->validate([
            'medical_record_id' => 'required|exists:medical_records,id',
            'test_name' => 'required|string|max:255',
            'results' => 'nullable|string',
            'status' => 'required|in:pending,completed,in-progress,cancelled',
            'attachment' => 'nullable|file|mimes:jpg,png,pdf',
            'tested_at' => 'nullable|date',
        ]);

        if ($request->hasFile('attachment')) {
            $validated['attachment'] = $request->file('attachment')->store('lab_results', 'public');
        }

        LabTest::create($validated);

        return redirect()->route('lab-tests.index')->with('success', 'Lab test recorded successfully.');
        } catch (Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error creating record: ' . $e->getMessage());
        }
    }
}
