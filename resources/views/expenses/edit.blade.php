<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Expense') }}
            </h2>
            <a href="{{ route('expenses.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                <i class="fas fa-arrow-left mr-1"></i> Back to Expenses
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('expenses.update', $expense) }}">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <!-- Expense Type -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Expense Type <span class="text-red-500">*</span>
                                </label>
                                <select name="expense_type" required
                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                    <option value="">-- Select Type --</option>
                                    @foreach(\App\Models\HospitalExpense::EXPENSE_TYPES as $type)
                                        <option value="{{ $type }}" {{ old('expense_type', $expense->expense_type) == $type ? 'selected' : '' }}>
                                            {{ $type }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('expense_type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Description
                                </label>
                                <textarea name="description" rows="3"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    placeholder="Optional description">{{ old('description', $expense->description) }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Amount -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Amount (KSh) <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">KES</span>
                                    </div>
                                    <input type="number" step="0.01" name="amount" required 
                                        value="{{ old('amount', $expense->amount) }}"
                                        class="block w-full pl-12 pr-12 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                        placeholder="0.00">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">.00</span>
                                    </div>
                                </div>
                                @error('amount')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Expense Date -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Expense Date <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="expense_date" required value="{{ old('expense_date', $expense->expense_date ? \Carbon\Carbon::parse($expense->expense_date)->format('Y-m-d') : now()->format('Y-m-d')) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @error('expense_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Form Actions -->
                            <div class="flex justify-end space-x-3 pt-4">
                                <a href="{{ route('expenses.index') }}" 
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Cancel
                                </a>
                                <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <i class="fas fa-save mr-2"></i> Update Expense
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>