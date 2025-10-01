<?php

use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\MachineryController;
use App\Http\Controllers\MechanicController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\TransporterController;
use App\Http\Controllers\UserPaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Profile\UserProfileController;

Route::get('/', function () { return view('dashboard'); })->name('dashboard');
Route::get('/hiw', function () { return view('dashboard'); })->name('how.it.works');
Route::get('/search/machinery', function () { return view('search'); })->name('search.machinery');
Route::get('/search/mechanic', function () { return view('search'); })->name('search.mechanic');
Route::get('/search/transporter', function () { return view('search'); })->name('search.transporter');
Route::middleware([
    'auth:web',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

//    Route::get('/', function () {
//        return view('dashboard');
//    })->name('dashboard')->middleware('can:Admin Equipment');

    Route::get('/user/equipment', [EquipmentController::class, 'index'])->name('equipment')->middleware('can:My Equipment');
    Route::get('/user/operators', [OperatorController::class, 'index'])->name('operators')->middleware('can:My Equipment');
    Route::get('/user/machinery', [MachineryController::class, 'index'])->name('machinery')->middleware('can:My Machinery');
    Route::get('/user/mechanic', [MechanicController::class, 'index'])->name('mechanic')->middleware('can:My Mechanic');
    Route::get('/user/transporter', [TransporterController::class, 'index'])->name('transporter')->middleware('can:My Transporter');
    Route::get('/user/payments', [UserPaymentController::class , 'index'])->name('payments')->middleware('can:Payment');

    //Rentals
    Route::get('/rentals', function () {
        return view('dashboard');
    })->name('rentals');

    //ADMIN

    Route::get('/user/profile/{user}', [UserProfileController::class, 'show'])->name('admin.edit.user')->middleware('can:Admin Users - Edit');
    Route::get('/admin/users', function () {
        return view('admin.users.users');
    })->name('admin-users')->middleware('can:Admin Users');

    Route::get('/admin/permissions', function () {
        return view('admin.users.permissions');
    })->name('admin-permissions')->middleware('can:Admin Permissions');

    Route::get('/admin/payments', [UserPaymentController::class , 'indexAdmin'])->name('admin-payments')->middleware('can:Admin Payment');

    Route::get('/admin/rentals', function () {
        return view('dashboard');
    })->name('admin-rentals')->middleware('can:Admin Rentals');

    //ADMIN Machinery
    Route::get('admin/machinery/', [MachineryController::class, 'index'])->name('admin.machinery')->middleware('can:My Machinery');
    Route::get('/admin/machinery/types', function () {
        return view('machinery.types');
    })->name('admin.machinery.types')->middleware('can:Admin Equipment');

    //ADMIN Transporter
    Route::get('admin/transporter/', [TransporterController::class, 'index'])->name('admin.transporter')->middleware('can:Admin Transporter');
    Route::get('/admin/transporter/types', function () {
        return view('transporter.types');
    })->name('admin.transporter.types')->middleware('can:Admin Transporter Type');

    //ADMIN Equipment
    Route::get('/admin/equipment', [EquipmentController::class, 'index'])->name('admin.equipment')->middleware('can:Admin Payment');
    Route::get('/admin/equipment/types', function () {
        return view('equipment.types');
    })->name('admin.equipment.types')->middleware('can:Admin Equipment');

    //Admin Mechanic
    Route::get('admin/mechanic/', [MechanicController::class, 'index'])->name('admin.mechanic')->middleware('can:Admin Mechanic');
    Route::get('admin/packages/', [PackageController::class, 'index'])->name('admin.packages')->middleware('can:Admin Mechanic');
});
