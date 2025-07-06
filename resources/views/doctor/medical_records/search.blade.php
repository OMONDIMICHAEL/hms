<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Search/filter and Export.') }}
        </h2>
    </x-slot>
    <div class="container mx-auto py-6">
        <h1 class="text-2xl font-bold mb-4">Medical Records</h1>

        <form method="GET" action="{{ route('medical-records.searchIndex') }}" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
            <input type="text" name="search" placeholder="Search patient or diagnosis" value="{{ request('search') }}" class="border px-3 py-2 rounded">
            <input type="date" name="from" value="{{ request('from') }}" class="border px-3 py-2 rounded">
            <input type="date" name="to" value="{{ request('to') }}" class="border px-3 py-2 rounded">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Filter</button>
        </form>

        <div class="mb-4">
            <a href="{{ route('medical-records.export.pdf', request()->query()) }}" class="bg-red-600 text-white px-4 py-2 rounded mr-2">Export PDF</a>
            <a href="{{ route('medical-records.export.excel', request()->query()) }}" class="bg-green-600 text-white px-4 py-2 rounded">Export Excel</a>
        </div>

        <div class="bg-white rounded shadow overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">Patient</th>
                        <th class="px-4 py-2 text-left">Diagnosis</th>
                        <th class="px-4 py-2 text-left">Date</th>
                        <th class="px-4 py-2 text-left">Doctor</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($medicalRecords as $record)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $record->patient->first_name }} {{ $record->patient->last_name }}</td>
                        <td class="px-4 py-2">{{ $record->diagnosis }}</td>
                        <td class="px-4 py-2">{{ $record->recorded_at }}</td>
                        <td class="px-4 py-2">{{ $record->doctor->name }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('medical-records.show', $record->id) }}" class="text-blue-600 underline">View</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-4 py-2 text-center">No records found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        
    </div>
</x-app-layout>