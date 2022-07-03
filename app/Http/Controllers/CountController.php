<?php

namespace App\Http\Controllers;

use App\Exports\LogExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\Datatables\Datatables;

class CountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function homepage()
    {
        return view('welcome');
    }

    private $excel;

    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
    }

    public function tabel()
    {
        // Carbon::setLocale('id');
        // $dataLog = DB::table('log')
        //     ->select('log.*')
        //     ->orderBy('log.timestamp', 'desc');

        // setlocale(LC_TIME, 'id_ID');
        // \Carbon\Carbon::setLocale('id');
        // dd(\Carbon\Carbon::now()->subDays(3)->diffForHumans());



        $arrLogPerhari = array();
        $dataLog = DB::table('log')
            ->select('log.*',  DB::raw("DATE_FORMAT(log.timestamp,'%d-%m') as hari"))
            ->orderBy('log.timestamp', 'DESC')
            ->get()
            ->groupBy('hari');

        $count = 1;

        // dd($dataLog);

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
            $arrLogPerhari[$inc]['timestamp'] = Carbon::createFromFormat('Y-m-d H:i:s', $data->timestamp)->isoFormat('dddd, D MMMM Y');
            $arrLogPerhari[$inc]['harianUnripe'] = $sumUnripe;
            $arrLogPerhari[$inc]['harianRipe'] = $sumRipe;
            $arrLogPerhari[$inc]['harianOverripe'] = $sumOverripe;
            $arrLogPerhari[$inc]['harianEmptyBunch'] = $sumEmptyBunch;
            $arrLogPerhari[$inc]['harianAbnormal'] = $sumAbnormal;
            $arrLogPerhari[$inc]['hari'] = $inc;
            $arrLogPerhari[$inc]['persenUnripe'] = round((($sumUnripe / $arrLogPerhari[$inc]['total']) * 100), 2);
            $arrLogPerhari[$inc]['persenRipe'] = round((($sumRipe / $arrLogPerhari[$inc]['total']) * 100), 2);
            $arrLogPerhari[$inc]['persenOverripe'] = round((($sumOverripe / $arrLogPerhari[$inc]['total']) * 100), 2);
            $arrLogPerhari[$inc]['persenEmptyBunch'] = round((($sumEmptyBunch / $arrLogPerhari[$inc]['total']) * 100), 2);
            $arrLogPerhari[$inc]['persenAbnormal'] = round((($sumAbnormal / $arrLogPerhari[$inc]['total']) * 100), 2);

            $count++;
        }

        return DataTables::of($arrLogPerhari)
            ->editColumn('harianUnripe', function ($model) {
                return $model['harianUnripe'] . ' (' . $model['persenUnripe'] . '%)';
                // return '<span style="font-size:10px;">' . $model['harianUnripe'] . ' </span>';
            })
            ->editColumn('harianRipe', function ($model) {
                return $model['harianRipe'] . ' (' . $model['persenRipe'] . '%)';
                // return '<span style="font-size:10px;">' . $model['harianUnripe'] . ' </span>';
            })
            ->editColumn('harianOverripe', function ($model) {
                return $model['harianOverripe'] . ' (' . $model['persenOverripe'] . '%)';
                // return '<span style="font-size:10px;">' . $model['harianUnripe'] . ' </span>';
            })
            ->editColumn('harianEmptyBunch', function ($model) {
                return $model['harianEmptyBunch'] . ' (' . $model['persenEmptyBunch'] . '%)';
                // return '<span style="font-size:10px;">' . $model['harianUnripe'] . ' </span>';
            })
            ->editColumn('harianAbnormal', function ($model) {
                return $model['harianAbnormal'] . ' (' . $model['persenAbnormal'] . '%)';
                // return '<span style="font-size:10px;">' . $model['harianUnripe'] . ' </span>';
            })
            ->addColumn('action', function ($model) {
                return '<a href="' . route('excel', $model['hari']) . '" class="" >  <i class="nav-icon fa fa-file-excel fa-lg" style="color:#1E6E42"></i>    </a>' .
                    '  ' . '<a href="' . route('pdf', $model['hari']) . '" class="" > <i class="nav-icon fa fa-file-pdf fa-lg" style="color:#C52B2E" ></i>   </a>';
            })
            ->make(true);
    }

    public function dashboard(Request $request)
    {
        $dateToday = Carbon::now()->format('Y-m-d');
        $tglData = $request->has('tgl') ? $request->input('tgl') : $defaultHari = $dateToday;
        // $tglData = new DateTime($tglDataInput);
        // $tglData =  $tglData->format('Y-m-d');
        // dd($tglData);

        $arrLogHariini = [
            'plot1'     => 'Unripe',
            'plot2'     => 'Ripe',
            'plot3'     => 'Overripe',
            'plot4'     => 'Empty Bunch',
            'plot5'     => 'Abnormal',
            'data'      => ''
        ];
        $arrLogPerhari = array();
        $dataArr = array();
        $arrJam = ['07:00', '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00', '23:00', '00:00', '01:00', '02:00', '03:00', '04:00', '05:00', '06:00'];
        // for ($i = 0; $i < 24; $i++) {
        //     $dataArr[$i]['timestamp'] = $arrJam[$i];
        //     $dataArr[$i]['harianUnripe'] = 0;
        //     $dataArr[$i]['harianRipe'] = 0;
        //     $dataArr[$i]['harianOverripe'] = 0;
        //     $dataArr[$i]['harianEmptyBunch'] = 0;
        //     $dataArr[$i]['harianAbnormal'] = 0;
        // }

        // dd($dataArr);
        $LogPerhari = '';
        $totalUnripe = 0;
        $totalRipe = 0;
        $totalOverripe = 0;
        $totalEmptyBunch = 0;
        $totalAbnormal = 0;
        $persentaseMasingKategori = array(0, 0, 0, 0, 0);
        $totalMasingKategori = array(0, 0, 0, 0, 0);
        $prctgeAll = array(
            array(
                "kategori" => 'Unripe',
                "stnd_mutu" => 0.5,
                "total" => 0,
            ),
            array(
                "kategori" => 'Ripe',
                "stnd_mutu" => 90,
                "total" => 0,

            ),
            array(
                "kategori" => 'Overripe',
                "stnd_mutu" => 5.5,
                "total" => 0,

            ),
            array(
                "kategori" => 'Empty Bunch',
                "stnd_mutu" => 0.5,
                "total" => 0,

            ),
            array(
                "kategori" => 'Abnormal',
                "stnd_mutu" => 5.5,
                "total" => 0,

            ),
        );

        // dd($prctgeAll);
        // $test = array("");
        // $getDateToday = new DateTime(Carbon::now()->toDateString());
        // $week = [];
        // for ($i = 0; $i <= 7; $i++) {
        //     $week[] = Carbon::parse($getDateToday)->subDays($i)->format('D d-m-Y'); //push the current day and plus the mount of $i 
        // }

        // dd($prctgeAll);
        $nama_kategori_tbs = array('Unripe', 'Ripe', 'Overripe', 'Empty Bunch', 'Abnormal');
        $standar_mutu_view = array('0%', '>90%', '<5%', '0%', '<5%');
        $standar_mutu_real = array(0.5, 90.0, 5.5, 0.5, 5.5);

        $convert = new DateTime($tglData);

        $convert->add(new DateInterval('PT7H'));

        // dd($convert);
        $from = $convert->format('Y-m-d H:i:s');
        // dd($to);
        $dateTo = Carbon::parse($from)->addDays();

        // $dateFrom->add(new DateInterval('PT0H'));
        // dd($dateTo);
        $dateTo = $dateTo->format('Y-m-d H:i:s');

        $to = date($dateTo);

        $logHariini      = '';
        $logHariini = DB::table('log')
            ->select('log.*',  DB::raw("DATE_FORMAT(log.timestamp,'%d-%H') as jam_ke"))
            ->whereBetween('log.timestamp', [$from, $to])
            ->orderBy('log.timestamp')
            ->get()
            ->groupBy('jam_ke');


        // dd($logHariini);
        // $logHariini      = '';
        // $logHariini = DB::table('log')
        //     ->select('log.*',  DB::raw("DATE_FORMAT(log.timestamp,'%d-%H') as jam_ke"))
        //     ->orderBy('log.timestamp', 'desc')
        //     ->where(DB::raw("(DATE_FORMAT(log.timestamp,'%Y-%m-%d'))"), '=', "2022-04-23")
        //     ->get()
        //     ->groupBy('jam_ke');

        // dd($logHariini);


        // $allLog = DB::table('log')
        //     ->select('log.*', 'log.timestamp')
        //     ->orderBy('log.timestamp')
        //     ->where(DB::raw("(DATE_FORMAT(log.timestamp,'%Y-%m-%d'))"), '=', "2022-04-30")
        //     ->get();


        // // dd($allLog);
        // if ($allLog->first() != null) {
        //     $allLogJson = json_decode($allLog, true);

        //     foreach ($allLogJson as $index => $data) {
        //         $totalUnripe += $data['unripe'];
        //         $totalRipe += $data['ripe'];
        //         $totalOverripe += $data['overripe'];
        //         $totalEmptyBunch += $data['empty_bunch'];
        //         $totalAbnormal += $data['abnormal'];
        //     }
        //     $totalAll = $totalUnripe + $totalRipe + $totalOverripe + $totalEmptyBunch + $totalAbnormal;
        //     $arrAllLog = array($totalUnripe, $totalRipe, $totalOverripe, $totalEmptyBunch, $totalAbnormal);

        //     foreach ($arrAllLog as $index => $data) {
        //         $hasil = ($data / $totalAll) * 100;
        //         $prctgeAll[$index]['kategori'] = $nama_kategori_tbs[$index];
        //         $prctgeAll[$index]['stnd_mutu'] = $standar_mutu[$index];
        //         $prctgeAll[$index]['total'] = number_format($data, 0, ".", ".");
        //         $prctgeAll[$index]['persentase'] = round($hasil, 2);
        //     }
        // }

        // dd($logHariini);
        // dd($logHariini->first() != null);
        // if ($logHariini->first() != null) {
        //     dd('test');
        // }
        // dd('coba');

        // dd($dataArr);
        // $dataArr = array();
        $increment = 0;
        // dd($logHariini);
        // dd(count($logHariini));
        $totalAll = 0;
        $totalUnripe = 0;
        $totalRipe = 0;
        $totalOverripe = 0;
        $totalEmptyBunch = 0;
        $totalAbnormal = 0;
        $totalAllSampel = 0;
        if ($logHariini->first() != null) {
            foreach ($logHariini as $inc =>  $value) {
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

                    $jam = date('H', strtotime($data->timestamp)) . ':00';
                }

                // dd($sumUnripe);
                $dataArr[$increment]['timestamp'] = $jam;
                $dataArr[$increment]['timestamp_full'] = $data->timestamp;
                $dataArr[$increment]['harianUnripe'] = $sumUnripe;
                $dataArr[$increment]['harianRipe'] = $sumRipe;
                $dataArr[$increment]['harianOverripe'] = $sumOverripe;
                $dataArr[$increment]['harianEmptyBunch'] = $sumEmptyBunch;
                $dataArr[$increment]['harianAbnormal'] = $sumAbnormal;

                $totalUnripe += $sumUnripe;
                $totalRipe += $sumRipe;
                $totalOverripe += $sumOverripe;
                $totalEmptyBunch += $sumEmptyBunch;
                $totalAbnormal += $sumAbnormal;
                $totalAll += $sumUnripe + $sumRipe + $sumOverripe + $sumEmptyBunch + $sumAbnormal;
                $increment++;
            }
            $totalMasingKategori = [$totalUnripe, $totalRipe, $totalOverripe, $totalEmptyBunch, $totalAbnormal];
            $totalAllSampel = $totalUnripe + $totalRipe + $totalOverripe + $totalEmptyBunch + $totalAbnormal;
            $persentaseMasingKategori = [($totalUnripe / $totalAll) * 100, ($totalRipe / $totalAll) * 100, ($totalOverripe / $totalAll) * 100, ($totalEmptyBunch / $totalAll) * 100, ($totalAbnormal / $totalAll) * 100];
        };

        // dd($dataArr);

        // dd($totalAllSampel);
        for ($i = 0; $i < 5; $i++) {
            $prctgeAll[$i]['kategori'] = $nama_kategori_tbs[$i];
            $prctgeAll[$i]['stnd_mutu'] = $standar_mutu_real[$i];
            $prctgeAll[$i]['stnd_view'] = $standar_mutu_view[$i];
            $prctgeAll[$i]['total'] =  $totalMasingKategori[$i];
            $prctgeAll[$i]['totalAll'] =  $totalAllSampel;
            $prctgeAll[$i]['persentase'] = round($persentaseMasingKategori[$i], 2);
            $prctgeAll[$i]['totalFormat'] =  number_format($totalMasingKategori[$i], 0, ".", ".");
        }

        // dd($prctgeAll);
        // dd($prctgeAll[1]['persentase'] > $prctgeAll[1]['stnd_mutu']);
        // dd($prctgeAll[1]['persentase'] >= $prctgeAll[1]['stnd_mutu']);

        // dd($prctgeAll[1]['kategori'] == 'Ripe');
        // dd($prctgeAll);
        for ($i = 0; $i < 24; $i++) {
            $arrLogPerhari[$i]['timestamp'] = $arrJam[$i];
            $arrLogPerhari[$i]['harianUnripe'] = 0;
            $arrLogPerhari[$i]['harianRipe'] = 0;
            $arrLogPerhari[$i]['harianOverripe'] = 0;
            $arrLogPerhari[$i]['harianEmptyBunch'] = 0;
            $arrLogPerhari[$i]['harianAbnormal'] = 0;
            for ($j = 0; $j < count($dataArr); $j++) {
                if ($arrJam[$i] == $dataArr[$j]['timestamp']) {
                    $arrLogPerhari[$i]['timestamp'] = $arrJam[$i];
                    $arrLogPerhari[$i]['harianUnripe'] = $dataArr[$j]['harianUnripe'];
                    $arrLogPerhari[$i]['harianRipe'] = $dataArr[$j]['harianRipe'];
                    $arrLogPerhari[$i]['harianOverripe'] = $dataArr[$j]['harianOverripe'];
                    $arrLogPerhari[$i]['harianEmptyBunch'] =  $dataArr[$j]['harianEmptyBunch'];
                    $arrLogPerhari[$i]['harianAbnormal'] = $dataArr[$j]['harianAbnormal'];
                }
            }
            // $totalAll = 
        }
        // sort($arrLogPerhari);
        // dd($arrLogPerhari);
        // 
        // $arrLogPerhari = json_decode(json_encode($arrLogPerhari), true);
        foreach ($arrLogPerhari as $value) {

            //Perhari
            $jam        = $value['timestamp'];
            $LogPerhari .=
                "[{v:'" . $jam . "'}, {v:" . $value['harianUnripe'] . ", f:'" . $value['harianUnripe'] . " buah'},
                {v:" . $value['harianRipe'] . ", f:'" . $value['harianRipe'] . " buah '},
                {v:" . $value['harianOverripe'] . ", f:'" . $value['harianOverripe'] . " buah '},   
                {v:" . $value['harianEmptyBunch'] . ", f:'" . $value['harianEmptyBunch'] . " buah '},     
                {v:" . $value['harianAbnormal'] . ", f:'" . $value['harianAbnormal'] . " buah '}                             
            ],";
        }
        // dd($LogPerhari);
        $arrLogHariini = [
            'plot1'     => 'Unripe',
            'plot2'     => 'Ripe',
            'plot3'     => 'Overripe',
            'plot4'     => 'Empty Bunch',
            'plot5'     => 'Abnormal',
            'data'      => $LogPerhari
        ];

        // sort($LogPerhari);

        // dd($LogPerhari);
        // dd($arrLogHariini);

        // if ($logHariini->isNotEmpty()) {

        //     $increment = 1;

        //     if ($logHariini->isNotEmpty()) {
        //         foreach ($logHariini as $inc =>  $value) {
        //             $sumUnripe = 0;
        //             $sumRipe = 0;
        //             $sumOverripe = 0;
        //             $sumEmptyBunch = 0;
        //             $sumAbnormal = 0;
        //             foreach ($value as $key => $data) {
        //                 $sumUnripe += $data->unripe;
        //                 $sumRipe += $data->ripe;
        //                 $sumOverripe += $data->overripe;
        //                 $sumEmptyBunch += $data->empty_bunch;
        //                 $sumAbnormal += $data->abnormal;
        //                 if ($increment == 24) {
        //                     $jam = '06:59';
        //                 } else {
        //                     $jam        = date('H', strtotime($data->timestamp)) . ':00';
        //                 }
        //             }
        //             $arrLogPerhari[$inc]['timestamp'] = $jam;
        //             $arrLogPerhari[$inc]['harianUnripe'] = $sumUnripe;
        //             $arrLogPerhari[$inc]['harianRipe'] = $sumRipe;
        //             $arrLogPerhari[$inc]['harianOverripe'] = $sumOverripe;
        //             $arrLogPerhari[$inc]['harianEmptyBunch'] = $sumEmptyBunch;
        //             $arrLogPerhari[$inc]['harianAbnormal'] = $sumAbnormal;

        //             $increment++;
        //         }

        //         // dd($arrLogPerhari);

        //         $arrLogPerhari = json_decode(json_encode($arrLogPerhari), true);
        //         foreach ($arrLogPerhari as $value) {

        //             // dd($value['timestamp']);
        //             // dd(\Carbon\Carbon::parse($value['timestamp'])->format('d/i:s'));
        //             // Carbon::createFromFormat('H:i:s', $value['timestamp'])->format('H:i');
        //             //Perhari
        //             $jam        = $value['timestamp'];
        //             $LogPerhari .=
        //                 "[{v:'" . $jam . "'}, {v:" . $value['harianUnripe'] . ", f:'" . $value['harianUnripe'] . " buah'},
        //                 {v:" . $value['harianRipe'] . ", f:'" . $value['harianRipe'] . " buah '},
        //                 {v:" . $value['harianOverripe'] . ", f:'" . $value['harianOverripe'] . " buah '},   
        //                 {v:" . $value['harianEmptyBunch'] . ", f:'" . $value['harianEmptyBunch'] . " buah '},     
        //                 {v:" . $value['harianAbnormal'] . ", f:'" . $value['harianAbnormal'] . " buah '}                             
        //             ],";
        //         }

        //         $arrLogHariini = [
        //             'plot1'     => 'Unripe',
        //             'plot2'     => 'Ripe',
        //             'plot3'     => 'Overripe',
        //             'plot4'     => 'Empty Bunch',
        //             'plot5'     => 'Abnormal',
        //             'data'      => $LogPerhari
        //         ];
        //     }
        // }

        // dd($arrLogHariini);
        // dd($prctgeAll);
        $getDate = Carbon::parse($tglData)->locale('id');
        $getDate->settings(['formatFunction' => 'translatedFormat']);
        // dd($getDate);

        // dd($prctgeAll[1]);
        return view('dashboard', [
            'arrLogHariini' => $arrLogHariini,
            'prctgeAll' => $prctgeAll,
            'dateToday' => $getDate->format('l, j F Y'),
            'totalAll' => number_format($totalAll, 0, ".", "."),
            'jamNow' => Carbon::now()->format('H:i:s'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    #Insert count grading FFB Baru
    /**
     * @OA\Post(
     *      path="/api/insert_count/{ripe}/{unripe}/{overripe}/{abnormal}/{empty_bunch}",
     *      tags={"Jumlah Jenis Janjang"},
     *      summary="Insert jumlah jenis janjang ke table database",
     *      description="Insert jumlah jenis janjang ke table database",
     *  @OA\Parameter(
     *          name="ripe",
     *          description="ripe",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *          )
     *      ),
     *    @OA\Parameter(
     *          name="unripe",
     *          description="unripe",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *          )
     *      ),
     *    @OA\Parameter(
     *          name="overripe",
     *          description="overripe",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *          )
     *      ),
     *    @OA\Parameter(
     *          name="abnormal",
     *          description="abnormal",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *          )
     *      ),
     *    @OA\Parameter(
     *          name="empty_bunch",
     *          description="empty_bunch",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *          )
     *      ),
     *   @OA\Parameter(
     *          name="datetime",
     *          description="datetime",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *              format="date-time",
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */

    public function grafik(Request $request)
    {
        $dateToday = Carbon::now()->format('Y-m-d');
        $tglData = $request->has('tgl') ? $request->input('tgl') : $defaultHari = $dateToday;

        $LogPerHariView = [
            'plot1'     => 'Unripe',
            'plot2'     => 'Ripe',
            'plot3'     => 'Overripe',
            'plot4'     => 'Empty Bunch',
            'plot5'     => 'Abnormal',
            'data'      => ''
        ];
        $arrLogPerhari = array();
        $dataArr = array();
        $arrJam = ['07:00', '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00', '23:00', '00:00', '01:00', '02:00', '03:00', '04:00', '05:00', '06:00'];
        // for ($i = 0; $i < 24; $i++) {
        //     $dataArr[$i]['timestamp'] = $arrJam[$i];
        //     $dataArr[$i]['harianUnripe'] = 0;
        //     $dataArr[$i]['harianRipe'] = 0;
        //     $dataArr[$i]['harianOverripe'] = 0;
        //     $dataArr[$i]['harianEmptyBunch'] = 0;
        //     $dataArr[$i]['harianAbnormal'] = 0;
        // }

        // dd($dataArr);
        $LogPerhari = '';

        // dd($prctgeAll);
        $nama_kategori_tbs = array('Unripe', 'Ripe', 'Overripe', 'Empty Bunch', 'Abnormal');
        $standar_mutu = array('0%', '>90%', '<5%', '0%', '<5%');

        $convert = new DateTime($tglData);
        // 
        // dd($convert);
        $convert->add(new DateInterval('PT7H'));

        // dd($convert);
        // $to = $convert->format('Y-m-d H:i:s');
        // dd($to);
        // $dateFrom = Carbon::parse($to)->subDays();

        $from = $convert->format('Y-m-d H:i:s');
        // dd($to);
        $dateTo = Carbon::parse($from)->addDays();

        // $dateFrom->add(new DateInterval('PT0H'));
        // dd($dateFrom);
        $dateTo = $dateTo->format('Y-m-d H:i:s');
        // $dateFrom = $dateFrom->format('Y-m-d H:i:s');
        $to = date($dateTo);
        // $from = date($dateFrom);
        // $prctgeAll = '';

        // $to = $convert->format('Y-m-d H:i:s');
        // dd($to);
        $logHariini      = '';
        $logHariini = DB::table('log')
            ->select('log.*',  DB::raw("DATE_FORMAT(log.timestamp,'%d-%H') as jam_ke"))
            ->whereBetween('log.timestamp', [$from, $to])
            ->orderBy('log.timestamp')
            ->get()
            ->groupBy('jam_ke');

        $increment = 0;

        if ($logHariini->first() != null) {
            foreach ($logHariini as $inc =>  $value) {
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

                    $jam = date('H', strtotime($data->timestamp)) . ':00';
                }

                $dataArr[$increment]['timestamp'] = $jam;
                $dataArr[$increment]['timestamp_full'] = $data->timestamp;
                $dataArr[$increment]['harianUnripe'] = $sumUnripe;
                $dataArr[$increment]['harianRipe'] = $sumRipe;
                $dataArr[$increment]['harianOverripe'] = $sumOverripe;
                $dataArr[$increment]['harianEmptyBunch'] = $sumEmptyBunch;
                $dataArr[$increment]['harianAbnormal'] = $sumAbnormal;

                $increment++;
            }
        };

        // dd($dataArr);


        for ($i = 0; $i < 24; $i++) {
            $arrLogPerhari[$i]['timestamp'] = $arrJam[$i];
            $arrLogPerhari[$i]['harianUnripe'] = 0;
            $arrLogPerhari[$i]['harianRipe'] = 0;
            $arrLogPerhari[$i]['harianOverripe'] = 0;
            $arrLogPerhari[$i]['harianEmptyBunch'] = 0;
            $arrLogPerhari[$i]['harianAbnormal'] = 0;
            for ($j = 0; $j < count($dataArr); $j++) {
                if ($arrJam[$i] == $dataArr[$j]['timestamp']) {
                    $arrLogPerhari[$i]['timestamp'] = $arrJam[$i];
                    $arrLogPerhari[$i]['harianUnripe'] = $dataArr[$j]['harianUnripe'];
                    $arrLogPerhari[$i]['harianRipe'] = $dataArr[$j]['harianRipe'];
                    $arrLogPerhari[$i]['harianOverripe'] = $dataArr[$j]['harianOverripe'];
                    $arrLogPerhari[$i]['harianEmptyBunch'] = $dataArr[$j]['harianEmptyBunch'];
                    $arrLogPerhari[$i]['harianAbnormal'] = $dataArr[$j]['harianAbnormal'];
                }
            }
        }
        // sort($arrLogPerhari);
        // dd($arrLogPerhari);

        // $arrLogPerhari = json_decode(json_encode($arrLogPerhari), true);
        foreach ($arrLogPerhari as $value) {

            //Perhari
            $jam        = $value['timestamp'];
            $LogPerhari .=
                "[{v:'" . $jam . "'}, {v:" . $value['harianUnripe'] . ", f:'" . $value['harianUnripe'] . " buah'},
                    {v:" . $value['harianRipe'] . ", f:'" . $value['harianRipe'] . " buah '},
                    {v:" . $value['harianOverripe'] . ", f:'" . $value['harianOverripe'] . " buah '},   
                    {v:" . $value['harianEmptyBunch'] . ", f:'" . $value['harianEmptyBunch'] . " buah '},     
                    {v:" . $value['harianAbnormal'] . ", f:'" . $value['harianAbnormal'] . " buah '}                             
                ],";
        }

        $LogPerHariView = [
            'plot1'     => 'Unripe',
            'plot2'     => 'Ripe',
            'plot3'     => 'Overripe',
            'plot4'     => 'Empty Bunch',
            'plot5'     => 'Abnormal',
            'data'      => $LogPerhari
        ];

        $LogMingguanView = [
            'plot1'     => 'Unripe',
            'plot2'     => 'Ripe',
            'plot3'     => 'Overripe',
            'plot4'     => 'Empty Bunch',
            'plot5'     => 'Abnormal',
            'data'      => ''
        ];
        //data mingguan 
        $logMingguan = DB::table('log')
            ->select('log.*')
            ->orderBy('log.timestamp', 'desc')
            ->where(DB::raw("(DATE_FORMAT(log.timestamp,'%Y-%m-%d'))"), '=',  Carbon::now()->format('Y-m-d'))
            ->first();


        // dd($logMingguan);
        $to = !is_null($logMingguan) ?  $logMingguan->timestamp : "27-04-2022";
        // dd($to);
        $convert = new DateTime($to . ' 23:59:59');
        // dd($convert);
        // dd($convert);
        $to = $convert->format('Y-m-d H:i:s');
        // dd($to);

        $dateParse = Carbon::parse($to)->subDays(7);
        $dateParse = $dateParse->format('Y-m-d');
        // dd($dateParse);
        $pastWeek = new DateTime($dateParse . ' 00:00:00');
        // $pastWeek = date($dateParse . ' 00:00:00');
        // dd($to);
        $pastWeek = $pastWeek->format('Y-m-d H:i:s');
        // dd($pastWeek);

        // dd($to);
        $logMingguan = DB::table('log')
            ->select('log.*',  DB::raw("DATE_FORMAT(log.timestamp,'%d-%m') as day_month"))
            ->whereBetween('log.timestamp', [$pastWeek, $to])
            ->orderBy('log.timestamp', 'asc')
            ->get()
            ->groupBy('day_month');

        // dd($logMingguan);


        for ($i = 0; $i < 8; $i++) {

            $hari = Carbon::parse($pastWeek)->addDays($i);

            $hari = Carbon::parse($hari)->locale('id');
            $hari->settings(['formatFunction' => 'translatedFormat']);
            $tgl = $hari->format('j F');
            $hari = $hari->format('l, j F');

            $arrLogPerminggu[$i]['hari'] = $tgl;
            $arrLogPerminggu[$i]['tanggal'] = $hari;
            $arrLogPerminggu[$i]['unripe'] = 0;
            $arrLogPerminggu[$i]['ripe'] = 0;
            $arrLogPerminggu[$i]['overripe'] = 0;
            $arrLogPerminggu[$i]['empty_bunch'] = 0;
            $arrLogPerminggu[$i]['abnormal'] = 0;
            $arrLogPerminggu[$i]['total'] = 0;
            $arrLogPerminggu[$i]['prctgUn'] = 0;
            $arrLogPerminggu[$i]['prctgRi'] = 0;
            $arrLogPerminggu[$i]['prctgOv'] = 0;
            $arrLogPerminggu[$i]['prctgEb'] = 0;
            $arrLogPerminggu[$i]['prctgAb'] = 0;
        }

        if (!$logMingguan->isEmpty()) {
            foreach ($logMingguan as $sub_array) {
                foreach ($sub_array as $data) {
                    $hari = Carbon::parse($data->timestamp)->locale('id');
                    $hari->settings(['formatFunction' => 'translatedFormat']);
                    $data->nameDay = $hari->format('j F');
                }
            }
            // dd($logMingguan);
            $arrLogSeminggu = array();

            $LogPerhari = '';

            $logMingguanJson = json_decode($logMingguan, true);
            foreach ($logMingguanJson as $index => $sub_array) {
                $sumAll = 0;
                $totalUnripeHarian = 0;
                $totalRipeHarian = 0;
                $totalOverripeHarian = 0;
                $totalEmptyBunchHarian = 0;
                $totalAbnormalHarian = 0;
                foreach ($sub_array as $data) {
                    $totalUnripeHarian += $data['unripe'];
                    $totalRipeHarian += $data['ripe'];
                    $totalOverripeHarian += $data['overripe'];
                    $totalEmptyBunchHarian += $data['empty_bunch'];
                    $totalAbnormalHarian += $data['abnormal'];

                    $sumAll = $totalUnripeHarian + $totalRipeHarian + $totalOverripeHarian + $totalEmptyBunchHarian + $totalAbnormalHarian;

                    $arrLogSeminggu[$index]['hari'] = $data['nameDay'];
                    $arrLogSeminggu[$index]['timestamp'] = $data['timestamp'];
                    $arrLogSeminggu[$index]['unripe'] = $totalUnripeHarian;
                    $arrLogSeminggu[$index]['ripe'] = $totalRipeHarian;
                    $arrLogSeminggu[$index]['overripe'] = $totalOverripeHarian;
                    $arrLogSeminggu[$index]['empty_bunch'] = $totalEmptyBunchHarian;
                    $arrLogSeminggu[$index]['abnormal'] = $totalAbnormalHarian;
                    $arrLogSeminggu[$index]['total'] = $sumAll;
                    $prctgUn = $totalUnripeHarian / $sumAll * 100;
                    $prctgRi = $totalRipeHarian / $sumAll * 100;
                    $prctgOv = $totalOverripeHarian / $sumAll * 100;
                    $prctgEb = $totalEmptyBunchHarian / $sumAll * 100;
                    $prctgAb = $totalAbnormalHarian / $sumAll * 100;
                    $arrLogSeminggu[$index]['prctgUn'] = round($prctgUn, 2);
                    $arrLogSeminggu[$index]['prctgRi'] = round($prctgRi, 2);
                    $arrLogSeminggu[$index]['prctgOv'] = round($prctgOv, 2);
                    $arrLogSeminggu[$index]['prctgEb'] = round($prctgEb, 2);
                    $arrLogSeminggu[$index]['prctgAb'] = round($prctgAb, 2);
                }
            }

            // dd($arrLogSeminggu);
            for ($i = 0; $i < 8; $i++) {

                $hari = Carbon::parse($pastWeek)->addDays($i);

                $hari = Carbon::parse($hari)->locale('id');
                $hari->settings(['formatFunction' => 'translatedFormat']);
                $tgl = $hari->format('j F');
                $hari = $hari->format('l, j F');


                // $arrLogPerminggu[$i]['hari'] = $tgl->format('D d M');
                $arrLogPerminggu[$i]['hari'] = $tgl;
                $arrLogPerminggu[$i]['tanggal'] = $hari;
                $arrLogPerminggu[$i]['unripe'] = 0;
                $arrLogPerminggu[$i]['ripe'] = 0;
                $arrLogPerminggu[$i]['overripe'] = 0;
                $arrLogPerminggu[$i]['empty_bunch'] = 0;
                $arrLogPerminggu[$i]['abnormal'] = 0;
                $arrLogPerminggu[$i]['total'] = 0;
                $arrLogPerminggu[$i]['prctgUn'] = 0;
                $arrLogPerminggu[$i]['prctgRi'] = 0;
                $arrLogPerminggu[$i]['prctgOv'] = 0;
                $arrLogPerminggu[$i]['prctgEb'] = 0;
                $arrLogPerminggu[$i]['prctgAb'] = 0;
                $sumAll = 0;
                $totalUnripeHarian = 0;
                $totalRipeHarian = 0;
                $totalOverripeHarian = 0;
                $totalEmptyBunchHarian = 0;
                $totalAbnormalHarian = 0;
                // dd($arrLogSeminggu);

                foreach ($arrLogSeminggu as $key => $data) {

                    if ($tgl == $data['hari']) {
                        $totalUnripeHarian += $data['unripe'];
                        $totalRipeHarian += $data['ripe'];
                        $totalOverripeHarian += $data['overripe'];
                        $totalEmptyBunchHarian += $data['empty_bunch'];
                        $totalAbnormalHarian += $data['abnormal'];

                        $sumAll = $totalUnripeHarian + $totalRipeHarian + $totalOverripeHarian + $totalEmptyBunchHarian + $totalAbnormalHarian;

                        $arrLogPerminggu[$i]['timestamp'] = $data['timestamp'];
                        $arrLogPerminggu[$i]['unripe'] = $totalUnripeHarian;
                        $arrLogPerminggu[$i]['ripe'] = $totalRipeHarian;
                        $arrLogPerminggu[$i]['overripe'] = $totalOverripeHarian;
                        $arrLogPerminggu[$i]['empty_bunch'] = $totalEmptyBunchHarian;
                        $arrLogPerminggu[$i]['abnormal'] = $totalAbnormalHarian;
                        $arrLogPerminggu[$i]['total'] = $sumAll;
                        $prctgUn = $totalUnripeHarian / $sumAll * 100;
                        $prctgRi = $totalRipeHarian / $sumAll * 100;
                        $prctgOv = $totalOverripeHarian / $sumAll * 100;
                        $prctgEb = $totalEmptyBunchHarian / $sumAll * 100;
                        $prctgAb = $totalAbnormalHarian / $sumAll * 100;
                        $arrLogPerminggu[$i]['prctgUn'] = round($prctgUn, 2);
                        $arrLogPerminggu[$i]['prctgRi'] = round($prctgRi, 2);
                        $arrLogPerminggu[$i]['prctgOv'] = round($prctgOv, 2);
                        $arrLogPerminggu[$i]['prctgEb'] = round($prctgEb, 2);
                        $arrLogPerminggu[$i]['prctgAb'] = round($prctgAb, 2);
                    }
                }
            }

            // dd($arrLogPerminggu);
            //ubah skema array per minggu menjadi ploting pada grafik
            foreach ($arrLogPerminggu as $value) {

                //Perhari

                $jam        = $value['hari'];
                $LogPerhari .=
                    "[{v:'" . $jam . "\\n " . number_format(round($value['total'], 2), 0, ".", ".") . " buah'}, {v:" . $value['unripe'] . ", f:'" . $value['unripe'] . " (" . $value['prctgUn'] . "%)'},'" . $jam . "\\n Unripe :" . number_format(round($value['unripe'], 2), 0, ".", ".") . " buah (" . $value['prctgUn'] . "%)',
                    {v:" .  $value['ripe'] . ", f:'" . $value['ripe'] . " (" . $value['prctgRi'] . "%)'},'" . $jam . " \\n Ripe:  " . number_format(round($value['ripe'], 2), 0, ".", ".")  . " buah (" . $value['prctgRi'] . "%)',
                    {v:" . $value['overripe'] . ", f:'" . $value['overripe'] . " (" . $value['prctgOv'] . "%)'},   '" . $jam . "\\n Overripe:  " . number_format(round($value['overripe'], 2), 0, ".", ".") . " buah (" . $value['prctgOv'] . "%)',
                    {v:" . $value['empty_bunch'] . ", f:'" . $value['empty_bunch'] . " (" . $value['prctgEb'] . "%)'},     '" . $jam . "\\n Empty Bunch:  " . number_format(round($value['empty_bunch'], 2), 0, ".", ".") . " buah(" . $value['prctgEb'] . "%)',
                    {v:" . $value['abnormal'] . ", f:'" . $value['abnormal'] . " (" . $value['prctgAb'] . "%)'},  '" . $jam . "\\n Abnormal:  " . number_format(round($value['abnormal'], 2), 0, ".", ".") . " buah (" . $value['prctgAb'] . "%)',
                ],";
            }

            // dd($LogPerhari);
            $LogMingguanView = [
                'plot1'     => 'Unripe',
                'plot2'     => 'Ripe',
                'plot3'     => 'Overripe',
                'plot4'     => 'Empty Bunch',
                'plot5'     => 'Abnormal',
                'data'      => $LogPerhari
            ];
        }

        // dd($arrLogPerminggu);
        $getDate = Carbon::parse($tglData)->locale('id');
        $getDate->settings(['formatFunction' => 'translatedFormat']);
        return view('grafik', [
            'LogPerHariView' => $LogPerHariView,
            'LogMingguanView' => $LogMingguanView,
            'arrLogMingguan' => $arrLogPerminggu,
            'dateToday' => $getDate->format('l, j F Y'),
            'nama_kategori_tbs' => $nama_kategori_tbs,
        ]);
    }

    public function export($hari)
    {
        // dd($hari);

        $filename = 'rekap-tbs-pks-skm-' . $hari . '-' . Carbon::now()->year . '.xlsx';

        // dd($filename);

        $dataLog = DB::table('log')
            ->select('log.*',  DB::raw("DATE_FORMAT(log.timestamp,'%d-%m') as hari"))
            ->orderBy('log.timestamp', 'DESC')
            ->get()
            ->groupBy('hari');

        // dd($dataLog[$hari][0]->id);
        $key = 1;
        foreach ($dataLog[$hari] as  $value) {
            $value->iterasi = $key;
            $key++;
        }

        // dd($dataLog[$hari]);

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
            $summary[$inc]['id'] = $count;
            $summary[$inc]['total'] = $sumUnripe + $sumRipe + $sumOverripe + $sumEmptyBunch + $sumAbnormal;
            $summary[$inc]['timestamp'] = Carbon::createFromFormat('Y-m-d H:i:s', $data->timestamp)->isoFormat('dddd, D MMMM Y');
            $summary[$inc]['harianUnripe'] = $sumUnripe;
            $summary[$inc]['harianRipe'] = $sumRipe;
            $summary[$inc]['harianOverripe'] = $sumOverripe;
            $summary[$inc]['harianEmptyBunch'] = $sumEmptyBunch;
            $summary[$inc]['harianAbnormal'] = $sumAbnormal;

            $count++;
        }

        // dd($dataLog[$hari]);

        return Excel::download(
            new LogExport($summary[$hari], $dataLog[$hari]),
            $filename
        );
    }

    public function pdf($hari)
    {
        $dataLog = DB::table('log')
            ->select('log.*',  DB::raw("DATE_FORMAT(log.timestamp,'%d-%m') as hari"))
            ->orderBy('log.timestamp', 'DESC')
            ->get()
            ->groupBy('hari');

        // dd($dataLog[$hari][0]->id);
        $key = 1;
        foreach ($dataLog[$hari] as  $value) {
            $value->iterasi = $key;
            $key++;
        }

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
            $summary[$inc]['id'] = $count;
            $summary[$inc]['total'] = $sumUnripe + $sumRipe + $sumOverripe + $sumEmptyBunch + $sumAbnormal;
            $summary[$inc]['timestamp'] = Carbon::createFromFormat('Y-m-d H:i:s', $data->timestamp)->isoFormat('dddd, D MMMM Y');
            $summary[$inc]['harianUnripe'] = $sumUnripe;
            $summary[$inc]['harianRipe'] = $sumRipe;
            $summary[$inc]['harianOverripe'] = $sumOverripe;
            $summary[$inc]['harianEmptyBunch'] = $sumEmptyBunch;
            $summary[$inc]['harianAbnormal'] = $sumAbnormal;
            $summary[$inc]['updated'] = Carbon::now()->isoFormat('HH:mm:ss');

            $count++;
        }

        $arrSum = $summary[$hari];
        $arrData = $dataLog[$hari];

        $filename = 'rekap-tbs-pks-skm-' . $hari . '-' . Carbon::now()->year . '.pdf';
        $pdf = Pdf::loadView('export.logPdf', ['summary' => $arrSum, 'data' => $arrData]);
        return $pdf->stream($filename, array("Attachment" => false))->header('Content-Type', 'application/pdf');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
