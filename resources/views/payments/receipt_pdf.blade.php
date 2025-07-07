<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Payment Receipt</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; padding: 30px; }
        h2 { text-align: center; margin-bottom: 30px; }
        .info { margin-bottom: 20px; }
        .info p { margin: 4px 0; }
        .summary { margin-top: 30px; border-top: 1px solid #ccc; padding-top: 10px; }
        .signature { margin-top: 50px; }
    </style>
</head>
<body>
    <h2>Hospital Payment Receipt</h2>

    <div class="info">
        <p><strong>Receipt No:</strong> #{{ $payment->id }}</p>
        <p><strong>Invoice ID:</strong> #{{ $payment->invoice->id ?? 'N/A' }}</p>
        <p><strong>Patient Name:</strong> {{ $payment->invoice->medicalRecord->patient->name ?? 'N/A' }}</p>
        <p><strong>Amount Paid:</strong> KSh {{ number_format($payment->amount_paid, 2) }}</p>
        <p><strong>Payment Method:</strong> {{ $payment->payment_method }}</p>
        <p><strong>Date Paid:</strong> {{ \Carbon\Carbon::parse($payment->paid_at)->format('d M Y, H:i') }}</p>
    </div>

    <div class="summary">
        <p><strong>Status:</strong> {{ ucfirst($payment->invoice->status) }}</p>
        <p><strong>Total Invoice Amount:</strong> KSh {{ number_format($payment->invoice->amount, 2) }}</p>
    </div>

    <div class="signature">
        <p>_____________________________</p>
        <p><em>Authorized Signature</em></p>
    </div>

    <p style="text-align: center; margin-top: 40px;">Thank you for your payment</p>
</body>
</html>
