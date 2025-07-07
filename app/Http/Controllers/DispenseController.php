<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{MedicineStock, DispensedMedication, MedicalRecord, AuditTrail};
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Exception;


class DispenseController extends Controller
{ 
    public function index($recordId)
    {
        $stockItems = MedicineStock::all();
        $record = MedicalRecord::with('patient')->findOrFail($recordId);
        return view('pharmacy.dispense', compact('stockItems', 'record'));
    }
    public function dispense(Request $request)
    {
        try {
            // Validate input fields
            $request->validate([
                'stock_item_id' => 'required|exists:medicine_stocks,id',
                'prescription_id' => 'required|exists:medical_records,id',
                'quantity' => 'required|integer|min:1',
            ]);

            // Get stock record
            $stock = MedicineStock::findOrFail($request->stock_item_id);

            if ($stock->quantity < $request->quantity) {
                return back()->withErrors('Not enough stock to dispense.');
            }

            // Reduce stock
            $stock->quantity -= $request->quantity;
            $stock->save();

            // Create dispensed medication record
            DispensedMedication::create([
                'stock_id' => $stock->id,
                'medical_record_id' => $request->prescription_id,
                'user_id' => Auth::id(),
                'quantity' => $request->quantity,
            ]);

            // Log audit
            AuditTrail::create([
                'user_id' => Auth::id(),
                'action' => 'dispense',
                'description' => "Dispensed {$request->quantity} units of {$stock->medicine_name}",
            ]);

            return back()->with('success', 'Medication dispensed successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error dispensing: ' . $e->getMessage());
        }
    }
}
