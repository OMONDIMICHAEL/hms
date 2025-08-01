<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <!-- Patients Card -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border-l-4 border-blue-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 dark:text-gray-400">Total Patients <span class="text-2xl font-bold text-gray-800 dark:text-white">{{ number_format($totalPatients) }}</span></p>
                <p class="text-gray-500 dark:text-gray-400">Total Patients Last Month <span class="text-2xl font-bold text-gray-800 dark:text-white">{{ number_format($lastMonthPatients) }}</span></p>
                <p class="text-gray-500 dark:text-gray-400">Total Patients This Month <span class="text-2xl font-bold text-gray-800 dark:text-white">{{ number_format($currentMonthPatients) }}</span></p>
            </div>
            <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900">
                <svg class="w-6 h-6 text-blue-500 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
        </div>
        @if($lastMonthPatients >= 0) {{-- Show for all cases except when undefined --}}
            <p class="mt-2 text-sm 
                @if($patientPercentage['value'] > 0) text-green-500 dark:text-green-400
                @elseif($patientPercentage['value'] < 0) text-red-500 dark:text-red-400
                @else text-gray-500 dark:text-gray-400 @endif">
                
                @if($patientPercentage['value'] == 0)
                    ↔ 0% change from last month
                @else
                    {{ $patientPercentage['isIncrease'] ? '↑' : '↓' }} 
                    {{ $patientPercentage['value'] }}% from last month
                @endif
            </p>
        @endif
    </div>

    <!-- Appointments Card -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border-l-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 dark:text-gray-400">Today's Appointments</p>
                <h3 class="text-2xl font-bold text-gray-800 dark:text-white">
                    {{ $todayAppointmentsCount }}
                </h3>
            </div>
            <div class="p-3 rounded-full bg-green-100 dark:bg-green-900">
                <svg class="w-6 h-6 text-green-500 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>
        @if($pendingAppointments > 0)
            <p class="mt-2 text-sm text-red-500 dark:text-red-400">
                {{ $pendingAppointments }} pending {{ Str::plural('approval', $pendingAppointments) }}
            </p>
        @endif
    </div>

    <!-- Expense Card -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border-l-4 border-red-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 dark:text-gray-400">Monthly Expenses</p>
                <h3 class="text-2xl font-bold text-gray-800 dark:text-white">
                    ${{ number_format($currentMonthExpenses, 2) }}
                </h3>
            </div>
            <div class="p-3 rounded-full bg-red-100 dark:bg-red-900">
                <svg class="w-6 h-6 text-red-500 dark:text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        
        @if(isset($expensePercentage))
            <p class="mt-2 text-sm {{ $expensePercentage['isIncrease'] ? 'text-red-500 dark:text-red-400' : 'text-green-500 dark:text-green-400' }}">
                @if($expensePercentage['value'] >= 9999)
                    ↑ Massive increase in expenses
                @elseif($expensePercentage['value'] == 0)
                    ↔ No change in expenses
                @else
                    {{ $expensePercentage['isIncrease'] ? '↑' : '↓' }} 
                    {{ number_format($expensePercentage['value'], 1) }}% from last month
                @endif
                <span class="text-xs text-gray-400">
                    ({{ number_format($lastMonthExpenses) }} → {{ number_format($currentMonthExpenses) }})
                </span>
            </p>
        @endif
        
        @if($expenseByCategory->isNotEmpty())
        <div class="mt-4 space-y-2">
            @foreach($expenseByCategory as $category)
            <div class="flex justify-between text-sm">
                <span class="text-gray-600 dark:text-gray-300">{{ ucfirst($category->expense_type) }}</span>
                <span class="font-medium">${{ number_format($category->total, 2) }}</span>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    <!-- Staff Card -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border-l-4 border-yellow-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 dark:text-gray-400">Staff</p>
                <h3 class="text-2xl font-bold text-gray-800 dark:text-white">
                    {{ $totalStaffCount }} total
                </h3>
            </div>
            <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900">
                <svg class="w-6 h-6 text-yellow-500 dark:text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
        </div>
        
        <div class="mt-2 grid grid-cols-2 gap-2 text-sm">
            <div class="text-green-500 dark:text-green-400">
                {{ $activeStaffCount }} active
            </div>
            <div class="text-blue-500 dark:text-blue-400">
                {{ $onLeaveCount }} on leave
            </div>
            <div class="text-gray-500 dark:text-gray-400">
                {{ $totalStaffCount - $activeStaffCount - $onLeaveCount }} inactive
            </div>
        </div>
        
        @if($staffByDepartment->isNotEmpty())
        <div class="mt-4">
            <p class="text-xs font-medium text-gray-400 mb-1">By Department</p>
            <div class="space-y-1">
                @foreach($staffByDepartment as $department)
                <div class="flex justify-between text-xs">
                    <span class="text-gray-500 dark:text-gray-400">{{ $department->name }}</span>
                    <span class="font-medium">{{ $department->count }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
<!-- #################################### -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden mb-8">
    <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Today's Appointments</h3>
        <a href="{{ route('appointments.index') }}" class="text-sm text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">View All</a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Patient</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Time</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Doctor</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($todayAppointments as $appointment)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <img class="h-10 w-10 rounded-full" src="https://i.pravatar.cc/150?img={{ $appointment->patient_id % 70 + 1 }}" alt="">
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $appointment->patient->first_name ?? '' }} {{ $appointment->patient->last_name ?? '' }}
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    ID: #P-{{ str_pad($appointment->patient_id, 4, '0', STR_PAD_LEFT) }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 dark:text-white">
                            {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                        </div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            @if(\Carbon\Carbon::parse($appointment->appointment_date)->isToday())
                                Today
                            @else
                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d') }}
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 dark:text-white">{{ $appointment->doctor_name }}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $appointment->specialization ?? 'General' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $statusClasses = [
                                'confirmed' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                'completed' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200'
                            ];
                        @endphp
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClasses[strtolower($appointment->status)] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                            {{ ucfirst($appointment->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('appointments.edit', $appointment) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">View</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                        No appointments scheduled for today
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- ############################# -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Quick Actions -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Quick Actions</h3>
        <div class="grid grid-cols-2 gap-4">
            <a href="{{ route('patients.create') }}" class="p-4 rounded-lg bg-blue-50 dark:bg-blue-900 hover:bg-blue-100 dark:hover:bg-blue-800 flex flex-col items-center justify-center transition">
                <svg class="w-6 h-6 text-blue-500 dark:text-blue-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
                <span class="text-sm text-center text-gray-700 dark:text-gray-300">New Patient</span>
            </a>
            <a href="{{ route('appointments.create') }}" class="p-4 rounded-lg bg-green-50 dark:bg-green-900 hover:bg-green-100 dark:hover:bg-green-800 flex flex-col items-center justify-center transition">
                <svg class="w-6 h-6 text-green-500 dark:text-green-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span class="text-sm text-center text-gray-700 dark:text-gray-300">New Appointment</span>
            </a>
            <a href="{{ route('medical-records.create') }}" class="p-4 rounded-lg bg-purple-50 dark:bg-purple-900 hover:bg-purple-100 dark:hover:bg-purple-800 flex flex-col items-center justify-center transition">
                <svg class="w-6 h-6 text-purple-500 dark:text-purple-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span class="text-sm text-center text-gray-700 dark:text-gray-300">New EMR</span>
            </a>
            <a href="{{ route('lab-tests.index') }}" class="p-4 rounded-lg bg-yellow-50 dark:bg-yellow-900 hover:bg-yellow-100 dark:hover:bg-yellow-800 flex flex-col items-center justify-center transition">
                <svg class="w-6 h-6 text-yellow-500 dark:text-yellow-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                </svg>
                <span class="text-sm text-center text-gray-700 dark:text-gray-300">Lab Test</span>
            </a>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 col-span-2">
        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Recent Activity</h3>
        <div class="space-y-4">
            <!-- Sample activity item -->
            <div class="flex items-start">
                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center text-blue-500 dark:text-blue-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-800 dark:text-gray-200">
                        <span class="font-medium">Dr. Smith</span> added a new patient record for <span class="font-medium">Jane Doe</span>
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">2 hours ago</p>
                </div>
            </div>
            <!-- More activity items... -->
        </div>
    </div>
</div>
<!-- ################# -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden mb-8">
    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Hospital Calendar</h3>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-7 gap-2 mb-4">
            <div class="text-center font-medium text-gray-500 dark:text-gray-400 text-sm">Sun</div>
            <div class="text-center font-medium text-gray-500 dark:text-gray-400 text-sm">Mon</div>
            <div class="text-center font-medium text-gray-500 dark:text-gray-400 text-sm">Tue</div>
            <div class="text-center font-medium text-gray-500 dark:text-gray-400 text-sm">Wed</div>
            <div class="text-center font-medium text-gray-500 dark:text-gray-400 text-sm">Thu</div>
            <div class="text-center font-medium text-gray-500 dark:text-gray-400 text-sm">Fri</div>
            <div class="text-center font-medium text-gray-500 dark:text-gray-400 text-sm">Sat</div>
        </div>
        <div class="grid grid-cols-7 gap-2">
            <!-- Calendar days would go here -->
            <!-- This is a simplified version - consider using a proper calendar library -->
        </div>
    </div>
</div>
</x-app-layout>
