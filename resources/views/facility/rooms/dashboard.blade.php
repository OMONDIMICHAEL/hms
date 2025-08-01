<x-app-layout>
    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700 font-medium">
                        {{ session('success') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700 font-medium">
                        {{ session('error') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                {{ __('Room Occupancy Dashboard') }}
            </h2>
            <a href="{{ route('rooms.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                View All Rooms
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Rooms</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $totalRooms }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Available</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $availableRooms }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900 text-yellow-600 dark:text-yellow-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Occupied</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $occupiedRooms }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-red-100 dark:bg-red-900 text-red-600 dark:text-red-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Full Capacity</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $fullRooms }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Room Status Distribution</h3>
                <canvas id="roomChart" height="250"></canvas>
            </div>
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Occupancy Rate by Status</h3>
                @if(!empty($occupancyData['labels']))
                    <canvas id="occupancyChart" height="250"></canvas>
                @else
                    <p class="text-gray-500 dark:text-gray-400">No occupancy data available</p>
                @endif
            </div>
        </div>

        <!-- Room Details Table -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Room Details</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Room #
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Type
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Capacity
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Occupancy
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Patients
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($rooms as $room)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $room->room_number }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Floor: {{ $room->floor ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $room->type ?? 'General' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $room->capacity }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ ($room->current_occupancy / $room->capacity) * 100 }}%"></div>
                                    </div>
                                    <span class="ml-2 text-sm font-medium text-gray-500 dark:text-gray-400">
                                        {{ $room->current_occupancy }}/{{ $room->capacity }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusColors = [
                                        'available' => 'bg-green-100 text-green-800',
                                        'occupied' => 'bg-yellow-100 text-yellow-800',
                                        'maintenance' => 'bg-red-100 text-red-800',
                                        'reserved' => 'bg-blue-100 text-blue-800'
                                    ];
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[strtolower($room->status)] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($room->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @forelse($room->assignments as $assign)
                                    <div class="text-sm text-gray-900 dark:text-white">
                                        {{ $assign->patient->first_name }} {{ $assign->patient->last_name }}
                                        @if(!$assign->discharged_at)
                                            <span class="text-xs text-green-600 dark:text-green-400">(Active)</span>
                                        @else
                                            <span class="text-xs text-gray-500 dark:text-gray-400">(Discharged)</span>
                                        @endif
                                    </div>
                                @empty
                                    <span class="text-sm text-gray-500 dark:text-gray-400">No patients</span>
                                @endforelse
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                @foreach($room->assignments as $assign)
                                    @if(!$assign->discharged_at)
                                        <form action="{{ route('assignments.discharge', $assign->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-500 text-xs"
                                                onclick="return confirm('Are you sure you want to discharge this patient?')">
                                                Discharge
                                            </button>
                                        </form>
                                    @endif <br>
                                @endforeach
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $rooms->links() }}
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Room Status Chart
        const roomCtx = document.getElementById('roomChart').getContext('2d');
        new Chart(roomCtx, {
            type: 'doughnut',
            data: {
                labels: @json($chartData['labels']),
                datasets: [{
                    data: @json($chartData['data']),
                    backgroundColor: [
                        '#4ade80', // Available
                        '#facc15', // Occupied
                        '#f87171', // Full
                        '#60a5fa'  // Maintenance
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });

        // Occupancy Rate Chart
        const occupancyChartEl = document.getElementById('occupancyChart');
        if (occupancyChartEl) {
            const occupancyCtx = occupancyChartEl.getContext('2d');
            new Chart(occupancyCtx, {
                type: 'bar',
                data: {
                    labels: @json($occupancyData['labels'] ?? []),
                    datasets: [{
                        label: 'Occupancy Rate (%)',
                        data: @json($occupancyData['data'] ?? []),
                        backgroundColor: '#3b82f6',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            ticks: {
                                callback: function(value) {
                                    return value + '%';
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.raw + '% occupancy';
                                }
                            }
                        }
                    }
                }
            });
        }
    </script>
</x-app-layout>