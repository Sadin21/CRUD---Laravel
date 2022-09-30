<?php

use App\Http\Controllers\AgendaController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AgendaController::class, 'index'])->name('index');
Route::get('/agenda/create', [AgendaController::class, 'create'])->name('create');
Route::post('/agenda/store', [AgendaController::class, 'store'])->name('store');
Route::get('/agenda/edit/{id}', [AgendaController::class, 'edit'])->name('edit');
Route::put('/agenda/edit/{id}', [AgendaController::class, 'update'])->name('edit.update');
Route::delete('/delete/{id}', [AgendaController::class, 'destroy'])->name('delete');

