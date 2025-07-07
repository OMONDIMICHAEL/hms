<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Make Payment.') }}
        </h2>
    </x-slot>
    <div class="max-w-2xl mx-auto px-4 py-8">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <!-- Header Section -->
            <div class="bg-blue-700 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Make Payment
                    </h2>
                    <div class="bg-blue-600 text-white px-3 py-1 rounded-full text-sm font-medium">
                        Invoice #{{ $invoice->id }}
                    </div>
                </div>
            </div>

            <!-- Patient Info -->
            <div class="px-6 py-4 border-b border-gray-200">
                <h4 class="text-lg font-semibold text-gray-800 mb-1">Patient Information</h4>
                <div class="flex items-center">
                    <div class="bg-blue-100 p-3 rounded-full mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">{{ $invoice->medicalRecord->patient->first_name }} {{ $invoice->medicalRecord->patient->last_name }}</p>
                        <p class="text-sm text-gray-500">Medical Record #{{ $invoice->medicalRecord->id }}</p>
                    </div>
                </div>
            </div>

            <!-- Payment Form -->
            <form action="{{ route('payments.store') }}" method="POST" class="px-6 py-4 space-y-6">
                @csrf
                <input type="hidden" name="patient_invoice_id" value="{{ $invoice->id }}">

                <!-- Invoice Amount -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex justify-between items-center">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Invoice Amount</label>
                            <p class="text-2xl font-bold text-gray-900">KSh {{ number_format($invoice->amount, 2) }}</p>
                        </div>
                        <div class="bg-green-100 px-3 py-1 rounded-full text-green-800 text-sm font-medium">
                            Billed: {{ $invoice->billed_at->format('M d, Y') }}
                        </div>
                    </div>
                </div>

                <!-- Amount to Pay -->
                <div>
                    <label for="amount_paid" class="block text-sm font-medium text-gray-700 mb-1">Amount to Pay <span class="text-red-500">*</span></label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500">KSh</span>
                        </div>
                        <input type="number" step="0.01" name="amount_paid" required
                            class="block w-full pl-14 pr-12 py-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                            placeholder="0.00"
                            max="{{ $invoice->amount }}"
                            oninput="this.value = Math.min(parseFloat(this.value), parseFloat(this.max))">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <span class="text-gray-500">KES</span>
                        </div>
                    </div>
                    <p class="mt-1 text-sm text-gray-500">Maximum payable: KSh {{ number_format($invoice->amount, 2) }}</p>
                </div>

                <!-- Payment Method -->
                <div>
                    <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-1">Payment Method <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <label class="flex items-center space-x-3 p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="payment_method" value="Cash" class="h-4 w-4 text-blue-600 focus:ring-blue-500" checked>
                            <div>
                                <span class="block text-sm font-medium text-gray-700">Cash</span>
                                <span class="block text-xs text-gray-500">In-person payment</span>
                            </div>
                        </label>
                        <label class="flex items-center space-x-3 p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="payment_method" value="MPESA" class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                            <div>
                                <span class="block text-sm font-medium text-gray-700">MPESA</span>
                                <span class="block text-xs text-gray-500">Mobile money</span>
                            </div>
                        </label>
                        <label class="flex items-center space-x-3 p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="payment_method" value="Card" class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                            <div>
                                <span class="block text-sm font-medium text-gray-700">Card</span>
                                <span class="block text-xs text-gray-500">Credit/Debit card</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end pt-4">
                    <button type="submit"
                        class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Process Payment
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
