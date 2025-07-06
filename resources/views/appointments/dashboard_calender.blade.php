<x-app-layout>
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Doctor Calender Dashboard') }}
        </h2>
    </x-slot>
    <div class="container mx-auto px-4 py-6">
        <!-- Calendar Section -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-700">Appointment Calendar</h2>
                <div class="flex space-x-2">
                    <button id="today-btn" class="px-3 py-1 text-sm bg-blue-50 text-blue-600 rounded hover:bg-blue-100">Today</button>
                    <button id="add-appointment-btn" class="px-3 py-1 text-sm bg-green-50 text-green-600 rounded hover:bg-green-100">+ New Appointment</button>
                </div>
            </div>
            <div id="calendar" style="min-height: 600px;"></div>
        </div>

        <!-- Upcoming Appointments Table -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Upcoming Appointments</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($appointments as $appointment)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}
                                    <span class="text-gray-500">at</span>
                                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusColors = [
                                        'scheduled' => 'bg-blue-100 text-blue-800',
                                        'confirmed' => 'bg-green-100 text-green-800',
                                        'completed' => 'bg-purple-100 text-purple-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                        'no-show' => 'bg-yellow-100 text-yellow-800'
                                    ];
                                    $color = $statusColors[strtolower($appointment->status)] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $color }}">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('appointments.show', $appointment) }}" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                <a href="{{ route('appointments.edit', $appointment) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- FullCalendar Resources -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: [
                @foreach($appointments as $appointment)
                {
                    title: '{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}',
                    start: '{{ $appointment->appointment_date }}T{{ $appointment->appointment_time }}',
                    @php
                        $color = '#3B82F6'; // default blue
                        switch(strtolower($appointment->status)) {
                            case 'completed': $color = '#8B5CF6'; break;
                            case 'confirmed': $color = '#10B981'; break;
                            case 'cancelled': $color = '#EF4444'; break;
                            case 'no-show': $color = '#F59E0B'; break;
                        }
                    @endphp
                    color: '{{ $color }}',
                    extendedProps: {
                        status: '{{ $appointment->status }}',
                        patientId: '{{ $appointment->patient->id }}'
                    }
                },
                @endforeach
            ],
            eventClick: function(info) {
                window.location.href = `/appointments/${info.event.extendedProps.patientId}`;
            },
            eventRender: function(info) {
                // Custom event rendering
                const eventEl = info.el;
                eventEl.innerHTML = `
                    <div class="fc-event-main-frame">
                        <div class="fc-event-title-container">
                            <div class="fc-event-title">${info.event.title}</div>
                        </div>
                        <div class="fc-event-time">${info.timeText}</div>
                    </div>
                `;
            },
            height: 'auto',
            nowIndicator: true,
            selectable: true,
            select: function(arg) {
                window.location.href = "{{ route('appointments.create') }}?date=" + arg.startStr;
            }
        });

        calendar.render();

        // Button handlers
        document.getElementById('today-btn').addEventListener('click', function() {
            calendar.today();
        });

        document.getElementById('add-appointment-btn').addEventListener('click', function() {
            window.location.href = "{{ route('appointments.create') }}";
        });
    });
    </script>

    <style>
    /* Calendar Styling */
    .fc {
        font-family: 'Inter', sans-serif;
    }

    .fc-event {
        border: none;
        border-left: 4px solid;
        border-radius: 4px;
        padding: 4px;
        font-size: 0.85rem;
        box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        margin: 2px;
    }

    .fc-daygrid-event-dot {
        display: none;
    }

    .fc-toolbar-title {
        font-weight: 600;
        color: #374151;
    }

    .fc-button {
        background-color: #fff;
        border: 1px solid #D1D5DB;
        color: #374151;
        transition: all 0.2s;
        padding: 6px 12px;
        font-size: 0.875rem;
    }

    .fc-button:hover {
        background-color: #F3F4F6;
    }

    .fc-button-active {
        background-color: #3B82F6;
        color: white;
        border-color: #3B82F6;
    }

    /* Status-specific event styles */
    .fc-event[data-status="cancelled"] {
        opacity: 0.7;
        text-decoration: line-through;
    }

    .fc-event[data-status="no-show"] {
        border-left-color: #F59E0B;
    }

    .fc-event[data-status="completed"] {
        border-left-color: #8B5CF6;
    }

    .fc-event[data-status="confirmed"] {
        border-left-color: #10B981;
    }

    /* Table styling */
    #calendar a {
        text-decoration: none;
    }
    </style>
</x-app-layout>
