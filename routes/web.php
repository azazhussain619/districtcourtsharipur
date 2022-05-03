<?php

use App\Http\Controllers\DesignationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CauseListController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth'])->name('dashboard');



Route::middleware('auth')->group(function () {

    Route::get('/admin/dashboard', function(){
        return view('admin/dashboard');
    });

    Route::get('admin/users', [UserController::class, 'index'])->name('users.index');
    Route::get('admin/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('admin/users', [UserController::class, 'store'])->name('users.store');
    Route::get('admin/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::patch('admin/users/{user}', [UserController::class, 'update'])->name('users.update');

    Route::get('admin/designations', [DesignationController::class, 'index'])->name('designations.index');
    Route::get('admin/designations/create', [DesignationController::class, 'create'])->name('designations.create');
    Route::post('admin/designations', [DesignationController::class, 'store'])->name('designations.store');
    Route::get('admin/designations/{designation}/edit', [DesignationController::class, 'edit'])->name('designations.edit');
    Route::patch('admin/designations/{designation}', [DesignationController::class, 'update'])->name('designations.update');


});

require __DIR__.'/auth.php';
