<?php

namespace App\Http\Controllers;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardCalenderController extends Controller
{
    public function dashboard()
    {
        $appointments = Appointment::with('patient')->where('doctor_name', Auth::user()->name)->latest()->get();
        return view('appointments.dashboard_calender', compact('appointments'));
    }
}
