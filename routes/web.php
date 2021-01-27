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
    Route::get('/listproject', [ProjectController::class, 'listproject'])->name('listproject')->middleware('auth');
    Route::get('/projects/{id}/edit', [ProjectController::class, 'edit'])->name('editproject')->middleware('auth');
    Route::post('/projects/{id}/update', [ProjectController::class, 'update'])->name('updateproject')->middleware('auth');
    Route::get('/projects/{id}/delete', [ProjectController::class, 'delete'])->name('deleteproject')->middleware('auth');
    Route::get('/listbilladmin', [BillController::class, 'listbilladmin'])->name('listbilladmin')->middleware('auth');
    Route::get('/exporttofileadmin', [BillController::class, 'exporttofileadmin'])->name('exporttofileadmin')->middleware('auth');
    Route::get('/monthlyreportform', [BillController::class, 'monthlyreportform'])->name('monthlyreportform')->middleware('auth');
    Route::post('/monthlyreport', [BillController::class, 'monthlyreport'])->name('monthlyreport')->middleware('auth');
});

Route::group(['middleware' => ['role:superadmin|accounts']], function () {
    Route::get('/monitorbill', [BillController::class, 'monitorbill'])->name('monitorbill')->middleware('auth');
    Route::get('/bills/{id}/approveform', [BillController::class, 'approveform'])->name('approveform')->middleware('auth');
    Route::post('/bills/{id}/approvebill', [BillController::class, 'approvebill'])->name('approvebill')->middleware('auth');
    Route::get('/bills/{id}/rejectform', [BillController::class, 'rejectform'])->name('rejectform')->middleware('auth');
    Route::post('/bills/{id}/rejectbill', [BillController::class, 'rejectbill'])->name('rejectbill')->middleware('auth');
    Route::get('/searchtoapproveform', [BillController::class, 'searchtoapproveform'])->name('searchtoapproveform')->middleware('auth');
    Route::post('/listtoapprove', [BillController::class, 'listtoapprove'])->name('listtoapprove')->middleware('auth');
    Route::post('/approveatonce', [BillController::class, 'approveatonce'])->name('approveatonce')->middleware('auth');
});

Route::get('/addbill', [BillController::class, 'addbill'])->name('addbill')->middleware('auth');
Route::post('/storebill', [BillController::class, 'storebill'])->name('storebill')->middleware('auth');
Route::get('/reportsuser', [BillController::class, 'reportsuser'])->name('reportsuser')->middleware('auth');
Route::post('/reports_with_params_user', [BillController::class, 'reports_with_params_user'])->name('reports_with_params_user')->middleware('auth');
Route::get('/listbilluser', [BillController::class, 'listbilluser'])->name('listbilluser')->middleware('auth');
Route::get('/exporttofileuser', [BillController::class, 'exporttofileuser'])->name('exporttofileuser')->middleware('auth');
Route::get('/projects/{id}/sum/{sum}', [ProjectController::class, 'sum'])->name('sumproject')->middleware('auth');
Route::get('/bills/{id1}/{id2}/{id3}/showfile', [BillController::class, 'showfile'])->name('showfile')->middleware('auth');