<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CountController;
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
    Route::get('/grafik', [CountController::class, 'grafik'])->name('grafik');
    // Route::get('/tabel', [CountControLler::class, 'tabel']);
    Route::get('/tabel', function () {
        return view('tabel');
    })->name('tabel');
    Route::get('/data', [CountController::class, 'tabel'])->name('data');
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/update_profile', [AuthController::class, 'updateProfile'])->name('update_profile');
    Route::get('/foto', [CountController::class, 'foto'])->name('foto');
    Route::get('/{hari}/excel', [CountController::class, 'export'])->name('excel');
    Route::get('/{hari}/pdf', [CountController::class, 'pdf'])->name('pdf');
    Route::get('testing', function () {
        return view('export.logPdf');
    });
});

//auth
Route::get('auth_form', [AuthController::class, 'auth_form']);
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('custom-login', [AuthController::class, 'customLogin'])->name('login.custom');
Route::get('register', [AuthController::class, 'registration'])->name('register-user');
Route::post('custom-registration', [AuthController::class, 'customRegistration'])->name('register.custom');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
