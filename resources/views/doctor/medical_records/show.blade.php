<x-app-layout>
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('View Medical Record') }}
        </h2>
    </x-slot>
    <div class="container mx-auto py-8 max-w-4xl px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <!-- Header Section -->
            <div class="bg-blue-700 px-6 py-4">
                <h1 class="text-2xl font-bold text-white">Medical Record Details</h1>
            </div>

            <!-- Patient Information Card -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="bg-blue-100 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">{{ $medicalRecord->patient->first_name ?? 'Unknown' }} {{ $medicalRecord->patient->last_name ?? '' }}</h2>
                        <p class="text-sm text-gray-500">Patient Record</p>
                    </div>
                </div>
            </div>

            <!-- Medical Details Section -->
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div class="space-y-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Diagnosis</h3>
                        <p class="mt-1 text-sm text-gray-900 bg-gray-50 p-3 rounded-lg">{{ $medicalRecord->diagnosis }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Prescription</h3>
                        <p class="mt-1 text-sm text-gray-900 bg-gray-50 p-3 rounded-lg whitespace-pre-line">{{ $medicalRecord->prescription }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Amount</h3>
                        <p class="mt-1 text-sm text-gray-900 bg-gray-50 p-3 rounded-lg">KES {{ number_format($medicalRecord->amount, 2) }}</p>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Record Date</h3>
                        <p class="mt-1 text-sm text-gray-900 bg-gray-50 p-3 rounded-lg">
                            {{ \Carbon\Carbon::parse($medicalRecord->recorded_at)->format('F j, Y') }}
                        </p>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Notes</h3>
                        <p class="mt-1 text-sm text-gray-900 bg-gray-50 p-3 rounded-lg whitespace-pre-line">{{ $medicalRecord->notes }}</p>
                    </div>

                    @if ($medicalRecord->attachment)
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Attachment</h3>
                        <div class="mt-1">
                            <a href="{{ Storage::url($medicalRecord->attachment) }}" target="_blank" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                                </svg>
                                Download File
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="px-6 py-4 bg-gray-50 flex justify-between items-center">
                <a href="{{ route('medical-records.edit', $medicalRecord->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Record
                </a>
                
                <a href="{{ route('medical-records.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                    Back to all records
                </a>
            </div>

            <!-- Doctor Notes Section -->
            <div class="p-6 border-t border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Doctor's Notes
                </h2>

                @if (Auth::user()->role === 'doctor' && Auth::id() === $medicalRecord->doctor_id)
                    <form action="{{ route('medical-records.updateNotes', $medicalRecord->id) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <textarea name="notes" rows="6" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Enter your professional notes here...">{{ old('notes', $medicalRecord->notes) }}</textarea>

                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Update Notes
                            </button>
                        </div>
                    </form>
                @else
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700 whitespace-pre-line">
                                    {{ $medicalRecord->doctor_notes ?: 'No doctor notes have been added to this record yet.' }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>