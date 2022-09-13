<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CountController;
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
    Route::get('/grafik', [CountController::class, 'grafik'])->name('grafik');
    // Route::get('/tabel', [CountControLler::class, 'tabel']);
    Route::get('/data', [CountController::class, 'tabel'])->name('data');
    Route::post('/storeOer', [CountController::class, 'storeOer'])->name('oer.store');
    Route::get('/editOer/{id}', [CountController::class, 'editOer'])->name('oer.edit');
    Route::delete('/deleteOer/{id}', [CountController::class, 'deleteOer'])->name('oer.destroy');
    Route::get('/oer/index', [CountController::class, 'formOer'])->name('oer.index');
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/update_profile', [AuthController::class, 'updateProfile'])->name('update_profile');
    Route::get('/foto', [CountController::class, 'foto'])->name('foto');
    Route::get('/{hari}/excel', [CountController::class, 'export'])->name('excel');
    Route::get('/{hari}/pdf', [CountController::class, 'pdf'])->name('pdf');
    Route::get('testing', function () {
        return view('export.logPdf');
    })->name('testing');
});
Route::get('/tabel', function () {
    $arrLogPerhari = array();
    $dataLog = DB::table('log')
        ->select('log.*',  DB::raw("DATE_FORMAT(log.timestamp,'%d-%m') as hari"))
        ->orderBy('log.timestamp', 'ASC')
        ->get()
        ->groupBy('hari');

    $count = 1;

    foreach ($dataLog as $inc =>  $value) {
        $sumUnripe = 0;
        $sumRipe = 0;
        $sumOverripe = 0;
        $sumEmptyBunch = 0;
        $sumAbnormal = 0;
        foreach ($value as $key => $data) {
            $sumUnripe += $data->unripe;
            $sumRipe += $data->ripe;
            $sumOverripe += $data->overripe;
            $sumEmptyBunch += $data->empty_bunch;
            $sumAbnormal += $data->abnormal;
        }
        $arrLogPerhari[$inc]['id'] = $count;
        $arrLogPerhari[$inc]['total'] = $sumUnripe + $sumRipe + $sumOverripe + $sumEmptyBunch + $sumAbnormal;
        $arrLogPerhari[$inc]['timestamp'] = Carbon::createFromFormat('Y-m-d H:i:s', $data->timestamp)->isoFormat('D MMMM');
        $arrLogPerhari[$inc]['harianRipe'] = $sumRipe;
        $arrLogPerhari[$inc]['hari'] = $inc;
        $arrLogPerhari[$inc]['persenRipe'] = round((($sumRipe / $arrLogPerhari[$inc]['total']) * 100), 2);

        $count++;
    }
    // dd($arrLogPerhari);
    $LogPerhari = '';
    foreach ($arrLogPerhari as $value) {
        $jam        = $value['timestamp'];
        $LogPerhari .=
            "[{v:'" . $jam . "\\n "  . "'}, {v:" .  $value['harianRipe'] . ", f:'" . $value['harianRipe'] . " (" . $value['persenRipe'] . "%)'},
            ],";

        // "[{v:'" . $jam . "'}, {v:" . $value['harianRipe'] . ", f:'" . $value['harianRipe'] . " buah '},
        // ],";
    }

    // dd($LogPerhari);
    $logPerhariView = [
        'plot2'     => 'Ripe',
        'data'      => $LogPerhari
    ];

    return view('tabel', [
        'logPerhariView' => $logPerhariView,
    ]);
})->name('tabel');

//auth
Route::get('/{hari}/pdfBot', [CountController::class, 'pdfBot'])->name('pdfBot');
Route::get('auth_form', [AuthController::class, 'auth_form']);
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('custom-login', [AuthController::class, 'customLogin'])->name('login.custom');
Route::get('register', [AuthController::class, 'registration'])->name('register-user');
Route::post('custom-registration', [AuthController::class, 'customRegistration'])->name('register.custom');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
