<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class TableController extends Controller
{
    //

    public function Dashboard()
    {
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
            // if (array_key_exists($inc, $arrCh)) {
            //     if ($inc == $arrCh[$inc]['hari']) {
            //         $chVal = $arrCh[$inc]['rain_fall'];
            //     } else {
            //         $chVal = 0;
            //     }
            // }
            $arrLogPerhari[$inc]['id'] = $count;
            $arrLogPerhari[$inc]['total'] = $sumUnripe + $sumRipe + $sumOverripe + $sumEmptyBunch + $sumAbnormal;
            $arrLogPerhari[$inc]['timestamp'] = Carbon::createFromFormat('Y-m-d H:i:s', $data->timestamp)->isoFormat('D MMMM');
            $arrLogPerhari[$inc]['oer'] = $oerVal;
            // $arrLogPerhari[$inc]['curah_hujan'] = $chVal;
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


        $datenow = \Carbon\Carbon::now()->format('d-m-Y');

        // dd($datenow);


        $datalog = DB::connection('mysql')->table('log')
            ->select('log.*', DB::raw("DATE_FORMAT(log.timestamp,'%H:00') as jam_ke"))
            ->where('timestamp', 'LIKE', '%' . '2023-11-15' . '%')
            ->orderBy('jam_ke', 'asc')
            ->get();

        $datalog = $datalog->groupBy('jam_ke');
        $getData = json_decode($datalog, true);

        // dd($getData);

        $newdata = array();
        $allIds = []; // To collect all the ids

        $ripeTod = 0;
        $unripeTod = 0;
        $overripeTod = 0;
        $empty_bunchTod = 0;
        $abnormalTod = 0;
        $kastrasiTod = 0;
        foreach ($getData as $key => $value) {
            $ripe = 0;
            $unripe = 0;
            $overripe = 0;
            $empty_bunch = 0;
            $abnormal = 0;
            $kastrasi = 0;
            $totaljjg = 0;
            $ids = []; // To collect ids for each iteration

            foreach ($value as $key2 => $value2) {
                $ripe += $value2['ripe'];
                $unripe += $value2['unripe'];
                $overripe += $value2['overripe'];
                $empty_bunch += $value2['empty_bunch'];
                $abnormal += $value2['abnormal'];
                $kastrasi += $value2['kastrasi'];
                $ids[] = $value2['id'];
                $totaljjg = $ripe + $unripe + $overripe + $empty_bunch + $abnormal + $kastrasi;
            }

            $ripeTod += $ripe;
            $unripeTod += $unripe;
            $overripeTod += $overripe;
            $empty_bunchTod += $empty_bunch;
            $abnormalTod += $abnormal;
            $kastrasiTod += $kastrasi;
            $allIds = array_merge($allIds, $ids);


            $newdata[$key]['ripe'] = $ripe;
            $newdata[$key]['unripe'] = $unripe;
            $newdata[$key]['overripe'] = $overripe;
            $newdata[$key]['empty_bunch'] = $empty_bunch;
            $newdata[$key]['abnormal'] = $abnormal;
            $newdata[$key]['kastrasi'] = $kastrasi;
            $newdata[$key]['totaljjg'] = $totaljjg;
            $newdata[$key]['jam'] = $key;
            $newdata[$key]['id'] = $allIds;
        }

        $getmil = DB::connection('mysql')->table('list_mill')
            ->select('list_mill.*')
            ->get();

        // dd($getmil);

        // dd($LogPerhari);
        $logPerhariView = [
            'plot2'     => 'Ripe',
            'data'      => $LogPerhari
        ];

        return view('tabel', [
            'logPerhariView' => $logPerhariView,
            'newdata' => $newdata,
            'getmil' => $getmil,
        ]);
    }

    public function datamill(Request $request)
    {

        $mill = $request->input('mill');

        // dd($mill);

        $arrLogPerhari = array();
        $dataLog = DB::table('log')
            ->select('log.*',  DB::raw("DATE_FORMAT(log.timestamp,'%d-%m') as hari"))
            ->where('id_mill', $mill)
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
            // if (array_key_exists($inc, $arrCh)) {
            //     if ($inc == $arrCh[$inc]['hari']) {
            //         $chVal = $arrCh[$inc]['rain_fall'];
            //     } else {
            //         $chVal = 0;
            //     }
            // }
            $arrLogPerhari[$inc]['id'] = $count;
            $arrLogPerhari[$inc]['total'] = $sumUnripe + $sumRipe + $sumOverripe + $sumEmptyBunch + $sumAbnormal;
            $arrLogPerhari[$inc]['timestamp'] = Carbon::createFromFormat('Y-m-d H:i:s', $data->timestamp)->isoFormat('D MMMM');
            $arrLogPerhari[$inc]['oer'] = $oerVal;
            // $arrLogPerhari[$inc]['curah_hujan'] = $chVal;
            $arrLogPerhari[$inc]['harianRipe'] = $sumRipe;
            $arrLogPerhari[$inc]['hari'] = $inc;
            $arrLogPerhari[$inc]['persenRipe'] = round((($sumRipe / $arrLogPerhari[$inc]['total']) * 100), 2);

            $count++;
        }

        // dd($arrLogPerhari);
        foreach ($arrLogPerhari as $key => $value) {
            # code...

            $ripenes[] = $value['persenRipe'];
            $dates[] = $value['timestamp'];
        }

        // dd($ripenes);

        $datenow = \Carbon\Carbon::now()->format('Y-m-d');

        // dd($datenow);


        $datalog = DB::connection('mysql')->table('log')
            ->select('log.*', DB::raw("DATE_FORMAT(log.timestamp,'%H:00') as jam_ke"))
            ->where('id_mill', $mill)
            ->where('timestamp', 'LIKE', '%' . $datenow . '%')
            ->orderBy('jam_ke', 'asc')
            ->get();

        $datalog = $datalog->groupBy('jam_ke');
        $getData = json_decode($datalog, true);

        // dd($getData, $datenow);
        $millnama = DB::connection('mysql')->table('list_mill')
            ->select('list_mill.*')
            ->where('id', $mill)
            ->pluck('nama_mill');


        $newdata = array();
        $allIds = []; // To collect all the ids

        $ripeTod = 0;
        $unripeTod = 0;
        $overripeTod = 0;
        $empty_bunchTod = 0;
        $abnormalTod = 0;
        $kastrasiTod = 0;
        foreach ($getData as $key => $value) {
            $ripe = 0;
            $unripe = 0;
            $overripe = 0;
            $empty_bunch = 0;
            $abnormal = 0;
            $kastrasi = 0;
            $totaljjg = 0;
            $ids = []; // To collect ids for each iteration

            foreach ($value as $key2 => $value2) {
                $ripe += $value2['ripe'];
                $unripe += $value2['unripe'];
                $overripe += $value2['overripe'];
                $empty_bunch += $value2['empty_bunch'];
                $abnormal += $value2['abnormal'];
                $kastrasi += $value2['kastrasi'];
                $ids[] = $value2['id'];
                $totaljjg = $ripe + $unripe + $overripe + $empty_bunch + $abnormal + $kastrasi;
            }

            $ripeTod += $ripe;
            $unripeTod += $unripe;
            $overripeTod += $overripe;
            $empty_bunchTod += $empty_bunch;
            $abnormalTod += $abnormal;
            $kastrasiTod += $kastrasi;
            $allIds = array_merge($allIds, $ids);

            $timestamp = $value2['timestamp'];

            $carbonTimestamp = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $timestamp);
            $dateFormatted = $carbonTimestamp->format('M-d-Y'); // Format: Nov-15-2023

            // dd($dateFormatted);

            $newdata[$key]['ripe'] = $ripe;
            $newdata[$key]['unripe'] = $unripe;
            $newdata[$key]['overripe'] = $overripe;
            $newdata[$key]['empty_bunch'] = $empty_bunch;
            $newdata[$key]['abnormal'] = $abnormal;
            $newdata[$key]['kastrasi'] = $kastrasi;
            $newdata[$key]['totaljjg'] = $totaljjg;
            $newdata[$key]['jam'] = $key;
            $newdata[$key]['id'] = $allIds;
            $newdata[$key]['date'] = $dateFormatted;
            $newdata[$key]['millnama'] = $millnama;
        }

        $getmil = DB::connection('mysql')->table('list_mill')
            ->select('list_mill.*')
            ->get();

        // dd($newdata);

        // dd($LogPerhari);
        $logPerhariView = [
            'plot2'     => 'Ripe',
            'data'      => $arrLogPerhari,
            'ripenes'      => $ripenes,
            'dates'      => $dates,
        ];

        $arrView['logPerhariView'] = $logPerhariView; // Ensure it's a string
        $arrView['newdata'] = $newdata; // Ensure it's a string
        $arrView['getmil'] = $getmil; // Ensure it's a string

        return response()->json($arrView);
        // return view('tabel', [
        //     'logPerhariView' => $logPerhariView,
        //     'newdata' => $newdata,
        //     'getmil' => $getmil,
        // ]);
    }

    public function downloadtab(Request $request)
    {
        $data = $request->input('jam');
        $id = $request->input('id');
        $date = $request->input('date');
        $millnama = $request->input('millnama');

        // dd($idArray);

        $datenow = \Carbon\Carbon::now()->format('Y-m-d');


        $datalog = DB::connection('mysql')->table('log')
            ->select('log.*', DB::raw("DATE_FORMAT(log.timestamp,'%H:00') as jam_ke"))
            ->where('timestamp', 'LIKE', '%' . $datenow . '%')
            ->orderBy('jam_ke', 'asc')
            ->get();

        $datalog = $datalog->groupBy('jam_ke');
        $getData = json_decode($datalog, true);

        // dd($id);

        $newdata = array();
        $allIds = []; // To collect all the ids

        $ripeTod = 0;
        $unripeTod = 0;
        $overripeTod = 0;
        $empty_bunchTod = 0;
        $abnormalTod = 0;
        $kastrasiTod = 0;
        foreach ($getData as $key => $value) {
            $ripe = 0;
            $unripe = 0;
            $overripe = 0;
            $empty_bunch = 0;
            $abnormal = 0;
            $kastrasi = 0;
            $totaljjg = 0;
            $ids = []; // To collect ids for each iteration

            foreach ($value as $key2 => $value2) {
                $ripe += $value2['ripe'];
                $unripe += $value2['unripe'];
                $overripe += $value2['overripe'];
                $empty_bunch += $value2['empty_bunch'];
                $abnormal += $value2['abnormal'];
                $kastrasi += $value2['kastrasi'];
                $ids[] = $value2['id'];
                $totaljjg = $ripe + $unripe + $overripe + $empty_bunch + $abnormal + $kastrasi;
            }

            $ripeTod += $ripe;
            $unripeTod += $unripe;
            $overripeTod += $overripe;
            $empty_bunchTod += $empty_bunch;
            $abnormalTod += $abnormal;
            $kastrasiTod += $kastrasi;
            $allIds = array_merge($allIds, $ids);


            $newdata[$key]['ripe'] = $ripe;
            $newdata[$key]['unripe'] = $unripe;
            $newdata[$key]['overripe'] = $overripe;
            $newdata[$key]['empty_bunch'] = $empty_bunch;
            $newdata[$key]['abnormal'] = $abnormal;
            $newdata[$key]['kastrasi'] = $kastrasi;
            $newdata[$key]['totaljjg'] = $totaljjg;
            $newdata[$key]['jam'] = $key;
            $newdata[$key]['id'] = $allIds;
        }


        $pdfdata = [];

        foreach ($newdata as $key => $value) {
            # code...
            if ($key == $data) {
                # code..
                $pdfdata[$key] = $value;
            }
        }

        // dd($pdfdata);


        $idArray = explode(",", $id);
        $idArray = array_map('intval', $idArray); // Convert string IDs to integers


        $datamins = DB::connection('mysql')->table('log')
            ->select('log.*', DB::raw("DATE_FORMAT(log.timestamp,'%H:%i') as jam_ke"))
            ->where('timestamp', 'LIKE', '%' . $datenow . '%')
            ->whereIn('id', $idArray)
            ->orderBy('jam_ke', 'asc')
            ->get();


        $datamins = $datamins->groupBy('jam_ke');
        $datapermins = json_decode($datamins, true);




        // dd($pdfdata, $datapermins);

        $finalData = array();

        $finalData['datahours'] = $pdfdata;
        $finalData['dataM'] = $datapermins;
        $finalData['date'] = $date;
        $finalData['millnama'] = $millnama;

        // dd($finalData);

        $pdf = PDF::loadView('pdf.tablepdf', ['data' => $finalData]);
        $pdf->setPaper('A2', 'portrait'); // Note the correct method name and 'portrait' spelling

        $filename = 'Grading AI.pdf';

        return $pdf->stream($filename);
    }
}
