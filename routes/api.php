<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{LoginController, PaymentsController};
use App\Http\Controllers\Employee\{EmployeeController, EmployeeRateController};



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [LoginController::class, 'login'])->name('login');


Route::middleware(['auth:sanctum', 'ability:is_admin'])->group(function() {

    Route::prefix('/employee')->group(function() {
        Route::post('/create', [EmployeeController::class, 'createEmployee'])->name('employee.create');
        Route::match(['post', 'patch'], '/setworkedhoursto', [EmployeeController::class, 'setWorkedHours'])->name('employee.setworkedhours');
        Route::match(['post', 'patch'], '/setrate', [EmployeeRateController::class, 'setEmployeeRate'])->name('employee.setrate');
    });

    Route::prefix('/payments')->group(function() {
        Route::prefix('/hours')->group(function() {
            Route::get('/all', [PaymentsController::class, 'getAllPaymentsByHours'])->name('payments.hours.all');
            Route::post('/execute', [PaymentsController::class, 'executeAllPaymentsByHours'])->name('payments.hours.all');
        });

    });

});

Route::middleware(['auth:sanctum', 'ability:is_employee'])->group(function() {
    Route::prefix('/employee')->group(function() {
        Route::match(['post', 'patch'], '/setworkedhours', [EmployeeController::class, 'setWorkedHoursForCurrent'])->name('employee.setworkedhours');
    });
});



/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/
