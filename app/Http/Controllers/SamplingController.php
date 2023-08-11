<?php

namespace App\Http\Controllers;

use App\Models\Estate;
use App\Models\LogSampling;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class SamplingController extends Controller
{
    //

    public function index()
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

        return view('sampling/index', ['list_mill' => $list_mill]);
        return view('sampling/index');
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
            dd($query->wilayah->regional);
            // $reg[$query->wilayah->id] = $query->wilayah->regional->nama;
        }

        dd($wil);
        // dd($queryLog);
    }

    public function getDataTable(Request $request)
    {

        $log = DB::table('log_sampling')
            ->join('list_mill', 'log_sampling.mill_id', '=', 'list_mill.id')
            ->select(
                'log_sampling.*',
                'list_mill.mill',
                DB::raw("DATE_FORMAT(log_sampling.waktu_selesai, '%d %M %Y') as waktu_selesai_formed"),
                DB::raw("(log_sampling.unripe + log_sampling.ripe + log_sampling.overripe + log_sampling.empty_bunch + log_sampling.abnormal + log_sampling.kastrasi ) as total_sum"),
                DB::raw("CASE WHEN (log_sampling.unripe + log_sampling.ripe + log_sampling.overripe + log_sampling.empty_bunch + log_sampling.abnormal) > 0 THEN (ripe / (log_sampling.unripe + log_sampling.ripe + log_sampling.overripe + log_sampling.empty_bunch + log_sampling.abnormal + log_sampling.kastrasi )) * 100 ELSE 0 END as ripeness")
            )
            ->get();

        // dd($log);

        return Datatables::of($log)
            ->editColumn('waktu_selesai', function ($model) {
                return $model->waktu_selesai_formed;
                // return '<span style="font-size:10px;">' . $model['harianUnripe'] . ' </span>';
            })
            ->editColumn('janjang', function ($model) {
                return $model->total_sum;
                // return '<span style="font-size:10px;">' . $model['harianUnripe'] . ' </span>';
            })
            ->editColumn('ripeness', function ($model) {
                return round($model->ripeness, 2) . ' %';
                // return '<span style="font-size:10px;">' . $model['harianUnripe'] . ' </span>';
            })
            ->make(true);
        // ->groupBy('hari');
    }
}
