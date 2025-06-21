<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Patients') }}
        </h2>
    </x-slot>
    <div class="max-w-4xl mx-auto p-6 bg-white shadow rounded">
        <h2 class="text-xl font-bold mb-4">Add New Patient</h2>

        <form action="{{ route('patients.store') }}" method="POST">
            @csrf

            @include('patients.form')

            <div class="mt-4 flex gap-2">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Save Patient</button>
                <a href="{{ route('patients.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</a>
            </div>
        </form>
    </div>
</x-app-layout>
