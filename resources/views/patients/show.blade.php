<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Patients') }}
        </h2>
    </x-slot>
    <div class="max-w-4xl mx-auto p-6 bg-white shadow rounded">
    <h2 class="mb-4">Patient Details</h2>

    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
        <table class="min-w-full divide-y divide-gray-200">
            <tbody class="bg-white divide-y divide-gray-200">
                <tr>
                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-700 bg-gray-50">Name</td>
                    <td class="px-4 py-3 whitespace-normal text-sm text-gray-900">{{ $patient->first_name }} {{ $patient->last_name }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-700 bg-gray-50">Gender</td>
                    <td class="px-4 py-3 whitespace-normal text-sm text-gray-900">{{ $patient->gender }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-700 bg-gray-50">Date of Birth</td>
                    <td class="px-4 py-3 whitespace-normal text-sm text-gray-900">{{ $patient->date_of_birth }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-700 bg-gray-50">Phone</td>
                    <td class="px-4 py-3 whitespace-normal text-sm text-gray-900">{{ $patient->phone }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-700 bg-gray-50">Email</td>
                    <td class="px-4 py-3 whitespace-normal text-sm text-gray-900">{{ $patient->email }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-700 bg-gray-50">Address</td>
                    <td class="px-4 py-3 whitespace-normal text-sm text-gray-900">{{ $patient->address }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-700 bg-gray-50">Medical History</td>
                    <td class="px-4 py-3 whitespace-normal text-sm text-gray-900">{{ $patient->medical_history }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-700 bg-gray-50">Insurance</td>
                    <td class="px-4 py-3 whitespace-normal text-sm text-gray-900">
                        {{ $patient->insurance_provider }} 
                        <span class="text-gray-500">|</span> 
                        <span class="font-mono">{{ $patient->insurance_number }}</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <a href="{{ route('patients.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 mt-3">
        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
        </svg>
        Back to Patients List
    </a>
</div>
</x-app-layout>

