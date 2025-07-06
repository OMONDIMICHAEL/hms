<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Medical Records PDF</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Medical Records Report</h2>
    <table>
        <thead>
            <tr>
                <th>Patient</th>
                <th>Diagnosis</th>
                <th>Date</th>
                <th>Doctor</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($records as $record)
            <tr>
                <td>{{ $record->patient->first_name }} {{ $record->patient->last_name }}</td>
                <td>{{ $record->diagnosis }}</td>
                <td>{{ $record->recorded_at }}</td>
                <td>{{ $record->doctor->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>