<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BillController;
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

Route::get('/', [UserController::class, 'index'])->name('index');
Route::get('/login', [UserController::class, 'loginget'])->name('loginget');
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard')->middleware('auth');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['role:superadmin']], function () {
    Route::get('/adduser', [UserController::class, 'adduser'])->name('adduser')->middleware('auth');
    Route::post('/storeuser', [UserController::class, 'storeuser'])->name('storeuser')->middleware('auth');
    Route::get('/listuser', [UserController::class, 'listuser'])->name('listuser')->middleware('auth');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('edituser')->middleware('auth');
    Route::post('/users/{id}/update', [UserController::class, 'update'])->name('updateuser')->middleware('auth');
    Route::get('/users/{id}/delete', [UserController::class, 'delete'])->name('deleteuser')->middleware('auth');
    Route::get('/reports', [BillController::class, 'reports'])->name('reports')->middleware('auth');
    Route::get('/bills/{id}/edit', [BillController::class, 'edit'])->name('edit')->middleware('auth');
    Route::post('/bills/{id}/update', [BillController::class, 'update'])->name('update')->middleware('auth');
    Route::post('/reports_with_date', [BillController::class, 'reports_with_date'])->name('reports_with_date')->middleware('auth');
});

Route::get('/addbill', [BillController::class, 'addbill'])->name('addbill')->middleware('auth');
Route::post('/storebill', [BillController::class, 'storebill'])->name('storebill')->middleware('auth');