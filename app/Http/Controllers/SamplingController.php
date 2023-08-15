<?php

namespace App\Http\Controllers;

use App\Models\Estate;
use App\Models\LogSampling;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;



class SamplingController extends Controller
{
    //

    public function index(Request $request)
    {
        $list_mill = DB::table('list_mill')->get();

        // $dateToday = new DateTime('2023-08-01');

        // $dateToday = $dateToday->format('Y-m-d');

        // $queryData = DB::table('log_sampling')
        //     ->whereDate('waktu_selesai', $dateToday)
        //     ->get();



        // $list_mill = DB::table('log_sampling')->get();

        // $queryReg = $list_mill->groupBy('reg_id')->map(function ($items, $reg_id) {
        //     return $reg_id;
        // })->toArray();




        // $list_reg = array();
        // foreach ($queryReg as $key => $data) {
        //     $query = DB::connection('mysql2')->table('reg')
        //         ->join('srsssmsc_grading_ai.list_mill', 'reg.id', '=', 'list_mill.reg_id')
        //         ->where('list_mill.reg_id', $data)
        //         ->get();
        //     $list_reg[$key] = $query[0]->nama;
        // }

        $ListReg = DB::connection('mysql3')->table('reg')
            ->get();
        $ListReg = json_decode($ListReg, true);

        $list_wil = DB::connection('mysql3')->table('wil')
            ->get();
        $list_wil = json_decode($list_wil, true);

        $list_est = DB::connection('mysql3')->table('estate')
            ->get();
        $list_est = json_decode($list_est, true);

        $list_mil = DB::table('list_mill')
            ->get();
        $list_mil = json_decode($list_mil, true);


        // dd($list_est, $list_wil);



        return view('sampling/index', [
            'list_reg' => $ListReg, // Update this line
            'list_will' => $list_wil, // Change this to 'list_will'
            'list_est' => $list_est, // Change this to 'list_will'
            'list_mil' => $list_mil, // Change this to 'list_will'
        ]);
    }


    public function getFilterTemuan(Request $request)
    {
        $date =  $request->get('date');
        $regional =  $request->get('regional');
        $wilayah =  $request->get('wilayah');
        $estate =  $request->get('estate');
        // $mill =  $request->get('mill');

        // dd($date, $regional, $wilayah, $estate, $mill);

        // dd($date, $estate);


        $list_mill = DB::table('list_mill')
            ->select('list_mill.*')
            ->join('log_sampling', 'list_mill.id', '=', 'log_sampling.mill_id')
            ->where('log_sampling.waktu_mulai', 'like', '%' . $date . '%')
            ->where('log_sampling.bisnis_unit', '=', $estate)
            ->distinct() // Add this line to select distinct records
            ->get();


        $list_pplat = DB::table('log_sampling')
            ->select('log_sampling.*')
            ->where('log_sampling.waktu_mulai', 'like', '%' . $date . '%')
            ->where('log_sampling.bisnis_unit', '=', $estate)
            // ->where('log_sampling.mill_id', '=', $list_mill)
            ->get();

        $list_driver =  DB::table('log_sampling')
            ->select('log_sampling.*')
            ->where('log_sampling.waktu_mulai', 'like', '%' . $date . '%')
            ->where('log_sampling.bisnis_unit', '=', $estate)
            // ->where('log_sampling.mill_id', '=', $list_mill)
            ->get();

        $list_status =  DB::table('log_sampling')
            ->select('log_sampling.*')
            ->where('log_sampling.waktu_mulai', 'like', '%' . $date . '%')
            ->where('log_sampling.bisnis_unit', '=', $estate)
            // ->where('log_sampling.mill_id', '=', $list_mill)
            ->get();

        // dd($list_pplat, $list_mill);

        $arrView = array();
        $arrView['list_mill'] = $list_mill; // No need to encode as JSON
        $arrView['list_plat'] = $list_pplat;
        $arrView['list_driver'] = $list_driver;
        $arrView['list_status'] = $list_status;

        echo json_encode($arrView);
        exit();
    }

    public function filterDataSampling(Request $request)
    {
        $req_tgl =  $request->get('tgl');

        $queryLog = DB::table('log_sampling')
            ->join('list_mill', 'log_sampling.mill_id', '=', 'list_mill.id')
            ->select(
                'log_sampling.*',
                'list_mill.mill',
                DB::raw("DATE_FORMAT(log_sampling.waktu_selesai, '%d %M %Y') as waktu_selesai_formed"),
                DB::raw("(log_sampling.unripe + log_sampling.ripe + log_sampling.overripe + log_sampling.empty_bunch + log_sampling.abnormal + log_sampling.kastrasi ) as total_sum"),
                DB::raw("CASE WHEN (log_sampling.unripe + log_sampling.ripe + log_sampling.overripe + log_sampling.empty_bunch + log_sampling.abnormal) > 0 THEN (ripe / (log_sampling.unripe + log_sampling.ripe + log_sampling.overripe + log_sampling.empty_bunch + log_sampling.abnormal + log_sampling.kastrasi )) * 100 ELSE 0 END as ripeness")
            )
            ->whereDate('log_sampling.waktu_selesai', $req_tgl)
            ->get();

        $groupWil = $queryLog->groupBy('bisnis_unit');

        $wil = array();
        $reg = array();
        foreach ($groupWil as $key => $data) {
            $query = Estate::with('wilayah.regional')->where('est', $key)->first();
            $wil[$query->wilayah->id] = $query->wilayah->nama;
            // dd($query->wilayah->regional);
            // $reg[$query->wilayah->id] = $query->wilayah->regional->nama;
        }

        // dd($wil);
        // dd($queryLog);
    }

    public function getDataTable(Request $request)
    {
        $req_tgl =  $request->get('date');


        // dd($estate);

        // Query without ->get()
        $log = DB::table('log_sampling')
            ->join('list_mill', 'log_sampling.mill_id', '=', 'list_mill.id')
            ->select(
                'log_sampling.*',
                'list_mill.mill',
                DB::raw("DATE_FORMAT(log_sampling.waktu_selesai, '%d %M %Y') as waktu_selesai_formed"),
                DB::raw("(log_sampling.unripe + log_sampling.ripe + log_sampling.overripe + log_sampling.empty_bunch + log_sampling.abnormal + log_sampling.kastrasi ) as janjang"),
                DB::raw("CASE WHEN (log_sampling.unripe + log_sampling.ripe + log_sampling.overripe + log_sampling.empty_bunch + log_sampling.abnormal) > 0 THEN (ripe / (log_sampling.unripe + log_sampling.ripe + log_sampling.overripe + log_sampling.empty_bunch + log_sampling.abnormal + log_sampling.kastrasi )) * 100 ELSE 0 END as ripeness")
            )
            ->where('log_sampling.waktu_mulai', 'like', '%' . $req_tgl . '%')
            ->where('log_sampling.bisnis_unit', '=', 'SLE');

        $totalRecords = $log->count(); // Total records without filtering
        $filteredRecords = $log->count(); // Total records after filtering




        $totalRecords = $log->count(); // Total records without filtering
        $filteredRecords = $log->count(); // Total records after filtering
        $data = $log->get();

        // dd($data);
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data,
        ]);
    }


    public function newDatatables(Request $request)
    {
        $req_tgl =  $request->get('date');
        $estate =  $request->get('estate');
        $mill =  $request->get('mill');
        $no_plat =  $request->get('no_plat');
        $driver =  $request->get('driver');
        $driverStatus =  $request->get('driverStatus');


        // dd($req_tgl, $estate, $mill, $no_plat, $driver, $driverStatus)
        // // dd($estate);

        // Query without ->get()
        $log = DB::table('log_sampling')
            ->join('list_mill', 'log_sampling.mill_id', '=', 'list_mill.id')
            ->select(
                'log_sampling.*',
                'list_mill.mill',
                DB::raw("DATE_FORMAT(log_sampling.waktu_selesai, '%d %M %Y') as waktu_selesai_formed"),
                DB::raw("(log_sampling.unripe + log_sampling.ripe + log_sampling.overripe + log_sampling.empty_bunch + log_sampling.abnormal + log_sampling.kastrasi ) as janjang"),
                DB::raw("CASE WHEN (log_sampling.unripe + log_sampling.ripe + log_sampling.overripe + log_sampling.empty_bunch + log_sampling.abnormal) > 0 THEN (ripe / (log_sampling.unripe + log_sampling.ripe + log_sampling.overripe + log_sampling.empty_bunch + log_sampling.abnormal + log_sampling.kastrasi )) * 100 ELSE 0 END as ripeness")
            )
            ->where('log_sampling.waktu_mulai', 'like', '%' . $req_tgl . '%')
            ->where('log_sampling.bisnis_unit', '=', $estate)
            ->where('log_sampling.mill_id', '=', $mill)
            ->where('log_sampling.no_plat', '=', $no_plat)
            ->where('log_sampling.nama_driver', '=', $driver)
            ->where('log_sampling.status', '=', $driverStatus);


        $data = $log->get();

        $Chart = DB::table('log_sampling')
            ->select([
                DB::raw("SUM(tp) as total_tp"),
                DB::raw("SUM(kastrasi) as total_kastrasi"),
                DB::raw("SUM(ripe) as total_ripe"),
                DB::raw("SUM(unripe) as total_unripe"),
                DB::raw("SUM(overripe) as total_overripe"),
                DB::raw("SUM(empty_bunch) as total_bunch"),
                DB::raw("SUM(abnormal) as total_abnormal"),
                DB::raw("MAX(log_sampling.waktu_selesai) as date"), // Use MAX as an example
                DB::raw("MAX(log_sampling.bisnis_unit) as est"),   // Use MAX as an example

            ])
            ->where('log_sampling.waktu_mulai', 'like', '%' . $req_tgl . '%')
            ->where('log_sampling.bisnis_unit', '=', $estate)
            ->where('log_sampling.mill_id', '=', $mill)
            ->get();

        $total_tp = $Chart->sum('total_tp');
        $total_kastrasi = $Chart->sum('total_kastrasi');
        $total_ripe = $Chart->sum('total_ripe');
        $total_unripe = $Chart->sum('total_unripe');
        $total_overripe = $Chart->sum('total_overripe');
        $total_bunch = $Chart->sum('total_bunch');
        $total_abnormal = $Chart->sum('total_abnormal');
        $est = $Chart[0]->est;
        $date = date('Y-m-d', strtotime($Chart[0]->date));


        $total_janjang = $total_tp + $total_kastrasi + $total_ripe + $total_unripe + $total_overripe + $total_bunch + $total_abnormal;

        // dd($Chart);
        $ChartResult = [
            // 'total_tp' => $total_tp,
            'total_kastrasi' => $total_kastrasi,
            'total_ripe' => $total_ripe,
            'total_unripe' => $total_unripe,
            'total_overripe' => $total_overripe,
            'total_bunch' => $total_bunch,
            'total_abnormal' => $total_abnormal,
            'total_janjang' => $total_janjang,
            'est' => $est,
            'date' => $date

        ];

        $chart_persen = DB::table('log_sampling')

            ->where('log_sampling.waktu_mulai', 'like', '%' . $req_tgl . '%')
            ->where('log_sampling.bisnis_unit', '=', $estate)
            ->where('log_sampling.mill_id', '=', $mill)
            ->orderBy('waktu_mulai', 'asc')
            ->get();

        $grouped_data = [];

        foreach ($chart_persen as $item) {
            $waktu_mulai = $item->waktu_mulai;
            $hourly_interval = date('H' . '.' . '00', strtotime($waktu_mulai));

            if (!isset($grouped_data[$hourly_interval])) {
                $grouped_data[$hourly_interval] = [];
            }

            $grouped_data[$hourly_interval][] = $item;
        }

        // $grouped_data now contains the data grouped by hours in the "waktu_mulai" field
        $percen = array();
        foreach ($grouped_data as $key => $value) {
            $ripe = 0;
            $kastrasi = 0;
            $unripe = 0;
            $overripe = 0;
            $empty_bunch = 0;
            $abnormal = 0;
            foreach ($value as $key1 => $value2) {
                $ripe = +$value2->ripe;
                $kastrasi = +$value2->kastrasi;
                $unripe = +$value2->unripe;
                $overripe = +$value2->overripe;
                $empty_bunch = +$value2->empty_bunch;
                $abnormal = +$value2->abnormal;
            }

            $total = $ripe + $kastrasi + +$unripe + $overripe + $empty_bunch + $abnormal;
            $percenRipe = round(($ripe / $total) * 100, 2);

            // $percen[$key]['ripe'] = $ripe;
            // $percen[$key]['kastrasi'] = $kastrasi;
            // $percen[$key]['unripe'] = $unripe;
            // $percen[$key]['overripe'] = $overripe;
            // $percen[$key]['empty_bunch'] = $empty_bunch;
            // $percen[$key]['abnormal'] = $abnormal;
            // $percen[$key]['total'] = $total;
            $percen[$key]['Percen_ripe'] = $percenRipe;
        }
        // dd($percen);
        // dd($data, $estate, $req_tgl);
        return response()->json([
            'draw' => intval($request->input('draw')),
            'chart' => $ChartResult,
            'data' => $data,
            'percen' => $percen,
        ]);
    }
}
