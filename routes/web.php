<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CountController;
use App\Http\Controllers\SamplingController;
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
    Route::get('/dashboard_sampling', [SamplingController::class, 'index'])->name('dashboard_sampling');
    Route::get('/get_table', [SamplingController::class, 'getDataTable'])->name('get_table');
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
});
Route::get('/tabel', function () {
    $arrLogPerhari = array();
    $dataLog = DB::table('log')
        ->select('log.*',  DB::raw("DATE_FORMAT(log.timestamp,'%d-%m') as hari"))
        ->orderBy('log.timestamp', 'DESC')
        ->get()
        ->groupBy('hari');

    // dd($dataLog);
    $count = 1;

    $oerLog = DB::table('oer')
        ->select('oer.*',  DB::raw("DATE_FORMAT(oer.timestamp,'%d-%m') as hari"))
        ->orderBy('oer.timestamp', 'DESC')
        ->get()
        ->groupBy('hari');
    $oerVal = 0;
    $oerLog = json_decode($oerLog, true);

    $chLog = DB::connection('mysql2')->table('db_aws_bke')
        ->select('db_aws_bke.*',  DB::raw("DATE_FORMAT(db_aws_bke.datetime,'%d-%m-%Y') as hari"))
        ->orderBy('db_aws_bke.datetime', 'DESC')
        ->get()
        ->groupBy('hari');

    $arrCh = array();
    foreach ($chLog as $key => $data) {
        $sum_rain = 0;
        foreach ($data as $key2 => $value) {
            $sum_rain += $value->rain_fall_real;
        }
        $arrCh[$key]['rain_fall'] = $sum_rain;
        $arrCh[$key]['hari'] = $key;
    }

    $chVal = 0;
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

        if (array_key_exists($inc, $oerLog)) {
            if ($inc == $oerLog[$inc][0]['hari']) {
                $oerVal = $oerLog[$inc][0]['oer'];
            }
        }
        if (array_key_exists($inc, $arrCh)) {
            if ($inc == $arrCh[$inc]['hari']) {
                $chVal = $arrCh[$inc]['rain_fall'];
            } else {
                $chVal = 0;
            }
        }
        $arrLogPerhari[$inc]['id'] = $count;
        $arrLogPerhari[$inc]['total'] = $sumUnripe + $sumRipe + $sumOverripe + $sumEmptyBunch + $sumAbnormal;
        $arrLogPerhari[$inc]['timestamp'] = Carbon::createFromFormat('Y-m-d H:i:s', $data->timestamp)->isoFormat('D MMMM');
        $arrLogPerhari[$inc]['oer'] = $oerVal;
        $arrLogPerhari[$inc]['curah_hujan'] = $chVal;
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
