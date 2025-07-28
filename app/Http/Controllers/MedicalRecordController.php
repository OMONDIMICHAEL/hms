<?php

namespace App\Http\Controllers;

use App\Models\{MedicalRecord,Patient,User,PatientInvoice,PatientPayment};
// use App\Models\Patient; // Assuming you have a Patient model for the patient relationship
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\MedicalRecordsExport;
use Illuminate\Validation\Rule;
use Exception;

class MedicalRecordController extends Controller
{
    // can use this if dont want pagination
    // public function index()
    // {
    //     $records = MedicalRecord::with('patient')->where('doctor_id', auth()->id())->get();
    //     return view('doctor.medical_records.index', compact('records'));
    // }

    // this below can paginate if it doesnt return a collection or use where clause
    // public function index()
    // {
    //     $records = MedicalRecord::with('patient')->latest()->paginate(10); // paginate instead of get()
    //     return view('doctor.medical_records.index', compact('records'));
    // }

    public function index()
    {
        $records = MedicalRecord::with('patient', 'invoice')
                    ->where('doctor_id', auth()->id())
                    ->latest()
                    ->paginate(10); // paginate instead of get()

        return view('doctor.medical_records.index', compact('records'));
    }

    public function create()
    {
        // $patients = User::where('role', 'patient')->get();
            $patients = Patient::all(); // Get from patients table, not users
        return view('doctor.medical_records.create', compact('patients'));
    }
    public function search()
    {
        // $patients = User::where('role', 'patient')->get(); dont uncomment this
            $patients = Patient::all(); // Get from patients table, not users
            $medicalRecords = MedicalRecord::all();
        return view('doctor.medical_records.search', compact('patients', 'medicalRecords'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => ['required', Rule::exists('patients', 'id') // Explicitly check users table
            ],
            'diagnosis' => 'required|string',
            'notes' => 'nullable|string',
            'comments' => 'nullable|string',
            'prescription' => 'nullable|string',
            'amount' => 'required',
            'recorded_at' => 'required|date',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
        ]);
        try{
            $attachmentPath = null;
            if ($request->hasFile('attachment')) {
                $attachmentPath = $request->file('attachment')->store('medical-records', 'public');
            }
            // Create the medical record
            if ($attachmentPath && !Storage::disk('public')->exists($attachmentPath)) {
                return back()->with('error', 'Attachment upload failed.');
            }
            if ($attachmentPath && !in_array(pathinfo($attachmentPath, PATHINFO_EXTENSION), ['pdf', 'jpg', 'jpeg', 'png', 'doc', 'docx'])) {
                return back()->with('error', 'Invalid file type for attachment.');
            }
            $record = MedicalRecord::create([
                'doctor_id' => auth()->id(),
                'patient_id' => $validated['patient_id'],
                'diagnosis' => $validated['diagnosis'],
                'notes' => $validated['notes'] ?? null,
                'comments' => $validated['comments'] ?? null,
                'prescription' => $validated['prescription'] ?? null,
                'amount' => $validated['amount'],
                'recorded_at' => $validated['recorded_at'],
                'attachment' => $attachmentPath,
            ]);
            // $record = MedicalRecord::create($request->all());

            $record->invoice()->create([
                'amount' => $record->amount,
                'status' => 'unpaid',
                'billed_at' => now(),
            ]);


            return redirect()->route('medical-records.index')->with('success', 'Record added.');
            // return redirect()->back()->with('success', 'Record added.');
        } catch (Exception $e) {
            // Delete the file if it was uploaded but record creation failed
            if (isset($attachmentPath)) {
                Storage::disk('public')->delete($attachmentPath);
            }

            return back()
                ->withInput()
                ->with('error', 'Error creating record: ' . $e->getMessage());
        }
    }
    public function show(MedicalRecord $medicalRecord)
    {
        $medicalRecord->load('patient');
        $this->authorizeAccess($medicalRecord);
        return view('doctor.medical_records.show', compact('medicalRecord'));
    }

    // public function edit(MedicalRecord $medicalRecord)
    // {
    //     // $medicalRecord->load('patient');
    //     // $this->authorizeAccess($medicalRecord);
    //     $patients = User::where('role', 'patient')->get();
    //     $medicalRecord = MedicalRecord::all();
    //     return view('doctor.medical_records.edit', compact('medicalRecord', 'patients'));
    // }
    // public function edit($id)
    // {
    //     $medicalRecord = MedicalRecord::with('patient')->findOrFail($id);
    //     $this->authorizeAccess($medicalRecord);
    //     return view('doctor.medical_records.edit', compact('medicalRecord'));
    // }
    public function edit(MedicalRecord $medicalRecord)
    {
        $this->authorizeAccess($medicalRecord);
        
        // Load relationships
        $medicalRecord->load('patient');

        // Get all patients for the dropdown
        $patients = Patient::all();

        return view('doctor.medical_records.edit', compact('medicalRecord', 'patients'));
    }
    public function destroy($id)
    {
        $record = MedicalRecord::findOrFail($id);

        // Delete attachment if exists
        if ($record->attachment) {
            Storage::disk('public')->delete($record->attachment);
        }

        $record->delete();

        return redirect()->route('medical-records.index')->with('success', 'Record deleted successfully.');
    }
    public function update(Request $request, MedicalRecord $medicalRecord)
    {
        $this->authorizeAccess($medicalRecord);

        $request->validate([
            'patient_id' => 'required|exists:users,id',
            'diagnosis' => 'required|string',
            'notes' => 'nullable|string',
            'prescription' => 'nullable|string',
            'recorded_at' => 'required|date',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
        ]);

        if ($request->hasFile('attachment')) {
            if ($medicalRecord->attachment) {
                Storage::disk('public')->delete($medicalRecord->attachment);
            }
            $medicalRecord->attachment = $request->file('attachment')->store('attachments', 'public');
        }

        $medicalRecord->update($request->only(['patient_id', 'diagnosis', 'notes', 'prescription', 'recorded_at', 'attachment']));

        return redirect()->route('medical-records.index')->with('success', 'Record updated.');
    }
    public function updateNotes(Request $request, MedicalRecord $medicalRecord)
    {
        $this->authorizeAccess($medicalRecord); // Ensures only the correct doctor can update

        $validated = $request->validate([
            'notes' => 'nullable|string',
        ]);

        $medicalRecord->update($validated);

        return redirect()->route('medical-records.show', $medicalRecord->id)->with('success', 'Record updated successfully.');
    }

    private function authorizeAccess(MedicalRecord $record)
    {
        if ($record->doctor_id !== auth()->id()) {
            abort(403);
        }
    }
    public function searchIndex(Request $request)
    {
        $query = MedicalRecord::with(['patient', 'doctor']);

        if ($request->filled('search')) {
            $query->whereHas('patient', function ($q) use ($request) {
                $q->where('first_name', 'like', "%{$request->search}%")
                  ->orWhere('last_name', 'like', "%{$request->search}%");
            })->orWhere('diagnosis', 'like', "%{$request->search}%");
        }

        if ($request->filled('from')) {
            $query->whereDate('recorded_at', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('recorded_at', '<=', $request->to);
        }

        $medicalRecords = $query->orderBy('recorded_at', 'desc')->paginate(10);

        return view('doctor.medical_records.search', compact('medicalRecords'));
    }

    public function exportPdf(Request $request)
    {
        $records = $this->getFilteredRecords($request);

        $pdf = Pdf::loadView('exports.medical-records-pdf', ['records' => $records]);
        return $pdf->download('medical-records.pdf');
    }

    public function exportExcel(Request $request)
    {
        $records = $this->getFilteredRecords($request);
        return Excel::download(new MedicalRecordsExport($records), 'medical-records.xlsx');
    }

    private function getFilteredRecords(Request $request)
    {
        $query = MedicalRecord::with(['patient', 'doctor']);

        if ($request->filled('search')) {
            $query->whereHas('patient', function ($q) use ($request) {
                $q->where('first_name', 'like', "%{$request->search}%")
                  ->orWhere('last_name', 'like', "%{$request->search}%");
            })->orWhere('diagnosis', 'like', "%{$request->search}%");
        }

        if ($request->filled('from')) {
            $query->whereDate('recorded_at', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('recorded_at', '<=', $request->to);
        }

        return $query->orderBy('recorded_at', 'desc')->get();
    }
    // Download file
    public function downloadMedicalRecord($id)
    {
      $medicalRecord = MedicalRecord::findOrFail($id);
      return Storage::download($medicalRecord->attachment);
    }
}
