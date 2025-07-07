<?php 
namespace App\Exports;

use App\Models\HospitalExpense;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HospitalExpensesExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = HospitalExpense::query();

        if (!empty($this->filters['start_date']) && !empty($this->filters['end_date'])) {
            $query->whereBetween('expense_date', [$this->filters['start_date'], $this->filters['end_date']]);
        }

        if (!empty($this->filters['expense_type'])) {
            $query->where('expense_type', $this->filters['expense_type']);
        }

        return $query->select('expense_type', 'description', 'amount', 'expense_date')->get();
    }

    public function headings(): array
    {
        return ['Expense Type', 'Description', 'Amount (KSh)', 'Date'];
    }
}
