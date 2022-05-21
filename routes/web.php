<?php

use App\Http\Controllers\CourtController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\JudgementController;
use App\Http\Controllers\UserController;
use App\Models\CauseList;
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

    Route::get('admin/courts', [CourtController::class, 'index'])->name('courts.index');
    Route::get('admin/courts/create', [CourtController::class, 'create'])->name('courts.create');
    Route::post('admin/courts', [CourtController::class, 'store'])->name('courts.store');
    Route::get('admin/courts/{court}/edit', [CourtController::class, 'edit'])->name('courts.edit');
    Route::patch('admin/courts/{court}', [CourtController::class, 'update'])->name('courts.update');

    Route::get('admin/cause_lists', [CauseListController::class, 'index'])->name('cause_lists.index');
    Route::get('admin/cause_lists/create', [CauseListController::class, 'create'])->name('cause_lists.create');
    Route::post('admin/cause_lists', [CauseListController::class, 'store'])->name('cause_lists.store');
    Route::get('admin/cause_lists/{cause_list}/edit', [CauseListController::class, 'edit'])->name('cause_lists.edit');
    Route::patch('admin/cause_lists/{cause_list}', [CauseListController::class, 'update'])->name('cause_lists.update');

    Route::get('admin/judgements', [JudgementController::class, 'index'])->name('judgements.index');
    Route::get('admin/judgements/create', [JudgementController::class, 'create'])->name('judgements.create');
    Route::post('admin/judgements', [JudgementController::class, 'store'])->name('judgements.store');
    Route::get('admin/judgements/{judgement}/edit', [JudgementController::class, 'edit'])->name('judgements.edit');
    Route::patch('admin/judgements/{judgement}', [JudgementController::class, 'update'])->name('judgements.update');

});

require __DIR__.'/auth.php';
