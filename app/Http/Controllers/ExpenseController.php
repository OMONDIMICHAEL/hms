<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HospitalExpense;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\HospitalExpensesExport;
// use PDF;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\{DB, Cache}; // for expense charts

class ExpenseController extends Controller
{
    // public function index(Request $request)
    // {
    //     $query = HospitalExpense::query();

    //     if ($request->filled('start_date') && $request->filled('end_date')) {
    //         $query->whereBetween('expense_date', [
    //             Carbon::parse($request->start_date)->startOfDay(),
    //             Carbon::parse($request->end_date)->endOfDay()
    //         ]);
    //     }

    //     if ($request->filled('expense_type')) {
    //         $query->where('expense_type', $request->expense_type);
    //     }

    //     $expenses = $query->orderBy('expense_date', 'desc')->paginate(20);
    //     $totalAmount = $query->sum('amount');

    //     return view('expenses.index', compact('expenses', 'totalAmount'));
    // }
    public function index(Request $request)
    {
        $query = HospitalExpense::query();

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('expense_date', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay()
            ]);
        }

        // if ($request->filled('expense_type')) {
        //     $query->where('expense_type', $request->expense_type);
        // }
        if ($request->expense_type) {
            $query->where('expense_type', $request->expense_type);
        }

        $expenses = $query->orderBy('expense_date', 'desc')->paginate(10);

        // $expenseTypes = HospitalExpense::select('expense_type')
        //     ->distinct()
        //     ->orderBy('expense_type')
        //     ->pluck('expense_type');
        $expenseTypes = HospitalExpense::EXPENSE_TYPES;

        $totalAmount = $expenses->sum('amount');

        return view('expenses.index', compact('expenses', 'totalAmount', 'expenseTypes'));
    }
    public function create()
    {
        // Calculate this month's expenses
        $thisMonth = HospitalExpense::whereMonth('expense_date', Carbon::now()->month)
            ->whereYear('expense_date', Carbon::now()->year)
            ->sum('amount');
        
        // Calculate last month's expenses
        $lastMonth = HospitalExpense::whereMonth('expense_date', Carbon::now()->subMonth()->month)
            ->whereYear('expense_date', Carbon::now()->subMonth()->year)
            ->sum('amount');
        
        // Calculate quarterly average (last 3 months)
        $quarterlyAverage = HospitalExpense::whereBetween('expense_date', [
                Carbon::now()->subMonths(3)->startOfMonth(),
                Carbon::now()->endOfMonth()
            ])
            ->avg('amount');
        
        return view('expenses.create', [
            'thisMonth' => $thisMonth,
            'lastMonth' => $lastMonth,
            'quarterlyAverage' => $quarterlyAverage
        ]);
    }

    // i commented the above to use this below because it resource intensive so caching queries can benefit
    // public function create()
    // {
    //     $stats = Cache::remember('expense_stats', now()->addHours(6), function() {
    //         return [
    //             'thisMonth' => HospitalExpense::whereMonth('expense_date', Carbon::now()->month)
    //                 ->whereYear('expense_date', Carbon::now()->year)
    //                 ->sum('amount'),
    //             'lastMonth' => HospitalExpense::whereMonth('expense_date', Carbon::now()->subMonth()->month)
    //                 ->whereYear('expense_date', Carbon::now()->subMonth()->year)
    //                 ->sum('amount'),
    //             'quarterlyAverage' => HospitalExpense::whereBetween('expense_date', [
    //                     Carbon::now()->subMonths(3)->startOfMonth(),
    //                     Carbon::now()->endOfMonth()
    //                 ])
    //                 ->avg('amount')
    //         ];
    //     });
        
    //     return view('expenses.create', $stats);
    // }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'expense_type' => ['required', Rule::in(HospitalExpense::EXPENSE_TYPES)],
            'description' => 'nullable|string',
            'amount' => 'required|numeric',
            'expense_date' => 'required|date',
        ]);

        HospitalExpense::create($validated);

        return redirect()->back()->with('success', 'Expense recorded successfully.');
    }
    // public function exportExcel(Request $request)
    // {
    //     return Excel::download(new HospitalExpensesExport($request), 'expenses.xlsx');
    // }
    public function export(Request $request)
    {
        $filters = $request->only(['start_date', 'end_date', 'expense_type']);

        return Excel::download(new HospitalExpensesExport($filters), 'hospital_expenses.xlsx');
    }
    public function exportPDF(Request $request)
    {
        $query = HospitalExpense::query();

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('expense_date', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay()
            ]);
        }

        if ($request->filled('expense_type')) {
            $query->where('expense_type', $request->expense_type);
        }

        $expenses = $query->orderBy('expense_date', 'desc')->get();
        $totalAmount = $query->sum('amount');

        $pdf = PDF::loadView('exports.report_pdf', compact('expenses', 'totalAmount'));
        return $pdf->download('expenses_report.pdf');
    }
    public function edit(HospitalExpense $expense)
    {
        return view('expenses.edit', compact('expense'));
    }

    public function update(Request $request, HospitalExpense $expense)
    {
        $request->validate([
            'expense_type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
        ]);

        $expense->update($request->all());
        return redirect()->route('expenses.index')->with('success', 'Expense updated successfully.');
    }

    public function destroy(HospitalExpense $expense)
    {
        $expense->delete();
        return redirect()->route('expenses.index')->with('success', 'Expense deleted successfully.');
    }
    public function chartData()
    {
        $monthlyData = HospitalExpense::select(
            DB::raw('DATE_FORMAT(expense_date, "%Y-%m") as month'),
            DB::raw('SUM(amount) as total')
        )
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        return response()->json($monthlyData);
    }
    public function monthlyBreakdown()
    {
        $breakdown = HospitalExpense::select(
            DB::raw('DATE_FORMAT(expense_date, "%Y-%m") as month'),
            DB::raw('expense_type'),
            DB::raw('SUM(amount) as total')
        )
        ->groupBy('month', 'expense_type')
        ->orderBy('month')
        ->get()
        ->groupBy('month');

        return view('expenses.breakdown', compact('breakdown'));
    }
    // public function exportPdf(Request $request)
    // {
    //     $query = Expense::query();

    //     if ($request->start_date && $request->end_date) {
    //         $query->whereBetween('expense_date', [$request->start_date, $request->end_date]);
    //     }

    //     if ($request->expense_type) {
    //         $query->where('expense_type', $request->expense_type);
    //     }

    //     $expenses = $query->orderBy('expense_date', 'desc')->get();
    //     $totalAmount = $expenses->sum('amount');

    //     $pdf = Pdf::loadView('admin.expenses.report_pdf', [
    //         'expenses' => $expenses,
    //         'totalAmount' => $totalAmount,
    //     ])->setPaper('a4', 'portrait');

    //     return $pdf->download('hospital_expense_report.pdf');
    // }
    // public function index()
    // {
    //     $expenses = HospitalExpense::orderBy('expense_date', 'desc')->paginate(20);
    //     return view('expenses.index', compact('expenses'));
    // }
}
