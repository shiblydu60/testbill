<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
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
    Route::post('/reports_with_params_admin', [BillController::class, 'reports_with_params_admin'])->name('reports_with_params_admin')->middleware('auth');
    Route::get('/bills/{id}/edit', [BillController::class, 'edit'])->name('edit')->middleware('auth');
    Route::post('/bills/{id}/update', [BillController::class, 'update'])->name('update')->middleware('auth');    
    Route::get('/addproject', [ProjectController::class, 'addproject'])->name('addproject')->middleware('auth');
    Route::post('/storeproject', [ProjectController::class, 'storeproject'])->name('storeproject')->middleware('auth');
    Route::get('/addbilladmin', [BillController::class, 'addbilladmin'])->name('addbilladmin')->middleware('auth');
    Route::post('/storebilladmin', [BillController::class, 'storebilladmin'])->name('storebilladmin')->middleware('auth');
    Route::post('/archiveuser/{id}', [UserController::class, 'archiveuser'])->name('archiveuser')->middleware('auth');
});

Route::get('/addbill', [BillController::class, 'addbill'])->name('addbill')->middleware('auth');
Route::post('/storebill', [BillController::class, 'storebill'])->name('storebill')->middleware('auth');
Route::get('/reportsuser', [BillController::class, 'reportsuser'])->name('reportsuser')->middleware('auth');
Route::post('/reports_with_params_user', [BillController::class, 'reports_with_params_user'])->name('reports_with_params_user')->middleware('auth');