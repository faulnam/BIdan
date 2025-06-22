<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Route;



// Public Landing Page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes (require login)
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Patients
    Route::resource('/patients', PatientController::class);
    
    // Services
    Route::resource('/services', ServiceController::class);

    Route::get('/transactions/{transaction}/pdf', [TransactionController::class, 'downloadPDF'])
    ->name('transactions.downloadPDF');
    
    // Products
    Route::resource('/products', ProductController::class);
    
    // Transactions
    Route::resource('/transactions', TransactionController::class);

    Route::resource('transactions', TransactionController::class);
Route::get('/transactions/{transaction}/download', [TransactionController::class, 'downloadPDF'])->name('transactions.downloadPDF');


    Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');

    
});