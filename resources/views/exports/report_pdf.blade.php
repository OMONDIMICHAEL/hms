<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Hospital Expense Report</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f0f0f0; }
        .summary { margin-top: 20px; font-weight: bold; }
    </style>
</head>
<body>
    <h2>Hospital Expense Report</h2>
    <p><strong>Filtered By:</strong>
        @if(request('start_date') && request('end_date'))
            {{ request('start_date') }} to {{ request('end_date') }},
        @endif
        @if(request('expense_type'))
            Type: {{ request('expense_type') }}
        @endif
    </p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Expense Type</th>
                <th>Description</th>
                <th>Amount (KSh)</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($expenses as $index => $expense)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $expense->expense_type }}</td>
                    <td>{{ $expense->description }}</td>
                    <td>{{ number_format($expense->amount, 2) }}</td>
                    <td>{{ $expense->expense_date }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p class="summary">Total Amount: KSh {{ number_format($totalAmount, 2) }}</p>
</body>
</html>
