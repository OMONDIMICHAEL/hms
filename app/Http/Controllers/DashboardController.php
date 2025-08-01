<?php

namespace App\Http\Controllers;

use App\Models\{Patient,Appointment, HospitalExpense, Staff, Department};
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; // for some of the relationship tables
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {

        $now = Carbon::now();
        $currentMonthStart = $now->copy()->startOfMonth();
        $currentMonthEnd = $now->copy()->endOfMonth();
        // get last month's dates
        $lastMonthStart = $now->copy()->subMonthNoOverflow()->startOfMonth();
        $lastMonthEnd = $now->copy()->subMonthNoOverflow()->endOfMonth();
        $totalPatients = Patient::count();
        // Patients this month
        $currentMonthPatients = Patient::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)->count();
       // Patients last month
        $lastMonthPatients = Patient::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)->count();
        // Get today's appointments
        $todayAppointments = Appointment::with('patient')->whereDate('appointment_date', Carbon::today())->orderBy('appointment_time')->get();
        // Count of today's appointments
        $todayAppointmentsCount = $todayAppointments->count();
        $pendingAppointmentsCount = Appointment::whereDate('appointment_date', Carbon::today())->where('status', 'pending')->count();
        $pendingAppointments = Appointment::where('status', 'pending')->count();
        // Calculate percentages
        $patientPercentage = $this->calculatePercentageChange($currentMonthPatients, $lastMonthPatients);
        // Current month (Expense
        $currentMonthExpenses = HospitalExpense::whereMonth('expense_date', Carbon::now()->month)->whereYear('expense_date', Carbon::now()->year)     ->sum('amount');

        // Last month Expense
        $lastMonthExpenses = HospitalExpense::whereMonth('expense_date', Carbon::now()->subMonth()->month)->whereYear('expense_date', Carbon::now()->subMonth()->year)->sum('amount');
        // Calculate percentage change
        $revenuePercentage = $this->calculatePercentageChange($currentMonthExpenses, $lastMonthExpenses);
        $revenueByCategory = HospitalExpense::selectRaw('expense_type, sum(amount) as total')->whereBetween('expense_date', [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()])->groupBy('expense_type')->get();

        // Expense calculations
        $currentMonthExpenses = $this->getCurrentMonthExpenses();
        $lastMonthExpenses = $this->getLastMonthExpenses();
        $expensePercentage = $this->calculatePercentageChange($currentMonthExpenses, $lastMonthExpenses);
        $expenseByCategory = HospitalExpense::selectRaw('expense_type, sum(amount) as total')->whereBetween('expense_date', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth()
            ])->groupBy('expense_type')->get();

        $activeStaffCount = Staff::where('status', 'active')->count();
        $onLeaveCount = Staff::where('status', 'inactive')->count(); 
        $totalStaffCount = Staff::count();
        $staffByDepartment = Staff::select('departments.name', DB::raw('count(*) as count'))
                ->join('departments', 'staff.department_id', '=', 'departments.id')
                ->where('staff.status', 'active')->groupBy('departments.name')->get();

        $recentHires = Staff::where('status', 'active')
            ->orderBy('hired_date', 'desc')
            ->take(5)->get(['first_name', 'last_name', 'position', 'hired_date']);
    
        return view('dashboard', [
            'totalPatients' => $totalPatients,
            'lastMonthPatients' => $lastMonthPatients,
            'currentMonthPatients' => $currentMonthPatients,
            'patientPercentage' => $patientPercentage,
            'todayAppointments' => $todayAppointments,
            'pendingAppointments' => $pendingAppointments,
            'pendingAppointmentsCount' => $pendingAppointmentsCount,
            'todayAppointmentsCount' => $todayAppointmentsCount,
            'currentMonthExpenses' => $currentMonthExpenses,
            'lastMonthExpenses' => $lastMonthExpenses,
            'expensePercentage' => $expensePercentage,
            'expenseByCategory' => $expenseByCategory,
            'activeStaffCount' => $activeStaffCount,
            'onLeaveCount' => $onLeaveCount,
            'totalStaffCount' => $totalStaffCount,
            'staffByDepartment' => $staffByDepartment,
            'recentHires' => $recentHires,
        ]);
        }
        private function getCurrentMonthExpenses()
        {
            $now = Carbon::now();
            return (float)HospitalExpense::whereBetween('expense_date', [
                $now->copy()->startOfMonth(),
                $now->copy()->endOfMonth()
            ])->sum('amount');
        }

        private function getLastMonthExpenses()
        {
            $lastMonth = Carbon::now()->subMonth();
            return (float)HospitalExpense::whereBetween('expense_date', [
                $lastMonth->copy()->startOfMonth(),
                $lastMonth->copy()->endOfMonth()
            ])->sum('amount');
        }
        private function calculatePercentageChange($current, $previous)
        {
            // Convert to floats if they aren't already
            $current = (float)$current;
            $previous = (float)$previous;
            // Handle cases where data might be null
            if (is_null($current) || is_null($previous)) {
                return ['value' => null, 'isIncrease' => false];
            }
            if ($previous == 0 && $current == 0) {
                return ['value' => 0, 'isIncrease' => true]; // No change
            }
            
            if ($previous == 0) {
                return [
                    'value' => $current > 0 ? 9999 : 0, // Use 9999% as "from zero" indicator
                    'isIncrease' => true
                ];
            }
            
            $change = (($current - $previous) / $previous) * 100;
            
            return [
                // 'value' => abs($change) < 0.1 ? 0 : round($change, 1), // Round near-zero to 0
                'value' => round($change, 1),
                'isIncrease' => $change >= 0
            ];
        }
        // i can add this to show profit Add this to show profit (revenue - expenses):
        // $netProfit = $currentMonthRevenue - $currentMonthExpenses;
        // $lastMonthProfit = $lastMonthRevenue - $lastMonthExpenses;
        // $profitPercentage = $this->calculatePercentageChange($netProfit, $lastMonthProfit);
}

