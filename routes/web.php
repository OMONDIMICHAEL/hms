<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Row;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DashboardCalenderController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\InsuranceClaimController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MedicineStockController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\DispenseController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(('verified'))->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');
    Route::resource('patients', PatientController::class);
    Route::resource('appointments', AppointmentController::class);
    Route::get('/dashboard_calender', [DashboardCalenderController::class, 'dashboard'])->name('dashboard_calender');
    Route::get('/medical_record', [MedicalRecordController::class, 'index'])->name('medical-records.index');
    Route::get('/create_medical_record', [MedicalRecordController::class, 'create'])->name('medical-records.create');
    Route::get('/search_medical_record', [MedicalRecordController::class, 'search'])->name('medical-records.search');
    Route::get('/searchIndex_medical_record', [MedicalRecordController::class, 'searchIndex'])->name('medical-records.searchIndex');
    Route::post('/store_medical_record', [MedicalRecordController::class, 'store'])->name('medical-records.store');
    Route::get('/show_medical_record/{medicalRecord}', [MedicalRecordController::class, 'show'])->name('medical-records.show');
    Route::get('/edit_medical_/{medicalRecord}/_record', [MedicalRecordController::class, 'edit'])->name('medical-records.edit');
    Route::post('/update_medical_record', [MedicalRecordController::class, 'update'])->name('medical-records.update');
    Route::get('/approve_reject_insurance_claim', [InsuranceClaimController::class, 'index'])->name('insurance-claims.index');
    Route::put('insurance-claims/{claim}/approve', [InsuranceClaimController::class, 'approve'])->name('insurance-claims.approve');
    Route::put('insurance-claims/{claim}/reject', [InsuranceClaimController::class, 'reject'])->name('insurance-claims.reject');
    Route::get('export-pdf', [MedicalRecordController::class, 'exportPdf'])->name('medical-records.export.pdf');
    Route::get('export-excel', [MedicalRecordController::class, 'exportExcel'])->name('medical-records.export.excel');
    Route::put('/medical-records/{medicalRecord}', [MedicalRecordController::class, 'update'])->name('medical-records.update');
    Route::put('/medical-records/{medicalRecord}', [MedicalRecordController::class, 'updateNotes'])->name('medical-records.updateNotes');
    Route::delete('/medical-records/{id}', [MedicalRecordController::class, 'destroy'])->name('medical-records.destroy');


    // can always use this
        // Route::resource('medical-records', MedicalRecordController::class);
        // This will automatically register all standard routes (index, create, store, show, edit, update, destroy) ETC.

});
Route::middleware(['auth'])->group(function () {
    Route::get('/expenses/create', [ExpenseController::class, 'create'])->name('expenses.create');
    Route::post('/expenses/store', [ExpenseController::class, 'store'])->name('expenses.store');
    Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses.index');
    Route::get('/export/pdf', [ExpenseController::class, 'exportPdf'])->name('expenses.export.pdf');
    Route::get('/export/excel', [ExpenseController::class, 'export'])->name('expenses.export');
    Route::get('/expenses/{expense}/edit', [ExpenseController::class, 'edit'])->name('expenses.edit');
    Route::put('/expenses/{expense}', [ExpenseController::class, 'update'])->name('expenses.update');
    Route::delete('/expenses/{expense}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');
    Route::get('/expenses/chart-data', [ExpenseController::class, 'chartData']);
    Route::get('/expenses/monthly-breakdown', [ExpenseController::class, 'monthlyBreakdown'])->name('expenses.breakdown');
});
Route::middleware(['auth'])->group(function () {
    Route::resource('payments', PaymentController::class)->only(['store']);
    Route::get('/payments/create/{invoice}', [PaymentController::class, 'create'])->name('payments.create');
    Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
});
Route::get('/payments/{payment}/receipt', [PaymentController::class, 'generateReceipt'])->name('payments.receipt');
Route::resource('stocks', MedicineStockController::class);
Route::post('/pharmacy/dispense/{record}', [PharmacyController::class, 'dispense'])->name('pharmacy.dispense');
Route::get('/pharmacy/alerts', [PharmacyController::class, 'alerts'])->name('pharmacy.alerts');
Route::get('/{stock}/edit', [MedicineStockController::class, 'edit'])->name('medicine_stocks.edit');
Route::put('/{stock}', [MedicineStockController::class, 'update'])->name('medicine_stocks.update');

Route::middleware(['auth'])->group(function () {
    // Route::post('/dispense', [DispenseController::class, 'dispense'])->name('dispense.medication');
    Route::post('/dispense', [DispenseController::class, 'dispense'])->name('dispense.store');
    Route::get('/stock/alerts', [MedicineStockController::class, 'alerts'])->name('stock.alerts');
    Route::get('/pharmacy/dispense{stockItems}', [DispenseController::class, 'index'])->name('dispense.med');
});

// Route::prefix('expenses')->name('expenses.')->group(function () {
//     Route::get('/', [ExpenseController::class, 'index'])->name('index');
//     Route::post('/store', [ExpenseController::class, 'store'])->name('store');
//     Route::get('/export/pdf', [ExpenseController::class, 'exportPdf'])->name('export.pdf');
//     Route::get('/export/excel', [ExpenseController::class, 'export'])->name('export');
// });
// Route::middleware(['auth', 'role:doctor'])->group(function () {
//     Route::get('/doctor-dashboard', [DoctorController::class, 'index']);
// });



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
