<x-app-layout>
    <x-slot name="header">
        <header></header>
    </x-slot>
<div class="max-w-lg mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Edit Stock</h2>

    <form method="POST" action="{{ route('stocks.update', $stock->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Stock Name</label>
            <input type="text" name="medicine_name" value="{{ old('medicine_name', $stock->medicine_name) }}" class="w-full border border-gray-300 rounded px-3 py-2">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Quantity</label>
            <input type="number" name="quantity" value="{{ old('quantity', $stock->quantity) }}" class="w-full border border-gray-300 rounded px-3 py-2">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Expiry Date</label>
            <input type="date" name="expiry_date" value="{{ old('expiry_date', $stock->expiry_date) }}" class="w-full border border-gray-300 rounded px-3 py-2">
        </div>

        <div class="flex justify-between">
            <a href="{{ route('stocks.index') }}" class="text-blue-600 hover:underline">Cancel</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
        </div>
    </form>
</div>
</x-app-layout>
