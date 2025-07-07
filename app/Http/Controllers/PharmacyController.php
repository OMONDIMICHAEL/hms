<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicalRecord;
use App\Models\MedicineStock;
use App\Models\Patient;

class PharmacyController extends Controller
{
    public function dispense($recordId)
    {
        $record = MedicalRecord::with('patient')->findOrFail($recordId);
        
        // Here you'd reduce stock from inventory based on prescription logic

        $record->update(['dispensed' => true]);

        return redirect()->back()->with('success', 'Medication dispensed.');
    }
    public function alerts()
    {
        $lowStockThreshold = 10;
        $today = now();

        $lowStock = MedicineStock::where('quantity', '<', $lowStockThreshold)->get();
        $expiringSoon = MedicineStock::whereDate('expiry_date', '<=', $today->addDays(30))->get();

        return view('pharmacy.alerts', compact('lowStock', 'expiringSoon'));
    }
}
