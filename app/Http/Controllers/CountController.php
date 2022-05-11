<?php

namespace App\Http\Controllers;

use App\Exports\LogExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
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

            $count++;
        }

        return DataTables::of($arrLogPerhari)
            ->editColumn('harianUnripe', function ($model) {
                return $model['harianUnripe'];
                // return '<span style="font-size:10px;">' . $model['harianUnripe'] . ' </span>';
            })
            ->addColumn('action', function ($model) {
                return '<a href="' . route('excel', $model['hari']) . '" class="btn btn-success" >  <i class="nav-icon fa fa-file-csv fa-xs"></i>    </a>' .
                    ' ' . '<a href="' . route('pdf', $model['hari']) . '" class="btn btn-danger" > <i class="nav-icon fa fa-file-pdf" fa-xs></i>   </a>';
            })
            ->make(true);
    }

    public function dashboard()
    {
        $dateToday = Carbon::now()->format('d-m-Y');
        $arrLogHariini = [
            'plot1'     => '',
            'plot2'     => '',
            'plot3'     => '',
            'plot4'     => '',
            'plot5'     => '',
            'data'      => ''
        ];

        $totalUnripe = 0;
        $totalRipe = 0;
        $totalOverripe = 0;
        $totalEmptyBunch = 0;
        $totalAbnormal = 0;
        $prctgeAll = array();

        $nama_kategori_tbs = array('Unripe', 'Ripe', 'Overripe', 'Empty Bunch', 'Abnormal');
        //get all data per hari
        $dataLog = DB::table('log')
            ->select('log.*', 'log.timestamp')
            ->orderBy('log.timestamp')
            ->where(DB::raw("(DATE_FORMAT(log.timestamp,'%Y-%m-%d'))"), '=', "2022-05-02");

        $allLog = DB::table('log')
            ->select('log.*', 'log.timestamp')
            ->orderBy('log.timestamp')
            ->where(DB::raw("(DATE_FORMAT(log.timestamp,'%Y-%m-%d'))"), '=', "2022-05-02")
            ->get();

        if ($dataLog->exists() && !is_null($allLog)) {

            $countLog = $dataLog->count();

            $take = 10;
            $limit = $countLog - $take;
            $dataLog = $dataLog->skip($limit)->take($take)->get();

            $allLogJson = json_decode($allLog, true);

            foreach ($allLogJson as $index => $data) {
                $totalUnripe += $data['unripe'];
                $totalRipe += $data['ripe'];
                $totalOverripe += $data['overripe'];
                $totalEmptyBunch += $data['empty_bunch'];
                $totalAbnormal += $data['abnormal'];
            }
            $totalAll = $totalUnripe + $totalRipe + $totalOverripe + $totalEmptyBunch + $totalAbnormal;
            $arrAllLog = array($totalUnripe, $totalRipe, $totalOverripe, $totalEmptyBunch, $totalAbnormal);

            // dd(count($arrAllLog));
            foreach ($arrAllLog as $index => $data) {
                $hasil = ($data / $totalAll) * 100;
                $prctgeAll[$index]['kategori'] = $nama_kategori_tbs[$index];
                $prctgeAll[$index]['total'] = $data;
                $prctgeAll[$index]['persentase'] = round($hasil, 2);
            }

            // dd($prctgeAll[0]['kategori']);

            $logHariini      = '';

            if (!$dataLog->isEmpty()) {
                $dataLogHariIni = json_decode(json_encode($dataLog), true);
                foreach ($dataLogHariIni as $value) {

                    //Perhari
                    $jam        = date('H:i:s', strtotime($value['timestamp']));
                    $logHariini .=
                        "[{v:'" . $jam . "'}, {v:" . $value['unripe'] . ", f:'" . $value['unripe'] . "'},
                        {v:" . $value['ripe'] . ", f:'" . $value['ripe'] . " buah'},
                        {v:" . $value['overripe'] . ", f:'" . $value['overripe'] . " buah'},   
                        {v:" . $value['empty_bunch'] . ", f:'" . $value['empty_bunch'] . " buah '},     
                        {v:" . $value['abnormal'] . ", f:'" . $value['abnormal'] . " buah '}                             
                    ],";
                }

                // dd($logHariini);

                $arrLogHariini = [
                    'plot1'     => 'Unripe',
                    'plot2'     => 'Ripe',
                    'plot3'     => 'Overripe',
                    'plot4'     => 'Empty Bunch',
                    'plot5'     => 'Abnormal',
                    'data'      => $logHariini
                ];
            }
        }

        // dd($logHariini);
        return view('dashboard', [
            'arrLogHariini' => $arrLogHariini,
            'prctgeAll' => $prctgeAll,
            'dateToday' => $dateToday,
            'totalUnripe' => $totalUnripe,
            'totalRipe' => $totalRipe,
            'totalOverripe' => $totalOverripe,
            'totalEmptyBunch' => $totalEmptyBunch,
            'totalAbnormal' => $totalAbnormal
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

    public function grafik()
    {
        $dateToday = Carbon::now()->format('d-m-Y');
        // dd($dateToday)

        $nama_kategori_tbs = array('Unripe', 'Ripe', 'Overripe', 'Empty Bunch', 'Abnormal');

        $convert = new DateTime(Carbon::now());

        // dd($convert);
        $to = $convert->format('Y-m-d H:i:s');

        $dateFrom = Carbon::parse($to)->subDays();
        $dateFrom = $dateFrom->format('Y-m-d H:i:s');

        $from = date($dateFrom);
        $to = $convert->format('Y-m-d H:i:s');

        // dd($to);

        $logHariini = DB::table('log')
            ->select('log.*',  DB::raw("DATE_FORMAT(log.timestamp,'%d-%H') as jam_ke"))
            ->whereBetween('log.timestamp', [$from, $to])
            ->orderBy('log.timestamp')
            ->get()
            ->groupBy('jam_ke');


        // dd($logHariini);
        $arrLogPerhari = array();

        $arrlogPerHariView = '';
        $LogPerHariView = [
            'plot1'     => 'Unripe',
            'plot2'     => 'Ripe',
            'plot3'     => 'Overripe',
            'plot4'     => 'Empty Bunch',
            'plot5'     => 'Abnormal',
            'data'      => ''
        ];

        // dd($logHariini);

        if (!$logHariini->isEmpty()) {

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
                }
                $arrLogPerhari[$inc]['timestamp'] = $data->timestamp;
                $arrLogPerhari[$inc]['harianUnripe'] = $sumUnripe;
                $arrLogPerhari[$inc]['harianRipe'] = $sumRipe;
                $arrLogPerhari[$inc]['harianOverripe'] = $sumOverripe;
                $arrLogPerhari[$inc]['harianEmptyBunch'] = $sumEmptyBunch;
                $arrLogPerhari[$inc]['harianAbnormal'] = $sumAbnormal;
            }

            // dd($arrLogPerhari);

            $arrLogPerhari = json_decode(json_encode($arrLogPerhari), true);
            foreach ($arrLogPerhari as $value) {

                //Perhari
                $jam        = date('H:i:s', strtotime($value['timestamp']));
                $arrlogPerHariView .=
                    "[{v:'" . $jam . "'}, {v:" . $value['harianUnripe'] . ", f:'" . $value['harianUnripe'] . "'},
                    {v:" . $value['harianRipe'] . ", f:'" . $value['harianRipe'] . "'},
                    {v:" . $value['harianOverripe'] . ", f:'" . $value['harianOverripe'] . "'},   
                    {v:" . $value['harianEmptyBunch'] . ", f:'" . $value['harianEmptyBunch'] . "'},     
                    {v:" . $value['harianAbnormal'] . ", f:'" . $value['harianAbnormal'] . "'}                             
                ],";
            }

            $LogPerHariView = [
                'plot1'     => 'Unripe',
                'plot2'     => 'Ripe',
                'plot3'     => 'Overripe',
                'plot4'     => 'Empty Bunch',
                'plot5'     => 'Abnormal',
                'data'      => $arrlogPerHariView
            ];
        }

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
            ->where(DB::raw("(DATE_FORMAT(log.timestamp,'%Y-%m-%d'))"), '=', Carbon::now()->format('Y-m-d'))
            ->first();

        $to = !is_null($logMingguan) ?  $logMingguan->timestamp : Carbon::now()->format('Y-m-d');

        // dd($to);
        $convert = new DateTime($to);
        // dd($convert);
        $to = $convert->format('Y-m-d H:i:s');

        $dateParse = Carbon::parse($to)->subDays(7);
        $dateParse = $dateParse->format('Y-m-d H:i:s');

        $pastWeek = date($dateParse);

        $logMingguan = DB::table('log')
            ->select('log.*',  DB::raw("DATE_FORMAT(log.timestamp,'%d-%m') as day_month"))
            ->whereBetween('log.timestamp', [$pastWeek, $to])
            ->orderBy('log.timestamp', 'asc')
            ->get()
            ->groupBy('day_month');

        // dd($logMingguan);

        if (!$logMingguan->isEmpty()) {
            foreach ($logMingguan as $sub_array) {
                foreach ($sub_array as $data) {
                    $data->nameDay = Carbon::parse($data->timestamp)->format('D d M');
                }
            }
            // dd($logMingguan);
            $arrLogSeminggu = array();

            $LogPerhari = '';

            $logMingguanJson = json_decode($logMingguan, true);

            foreach ($logMingguanJson as $index => $sub_array) {
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

                    $arrLogSeminggu[$index]['hari'] = $data['nameDay'];
                    $arrLogSeminggu[$index]['timestamp'] = $data['timestamp'];
                    $arrLogSeminggu[$index]['unripe'] = $totalUnripeHarian;
                    $arrLogSeminggu[$index]['ripe'] = $totalRipeHarian;
                    $arrLogSeminggu[$index]['overripe'] = $totalOverripeHarian;
                    $arrLogSeminggu[$index]['empty_bunch'] = $totalEmptyBunchHarian;
                    $arrLogSeminggu[$index]['abnormal'] = $totalAbnormalHarian;
                }
            }

            // dd($arrLogSeminggu);
            //ubah skema array per minggu menjadi ploting pada grafik
            foreach ($arrLogSeminggu as $value) {

                //Perhari

                $jam        = $value['hari'];
                $LogPerhari .=
                    "[{v:'" . $jam . "'}, {v:" . $value['unripe'] . ", f:'" . $value['unripe'] . "'},
                    {v:" . $value['ripe'] . ", f:'" . $value['ripe'] . "'},
                    {v:" . $value['overripe'] . ", f:'" . $value['overripe'] . "'},   
                    {v:" . $value['empty_bunch'] . ", f:'" . $value['empty_bunch'] . "'},     
                    {v:" . $value['abnormal'] . ", f:'" . $value['abnormal'] . "'}                             
                ],";
            }

            $LogMingguanView = [
                'plot1'     => 'Unripe',
                'plot2'     => 'Ripe',
                'plot3'     => 'Overripe',
                'plot4'     => 'Empty Bunch',
                'plot5'     => 'Abnormal',
                'data'      => $LogPerhari
            ];

            // dd($LogMingguanView);
            return view('grafik', [
                'LogPerHariView' => $LogPerHariView,
                'LogMingguanView' => $LogMingguanView,
                'dateToday' => $dateToday,
                'nama_kategori_tbs' => $nama_kategori_tbs,
            ]);
        }
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

        $filename = 'rekap-tbs-pks-skm-' . $hari . '-' . Carbon::now()->year . '.pdf';

        $pdf = Pdf::loadView('export.logPdf', ['summary' => $summary[$hari], 'data' => $dataLog[$hari]]);
        $pdf->setPaper('A4', 'Potrait');
        return $pdf->stream($filename);
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
