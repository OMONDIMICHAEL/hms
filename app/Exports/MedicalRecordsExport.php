<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class MedicalRecordsExport implements FromView
{
    protected $records;

    public function __construct($records)
    {
        $this->records = $records;
    }

    public function view(): View
    {
        return view('exports.medical-records-excel', [
            'records' => $this->records
        ]);
    }
}
