<?php

namespace App\Http\Controllers;
use App\Models\Appointment;
use Illuminate\Http\Request;

class DashboardCalenderController extends Controller
{
    public function dashboard()
    {
        $appointments = Appointment::with('patient')->get();
        return view('appointments.dashboard_calender', compact('appointments'));
    }
}
