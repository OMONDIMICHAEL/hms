<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicalRecord;
use App\Models\MedicineStock;

class MedicineStockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stocks = MedicineStock::orderBy('created_at', 'desc')->paginate(10);
        return view('pharmacy.stocks.index', compact('stocks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pharmacy.stocks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated=$request->validate([
            'medicine_name' => 'required|string',
            'batch_number' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
            'expiry_date' => 'nullable|date',
        ]);
        $validated['user_id'] = auth()->id();

        MedicineStock::create($validated);
        // MedicineStock::create($request->all());

        return redirect()->route('stocks.index')->with('success', 'Stock added successfully.');
    }
    public function alerts()
    {
        $lowStockThreshold = 10;
        $expiryThreshold = now()->addDays(30);

        $lowStock = MedicineStock::where('quantity', '<=', $lowStockThreshold)->get();
        $expiringSoon = MedicineStock::whereDate('expiry_date', '<=', $expiryThreshold)->get();

        return view('pharmacy.alerts', compact('lowStock', 'expiringSoon'));
    }
    public function dispense($lowStock)
    {
        // $records = MedicalRecord::with('patient')->where('doctor_id', auth()->id())->get();
        return view('pharmacy.dispense', compact('lowStock'));
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
    public function edit(MedicineStock $stock)
    {
        return view('pharmacy.stocks.edit', compact('stock'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MedicineStock $stock)
    {
        $request->validate([
            'medicine_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'expiry_date' => 'nullable|date',
        ]);

        $stock->update($request->all());

        return redirect()->route('pharmacy.alerts')->with('success', 'Stock updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MedicineStock $stock)
    {
        $stock->delete();

        return redirect()->route('stocks.index')->with('success', 'Stock deleted successfully.');
    }
}
