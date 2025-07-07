<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PatientInvoice;
class InvoiceController extends Controller
{
    public function show($id)
    {
        // Load the invoice, including related medical record, patient, and payments
        $invoice = PatientInvoice::with([
            'medicalRecord.patient',   // Access patient info
            'payments'                // Get all payments made
        ])->findOrFail($id);

        // Calculate total paid
        $totalPaid = $invoice->payments->sum('amount_paid');
        $balance = $invoice->amount - $totalPaid;

        return view('invoices.show', compact('invoice', 'totalPaid', 'balance'));
    }
}

