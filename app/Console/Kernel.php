<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $tomorrow = now()->addDay()->toDateString();
            $appointments = \App\Models\Appointment::with('patient')
                ->whereDate('appointment_date', $tomorrow)
                ->get();

            foreach ($appointments as $appointment) {
                $appointment->patient->notify(new \App\Notifications\AppointmentReminder($appointment));
            }
        })->daily();
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
