<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">Invoice #{{ $invoice->id }}</h2>
    </x-slot>
    <div class="max-w-4xl mx-auto p-4">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <!-- Header Section -->
            <div class="bg-blue-700 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Invoice Details
                    </h2>
                    <div class="bg-white text-blue-700 px-3 py-1 rounded-full text-sm font-bold">
                        #{{ $invoice->id }}
                    </div>
                </div>
            </div>

            <!-- Patient Information -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-start space-x-4">
                    <div class="bg-blue-100 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">{{ $invoice->medicalRecord->patient->name }}</h3>
                        <p class="text-sm text-gray-500">Medical Record #{{ $invoice->medicalRecord->id }}</p>
                    </div>
                </div>
            </div>

            <!-- Diagnosis -->
            <div class="px-6 py-4 border-b border-gray-200">
                <h4 class="text-sm font-medium text-gray-500 mb-1">Diagnosis</h4>
                <p class="text-gray-800">{{ $invoice->medicalRecord->diagnosis }}</p>
            </div>

            <!-- Financial Summary -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 px-6 py-4 border-b border-gray-200">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h4 class="text-sm font-medium text-gray-500 mb-1">Invoice Amount</h4>
                    <p class="text-2xl font-bold text-blue-700">KSh {{ number_format($invoice->amount, 2) }}</p>
                </div>
                <div class="bg-green-50 p-4 rounded-lg">
                    <h4 class="text-sm font-medium text-gray-500 mb-1">Total Paid</h4>
                    <p class="text-2xl font-bold text-green-700">KSh {{ number_format($totalPaid, 2) }}</p>
                </div>
                <div class="{{ $balance > 0 ? 'bg-red-50' : 'bg-gray-50' }} p-4 rounded-lg">
                    <h4 class="text-sm font-medium text-gray-500 mb-1">Balance</h4>
                    <p class="text-2xl font-bold {{ $balance > 0 ? 'text-red-700' : 'text-gray-700' }}">KSh {{ number_format($balance, 2) }}</p>
                </div>
            </div>

            <!-- Status Badge -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h4 class="text-sm font-medium text-gray-500">Payment Status</h4>
                    @if($invoice->status === 'paid')
                        <span class="px-3 py-1 rounded-full text-sm font-bold bg-green-100 text-green-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Paid
                        </span>
                    @elseif($invoice->status === 'partial')
                        <span class="px-3 py-1 rounded-full text-sm font-bold bg-yellow-100 text-yellow-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd" />
                            </svg>
                            Partially Paid
                        </span>
                    @else
                        <span class="px-3 py-1 rounded-full text-sm font-bold bg-red-100 text-red-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                            Unpaid
                        </span>
                    @endif
                </div>
            </div>

            <!-- Payment History -->
            <div class="px-6 py-4">
                <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Payment History
                </h4>

                @forelse ($invoice->payments as $payment)
                    <div class="border-l-4 border-blue-500 pl-4 mb-4 last:mb-0">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-medium text-gray-900">{{ $payment->paid_at->format('d M Y, h:i A') }}</p>
                                <p class="text-sm text-gray-500">via {{ ucfirst($payment->payment_method) }}</p>
                            </div>
                            <div class="text-lg font-bold text-blue-700">KSh {{ number_format($payment->amount_paid, 2) }}</div>
                        </div>
                        <div class="mt-2">
                            <a href="{{ route('payments.receipt', $payment->id) }}" target="_blank" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Download Receipt
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="bg-gray-50 p-4 rounded-lg text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="mt-2 text-gray-500">No payments recorded yet</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
