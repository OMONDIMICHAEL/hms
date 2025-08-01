<x-app-layout>
    @if(session('debug'))
    <div class="bg-yellow-100 p-4 mb-4 rounded">
        <pre>{{ print_r(session('debug'), true) }}</pre>
    </div>
@endif

@if(session('updated_record'))
    <div class="bg-green-100 p-4 mb-4 rounded">
        <h4>Updated Record:</h4>
        <pre>{{ print_r(session('updated_record')->toArray(), true) }}</pre>
    </div>
@endif
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Medical Record') }}
        </h2>
    </x-slot>
    <div class="container mx-auto py-8 max-w-2xl px-4 sm:px-6">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <!-- Form Header -->
            <div class="bg-blue-700 px-6 py-4">
                <h1 class="text-2xl font-bold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Medical Record
                </h1>
            </div>

            <form action="{{ route('medical-records.update', $medicalRecord->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Patient Selection -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Patient <span class="text-red-500">*</span></label>
                    <select name="patient_id" required class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ $medicalRecord->patient_id == $patient->id ? 'selected' : '' }}>
                                {{ $patient->first_name }} {{ $patient->last_name }} (ID: {{ $patient->id }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Diagnosis -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Diagnosis <span class="text-red-500">*</span></label>
                    <input type="text" name="diagnosis" value="{{ $medicalRecord->diagnosis }}" required 
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>

                <!-- Prescription -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Prescription</label>
                    <textarea name="prescription" rows="3" 
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ $medicalRecord->prescription }}</textarea>
                </div>

                <!-- Notes -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Clinical Notes</label>
                    <textarea name="notes" rows="3" 
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ $medicalRecord->notes }}</textarea>
                </div>

                <!-- Attachment -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Medical Attachment</label>
                    @if ($medicalRecord->attachment)
                        <div class="flex items-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                            <a href="{{ Storage::url($medicalRecord->attachment) }}" class="text-blue-600 hover:text-blue-800" target="_blank">Current Attachment</a>
                        </div>
                    @endif
                    <div class="flex items-center justify-center w-full">
                        <label class="flex flex-col w-full border-2 border-dashed rounded-lg cursor-pointer hover:bg-gray-50">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6 px-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <p class="text-sm text-gray-500 mt-2">Click to upload or drag and drop</p>
                                <p class="text-xs text-gray-500 mt-1">PDF, JPG, PNG, DOC (Max: 2MB)</p>
                            </div>
                            <input type="file" name="attachment" class="hidden">
                        </label>
                    </div>
                </div>

                <!-- Record Date -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Record Date <span class="text-red-500">*</span></label>
                    <input type="date" name="recorded_at" value="{{ $medicalRecord->recorded_at }}" required 
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>

                <!-- Doctor Comments -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Doctor's Comments</label>
                    <textarea name="comments" rows="3" 
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ $medicalRecord->comments ?? '' }}</textarea>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-between pt-4">
                    <a href="{{ route('medical-records.show', $medicalRecord->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Update Medical Record
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>