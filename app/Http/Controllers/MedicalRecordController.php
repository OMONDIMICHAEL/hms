<?php

namespace App\Http\Controllers;

use App\Models\{MedicalRecord,Patient,User,PatientInvoice,PatientPayment};
// use App\Models\Patient; // Assuming you have a Patient model for the patient relationship
use Illuminate\Support\Facades\{Storage,Auth, DB};
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
            DB::beginTransaction();
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
            DB::commit();
            // Debug the created record
            logger('Created medical record', [
                'id' => $record->id,
                'doctor_id' => $record->doctor_id,
                'patient_id' => $record->patient_id
            ]);
            // $record = MedicalRecord::create($request->all());

            $record->invoice()->create([
                'amount' => $record->amount,
                'status' => 'unpaid',
                'billed_at' => now(),
            ]);


            return redirect()->route('medical-records.index')->with('success', 'Record added.');
            // return redirect()->back()->with('success', 'Record added.');
        } catch (\Exception $e) {
            // Delete the file if it was uploaded but record creation failed
            if (isset($attachmentPath)) {
                Storage::disk('public')->delete($attachmentPath);
            }

            DB::rollBack();
            logger('Medical record creation failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'Failed to create record');
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

        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id', // Changed from users to patients
            'diagnosis' => 'required|string|max:1000',
            'notes' => 'nullable|string|max:2000',
            'prescription' => 'nullable|string|max:2000',
            'recorded_at' => 'required|date',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
        ]);

        DB::beginTransaction();
        try {
            // Handle file upload
            if ($request->hasFile('attachment')) {
                // Delete old attachment if exists
                if ($medicalRecord->attachment) {
                    Storage::disk('public')->delete($medicalRecord->attachment);
                }
                $validated['attachment'] = $request->file('attachment')
                    ->store('medical-record-attachments', 'public');
            }

            // Ensure doctor_id doesn't get overwritten
            unset($validated['doctor_id']);

            $medicalRecord->update($validated);
            
            DB::commit();

            return redirect()->route('medical-records.index')
                   ->with('success', 'Medical record updated successfully')
                   ->with('updated_record', $medicalRecord->fresh());

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update record: '.$e->getMessage())
                         ->withInput();
        }
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

    private function authorizeAccess(MedicalRecord $medicalRecord)
    {
        if (!$medicalRecord->exists) {
            abort(404, 'Medical record not found');
        }
        
        if (is_null($medicalRecord->doctor_id)) {
            abort(403, 'This record has no assigned doctor');
        }
        
        if ($medicalRecord->doctor_id !== auth()->id()) {
            abort(403, 'Only the submitting doctor can update this record');
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
        
        // Get the storage disk
        $disk = Storage::disk('public');
        
        // Verify file exists
        if (!$disk->exists($medicalRecord->attachment)) {
            return back()->with('error', 'The requested file no longer exists');
        }
        
        // Get clean filename for download
        $filename = pathinfo($medicalRecord->attachment, PATHINFO_BASENAME);
        
        // Return download response
        return $disk->download($medicalRecord->attachment, $filename, [
            'Content-Type' => $disk->mimeType($medicalRecord->attachment),
        ]);
    }
}
