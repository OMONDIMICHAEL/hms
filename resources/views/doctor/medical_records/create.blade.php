<x-app-layout>
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- @if(session('error')) --}}
        <!-- <div class="bg-red-100 text-red-700 p-4 rounded mb-4"> -->
            {{-- {{ session('error') }} --}}
        <!-- </div> -->
    {{-- @endif --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Medical Record') }}
        </h2>
    </x-slot>
    <div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8 max-w-2xl">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <!-- Form Header -->
            <div class="bg-blue-700 px-6 py-4">
                <h1 class="text-2xl font-bold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Create New Medical Record
                </h1>
            </div>

            <form action="{{ route('medical-records.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf

                <!-- Patient Selection -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Patient <span class="text-red-500">*</span></label>
                    <select name="patient_id" required class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        <option value="">-- Select Patient --</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                {{ $patient->first_name }} {{ $patient->last_name }} (ID: {{ $patient->id }})
                            </option>
                        @endforeach
                    </select>
                    @error('patient_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Diagnosis -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Diagnosis <span class="text-red-500">*</span></label>
                    <input type="text" name="diagnosis" value="{{ old('diagnosis') }}" required 
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('diagnosis')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Prescription -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Prescription</label>
                    <textarea name="prescription" rows="3" 
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('prescription') }}</textarea>
                </div>

                <!-- Amount -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Amount <span class="text-red-500">*</span></label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">KES</span>
                        </div>
                        <input type="number" name="amount" value="{{ old('amount') }}" required 
                            class="block w-full pl-12 pr-12 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            placeholder="0.00">
                    </div>
                    @error('amount')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Comments -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Comments</label>
                    <textarea name="comments" rows="2" 
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('comments') }}</textarea>
                </div>

                <!-- Notes -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Clinical Notes</label>
                    <textarea name="notes" rows="3" 
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('notes') }}</textarea>
                </div>

                <!-- Attachment -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Medical Attachment</label>
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
                    @error('attachment')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Record Date -->
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Record Date <span class="text-red-500">*</span></label>
                    <input type="date" name="recorded_at" value="{{ old('recorded_at', now()->format('Y-m-d')) }}" required 
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('recorded_at')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="flex justify-between pt-6">
                    <a href="{{ route('medical-records.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Save Medical Record
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>