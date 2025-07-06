<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
        ]);

        InventorySupplier::create($request->all());
        return redirect()->route('suppliers.index')->with('success', 'Supplier added');
    }
}
