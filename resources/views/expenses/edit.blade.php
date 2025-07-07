<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Expense.') }}
        </h2>
    </x-slot>
    <div>
        <form method="POST" action="{{ route('expenses.update', $expense) }}">
            @csrf
            @method('PUT')
            <!-- Reuse your create form fields here, just populate with $expense -->
            <!-- Expense Type -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Expense Type <span class="text-red-500">*</span></label>
                <select name="expense_type" required class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">-- Select Type --</option>
                    @foreach(\App\Models\HospitalExpense::EXPENSE_TYPES as $type)
                        <option value="{{ $type }}" {{ old('expense_type') == $type ? 'selected' : '' }}>
                            {{ $type }}
                        </option>
                    @endforeach
                </select>
                @error('expense_type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" rows="3"
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    placeholder="{{ old('description', $expense->description ?? '') }}"></textarea>
            </div>

            <!-- Amount -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Amount (KSh) <span class="text-red-500">*</span></label>
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">KES</span>
                    </div>
                    <input type="number" step="0.01" name="amount" required value="{{ old('amount', $expense->amount ?? '') }}"
                        class="block w-full pl-12 pr-12 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        placeholder="0.00">
                </div>
                @error('amount')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Expense Date -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Expense Date <span class="text-red-500">*</span></label>
                <input type="date" name="expense_date" required
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    value="{{ old('expense_date', now()->format('Y-m-d')) }}">
                @error('expense_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </form>
    </div>
</x-app-layout>