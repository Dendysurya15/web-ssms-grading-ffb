<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CountController;
use App\Http\Controllers\SamplingController;
use App\Http\Controllers\TableController;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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

Route::get('/', [AuthController::class, 'index'])->name('login');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [CountController::class, 'dashboard'])->name('dashboard');
    Route::get('get_dashboard_data', [CountController::class, 'get_dashboard_data'])->name('get_dashboard_data');
    Route::get('/grafik', [CountController::class, 'grafik'])->name('grafik');
    // Route::get('/tabel', [CountControLler::class, 'tabel']);
    Route::get('/data', [CountController::class, 'tabel'])->name('data');
    Route::get('/dashboard_sampling', [SamplingController::class, 'index'])->name('dashboard_sampling');
    Route::get('/get_table', [SamplingController::class, 'getDataTable'])->name('get_table');
    Route::get('/getDateTab', [SamplingController::class, 'getDataTable'])->name('getDateTab');
    Route::get('/filter_sampling', [SamplingController::class, 'filterDataSampling'])->name('filter_sampling');
    Route::post('/storeOer', [CountController::class, 'storeOer'])->name('oer.store');
    Route::get('/editOer/{id}', [CountController::class, 'editOer'])->name('oer.edit');
    Route::delete('/deleteOer/{id}', [CountController::class, 'deleteOer'])->name('oer.destroy');
    Route::get('/oer/index', [CountController::class, 'formOer'])->name('oer.index');
    Route::post('/storeCH', [CountController::class, 'storeCH'])->name('ch.store');
    Route::get('/editCH/{id}', [CountController::class, 'editCH'])->name('ch.edit');
    Route::delete('/deleteCH/{id}', [CountController::class, 'deleteCH'])->name('ch.destroy');
    Route::get('/ch/index', [CountController::class, 'formCH'])->name('ch.index');
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/update_profile', [AuthController::class, 'updateProfile'])->name('update_profile');
    Route::get('/foto', [CountController::class, 'foto'])->name('foto');
    Route::get('/{hari}/excel', [CountController::class, 'export'])->name('excel');
    Route::get('/{hari}/pdf', [CountController::class, 'pdf'])->name('pdf');
    Route::get('testing', function () {
        return view('export.logPdf');
    })->name('testing');

    Route::get('/getFilterTemuan', [SamplingController::class, 'getFilterTemuan'])->name('getFilterTemuan');
    Route::get('/newDatatables', [SamplingController::class, 'newDatatables'])->name('newDatatables');
    Route::get('/filterLog', [SamplingController::class, 'filterLog'])->name('filterLog');

    Route::get('/downloaddatapdf', [TableController::class, 'downloadtab'])->name('downloaddatapdf');

    Route::get('/tabel', [TableController::class, 'Dashboard'])->name('tabel');
    Route::get('/datamill', [TableController::class, 'datamill'])->name('datamill');
});

//auth
Route::get('/{hari}/pdfBot', [CountController::class, 'pdfBot'])->name('pdfBot');
Route::get('auth_form', [AuthController::class, 'auth_form']);
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('custom-login', [AuthController::class, 'customLogin'])->name('login.custom');
Route::get('register', [AuthController::class, 'registration'])->name('register-user');
Route::post('custom-registration', [AuthController::class, 'customRegistration'])->name('register.custom');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
