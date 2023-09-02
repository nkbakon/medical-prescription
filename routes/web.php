<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AuthController;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\DrugController;
use \App\Http\Controllers\PrescriptionController;
use \App\Http\Controllers\QuotationController;
use \App\Http\Controllers\PasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/', [AuthController::class, 'loginPost'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth']], function() {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('drugs', DrugController::class);
    Route::resource('prescriptions', PrescriptionController::class);
    Route::get('prescriptions/{prescription}/view', [PrescriptionController::class, 'view'])->name('prescriptions.view');

    Route::resource('quotations', QuotationController::class);
    Route::get('quotations/{quotation}/view', [QuotationController::class, 'view'])->name('quotations.view');

    Route::resource('users', UserController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', function () {
        return view('profile.edit');
    })->name('profile.edit');
    Route::put('/profile', [PasswordController::class, 'update'])->name('password.update');
});
