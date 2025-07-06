<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Suppliers') }}
        </h2>
    </x-slot>
    <div class="max-w-6xl mx-auto p-4">
        <h1 class="text-xl font-bold mb-4">Inventory Suppliers</h1>
        <a href="{{ route('suppliers.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Add Supplier</a>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded shadow">
                <thead class="hidden sm:table-header-group">
                    <tr>
                        <th class="border px-4 py-2">Name</th>
                        <th class="border px-4 py-2">Contact</th>
                        <th class="border px-4 py-2">Email</th>
                        <th class="border px-4 py-2">Phone</th>
                        <th class="border px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($suppliers as $supplier)
                    <tr class="flex flex-col sm:table-row mb-4 sm:mb-0 border-b">
                        <td class="sm:border px-4 py-2"><strong>Name:</strong> {{ $supplier->name }}</td>
                        <td class="sm:border px-4 py-2"><strong>Contact:</strong> {{ $supplier->contact_person }}</td>
                        <td class="sm:border px-4 py-2"><strong>Email:</strong> {{ $supplier->email }}</td>
                        <td class="sm:border px-4 py-2"><strong>Phone:</strong> {{ $supplier->phone }}</td>
                        <td class="sm:border px-4 py-2">
                            <a href="{{ route('suppliers.edit', $supplier) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 ml-2 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
