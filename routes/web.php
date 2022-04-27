<?php

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/admin/dashboard', function(){
    return view('admin/dashboard');
});

Route::get('admin/cause-lists/', [CauseListController::class, 'index']);
Route::get('admin/cause-lists/create', [CauseListController::class, 'create'])->name('cause-lists.create');

require __DIR__.'/auth.php';
