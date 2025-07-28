<?php

use App\Http\Controllers\{ProfileController,PatientController,AppointmentController,DashboardCalenderController,MedicalRecordController,InsuranceClaimController,ExpenseController,PaymentController,InvoiceController,MedicineStockController,PharmacyController,DispenseController,LabTestController,RoomController,RoomAssignmentController,StaffController,RecruitmentController,DepartmentController};
use Illuminate\Support\Facades\{Route, Storage, Response};
use Maatwebsite\Excel\Row;


Route::get('/', function () { return view('welcome'); });

Route::middleware(['auth','verified'])->group(function () {
    Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');
    Route::get('/dashboard_calender', [DashboardCalenderController::class, 'dashboard'])->name('dashboard_calender');
});

Route::middleware(['auth','verified'])->group(function () {
    Route::resource('appointments', AppointmentController::class);
});

Route::middleware(['auth','verified'])->group(function () {
    Route::resource('patients', PatientController::class);
});

Route::middleware(['auth','verified'])->group(function () {
    Route::get('/approve_reject_insurance_claim', [InsuranceClaimController::class, 'index'])->name('insurance-claims.index');
    Route::put('insurance-claims/{claim}/approve', [InsuranceClaimController::class, 'approve'])->name('insurance-claims.approve');
    Route::put('insurance-claims/{claim}/reject', [InsuranceClaimController::class, 'reject'])->name('insurance-claims.reject');
});

Route::middleware(['auth','verified'])->group(function () {
    Route::get('/medical_record', [MedicalRecordController::class, 'index'])->name('medical-records.index');
    Route::get('/create_medical_record', [MedicalRecordController::class, 'create'])->name('medical-records.create');
    Route::get('/search_medical_record', [MedicalRecordController::class, 'search'])->name('medical-records.search');
    Route::get('/searchIndex_medical_record', [MedicalRecordController::class, 'searchIndex'])->name('medical-records.searchIndex');
    Route::post('/store_medical_record', [MedicalRecordController::class, 'store'])->name('medical-records.store');
    Route::get('/show_medical_record/{medicalRecord}', [MedicalRecordController::class, 'show'])->name('medical-records.show');
    Route::get('/edit_medical_/{medicalRecord}/_record', [MedicalRecordController::class, 'edit'])->name('medical-records.edit');
    Route::post('/update_medical_record', [MedicalRecordController::class, 'update'])->name('medical-records.update');
    Route::get('export-pdf', [MedicalRecordController::class, 'exportPdf'])->name('medical-records.export.pdf');
    Route::get('export-excel', [MedicalRecordController::class, 'exportExcel'])->name('medical-records.export.excel');
    Route::put('/medical-records/{medicalRecord}', [MedicalRecordController::class, 'update'])->name('medical-records.update');
    Route::put('/medical-records/{medicalRecord}', [MedicalRecordController::class, 'updateNotes'])->name('medical-records.updateNotes');
    Route::delete('/medical-records/{id}', [MedicalRecordController::class, 'destroy'])->name('medical-records.destroy');
    Route::get('/medicalRecord/download/{id}', [MedicalRecordController::class, 'downloadMedicalRecord'])->name('medicalRecord.download');
    // can always use this
        // Route::resource('medical-records', MedicalRecordController::class);
        // This will automatically register all standard routes (index, create, store, show, edit, update, destroy) ETC.
});

Route::middleware(['auth','verified'])->group(function () {
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

Route::middleware(['auth','verified'])->group(function () {
    Route::resource('payments', PaymentController::class)->only(['store']);
    Route::get('/payments/create/{invoice}', [PaymentController::class, 'create'])->name('payments.create');
    Route::get('/payments/{payment}/receipt', [PaymentController::class, 'generateReceipt'])->name('payments.receipt');
});

Route::middleware(['auth','verified'])->group(function () {
    Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
});

Route::middleware(['auth','verified'])->group(function () {
    Route::resource('stocks', MedicineStockController::class);
    Route::get('/{stock}/edit', [MedicineStockController::class, 'edit'])->name('medicine_stocks.edit');
    Route::put('/{stock}', [MedicineStockController::class, 'update'])->name('medicine_stocks.update');
    Route::get('/stock/alerts', [MedicineStockController::class, 'alerts'])->name('stock.alerts');
});

Route::middleware(['auth','verified'])->group(function () {
    Route::post('/pharmacy/dispense/{record}', [PharmacyController::class, 'dispense'])->name('pharmacy.dispense');
    Route::get('/pharmacy/alerts', [PharmacyController::class, 'alerts'])->name('pharmacy.alerts');
});

Route::middleware(['auth','verified'])->group(function () {
    Route::get('lab-tests/{record}', [LabTestController::class, 'create'])->name('lab-tests.create');
    Route::post('lab-tests', [LabTestController::class, 'store'])->name('lab-tests.store');
    Route::get('lab-tests', [LabTestController::class, 'index'])->name('lab-tests.index');
    Route::get('lab-tests/show', [LabTestController::class, 'index'])->name('lab-tests.show');
    Route::get('lab-tests/edit', [LabTestController::class, 'index'])->name('lab-tests.edit');
    // Route::resource('lab-tests', LabTestController::class);
});


Route::middleware(['auth','verified'])->group(function () {
    // Route::post('/dispense', [DispenseController::class, 'dispense'])->name('dispense.medication');
    Route::post('/dispense', [DispenseController::class, 'dispense'])->name('dispense.store');
    Route::get('/pharmacy/dispense{stockItems}', [DispenseController::class, 'index'])->name('dispense.med');
});

Route::middleware(['auth','verified'])->group(function () {
    Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
    Route::get('/rooms/dashboard', [RoomController::class, 'dashboard'])->name('rooms.dashboard');
    Route::get('/api/rooms/occupancy', [RoomController::class, 'occupancyData'])->name('rooms.occupancy.data');
    Route::post('/room/assign', [RoomAssignmentController::class, 'assignPatientToRoom'])->name('room.assign');
    Route::get('/patient/assign', [RoomAssignmentController::class, 'index'])->name('rooms.assign_room');
    Route::post('/assignments/{id}/discharge', [RoomAssignmentController::class, 'dischargePatient'])->name('assignments.discharge');
});
Route::middleware(['auth', 'verified'])->group(function(){
    Route::resource('rooms', RoomController::class);
});

Route::get('/staff/dashboard', [StaffController::class, 'dashboard'])->name('staff.dashboard');
Route::resource('staff', StaffController::class);
Route::get('/staff/{id}/edit', [StaffController::class, 'edit'])->name('staff.edit');
// Route::get('/staff/dashboard', [StaffController::class, 'dashboard'])->name('staff.dashboard');
Route::resource('departments', DepartmentController::class);
Route::resource('recruitments', RecruitmentController::class);
Route::get('/test', function() {
    return 'Route works';
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
