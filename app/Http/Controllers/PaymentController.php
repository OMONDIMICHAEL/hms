<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\PatientInvoice;
use App\Models\PatientPayment;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'patient_invoice_id' => 'required|exists:patient_invoices,id',
            'amount_paid' => 'required|numeric|min:0',
            'payment_method' => 'required|string',
        ]);

        $invoice = PatientInvoice::findOrFail($request->patient_invoice_id);

        PatientPayment::create([
            'patient_invoice_id' => $invoice->id,
            'amount_paid' => $request->amount_paid,
            'payment_method' => $request->payment_method,
            'paid_at' => now(),
        ]);

        // Update invoice status
        $totalPaid = $invoice->payments()->sum('amount_paid');

        if ($totalPaid >= $invoice->amount) {
            $invoice->update(['status' => 'paid']);
        } elseif ($totalPaid > 0) {
            $invoice->update(['status' => 'partial']);
        }

        return redirect()->route('invoices.show', $invoice->id)
            ->with('success', 'Payment recorded successfully.');
    }
    public function create($invoice)
    {
        $invoice = PatientInvoice::with('medicalRecord.patient')->findOrFail($invoice);
        
        return view('payments.create', compact('invoice'));
    }
    public function generateReceipt($id)
    {
        $payment = PatientPayment::with('invoice.medicalRecord.patient')->findOrFail($id);

        $pdf = Pdf::loadView('payments.receipt_pdf', compact('payment'));
        $filename = 'Receipt_' . $payment->id . '.pdf';

        return $pdf->download($filename);
    }
}
