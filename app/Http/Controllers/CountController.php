<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function tabel()
    {
        $dataLog = DB::table('log')
            ->select('log.*')
            ->orderBy('log.timestamp', 'desc')
            ->get();
        $dataLog = json_decode($dataLog, true);

        // dd($dataLog[0]['unripe']);
        return view('tabel', ['dataLog' => $dataLog]);
    }

    public function dashboard()
    {
        $dateToday = Carbon::now()->format('D, d-m-Y');

        //get all data per hari
        $dataLog = DB::table('log')
            ->select('log.*', 'log.timestamp')
            ->orderBy('log.timestamp')
            ->where(DB::raw("(DATE_FORMAT(log.timestamp,'%Y-%m-%d'))"), '=', Carbon::now()->format('Y-m-d'));

        $allLog = DB::table('log')
            ->select('log.*', 'log.timestamp')
            ->orderBy('log.timestamp')
            ->where(DB::raw("(DATE_FORMAT(log.timestamp,'%Y-%m-%d'))"), '=', Carbon::now()->format('Y-m-d'))
            ->get();

        $countLog = $dataLog->count();

        $take = 4;
        $limit = $countLog - $take;
        $dataLog = $dataLog->skip($limit)->take($take)->get();

        $allLogJson = json_decode($allLog, true);

        $totalUnripe = 0;
        $totalRipe = 0;
        $totalOverripe = 0;
        $totalEmptyBunch = 0;
        $totalAbnormal = 0;

        $test = 0;

        foreach ($allLogJson as $index => $data) {
            $totalUnripe += $data['unripe'];
            $totalRipe += $data['ripe'];
            $totalOverripe += $data['overripe'];
            $totalEmptyBunch += $data['empty_bunch'];
            $totalAbnormal += $data['abnormal'];
        }

        $logHariini      = '';

        $arrLogHariini = [
            'plot1'     => '',
            'plot2'     => '',
            'plot3'     => '',
            'plot4'     => '',
            'plot5'     => '',
            'data'      => ''
        ];

        if (!$dataLog->isEmpty()) {
            $dataLogHariIni = json_decode(json_encode($dataLog), true);
            foreach ($dataLogHariIni as $value) {

                //Perhari
                $jam        = date('H:i:s', strtotime($value['timestamp']));
                $logHariini .=
                    "[{v:'" . $jam . "'}, {v:" . $value['unripe'] . ", f:'" . $value['unripe'] . "'},
                    {v:" . $value['ripe'] . ", f:'" . $value['ripe'] . "'},
                    {v:" . $value['overripe'] . ", f:'" . $value['overripe'] . "'},   
                    {v:" . $value['empty_bunch'] . ", f:'" . $value['empty_bunch'] . "'},     
                    {v:" . $value['abnormal'] . ", f:'" . $value['abnormal'] . "'}                             
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

            // dd($logHariini);
            return view('dashboard', [
                'arrLogHariini' => $arrLogHariini,
                'dateToday' => $dateToday,
                'totalUnripe' => $totalUnripe,
                'totalRipe' => $totalRipe,
                'totalOverripe' => $totalOverripe,
                'totalEmptyBunch' => $totalEmptyBunch,
                'totalAbnormal' => $totalAbnormal
            ]);
        } else {
            return view('dashboard',  [
                'arrLogHariini' => $arrLogHariini,
                'dateToday' => $dateToday,
                'msg' => 'Tidak ada Log  hari ini',
                'totalUnripe' => $totalUnripe,
                'totalRipe' => $totalRipe,
                'totalOverripe' => $totalOverripe,
                'totalEmptyBunch' => $totalEmptyBunch,
                'totalAbnormal' => $totalAbnormal
            ]);
        }
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
        $dateToday = Carbon::now()->format('D, d-m-Y');

        // dd(Carbon::now()->format('d-m-Y'));
        //get all data per hari
        $dataLog = DB::table('log')
            ->select('log.*', 'log.timestamp')
            ->orderBy('log.timestamp')
            ->where(DB::raw("(DATE_FORMAT(log.timestamp,'%Y-%m-%d'))"), '=', Carbon::now()->format('Y-m-d'))
            ->get();

        // $listLoc = DB::table('water_level_list')->pluck('location');

        // dd($dataLog);

        $logHariini      = '';
        $LogHarianView = '';

        $arrLogHariini = [
            'plot1'     => '',
            'plot2'     => '',
            'plot3'     => '',
            'plot4'     => '',
            'plot5'     => '',
            'data'      => ''
        ];

        if (!$dataLog->isEmpty()) {
            $dataLogHariIni = json_decode(json_encode($dataLog), true);
            foreach ($dataLogHariIni as $value) {

                //Perhari
                $jam        = date('H:i:s', strtotime($value['timestamp']));
                $logHariini .=
                    "[{v:'" . $jam . "'}, {v:" . $value['unripe'] . ", f:'" . $value['unripe'] . "'},
                    {v:" . $value['ripe'] . ", f:'" . $value['ripe'] . "'},
                    {v:" . $value['overripe'] . ", f:'" . $value['overripe'] . "'},   
                    {v:" . $value['empty_bunch'] . ", f:'" . $value['empty_bunch'] . "'},     
                    {v:" . $value['abnormal'] . ", f:'" . $value['abnormal'] . "'}                             
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
        //data mingguan 

        $logMingguan = DB::table('log')
            ->select('log.*')
            ->orderBy('log.timestamp', 'desc')
            ->where(DB::raw("(DATE_FORMAT(log.timestamp,'%Y-%m-%d'))"), '=', Carbon::now()->format('Y-m-d'))
            ->first();

        // dd($logMingguan);

        $to = $logMingguan->timestamp;
        $convert = new DateTime($to);
        $to = $convert->format('Y-m-d H:i:s');

        $dateParse = Carbon::parse($to)->subDays(7);
        $dateParse = $dateParse->format('Y-m-d H:i:s');

        $pastWeek = date($dateParse);

        // dd($pastWeek);
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
            $arrLogPerhari = array();

            $LogPerhari = '';

            $logMingguanJson = json_decode($logMingguan, true);

            $totalUnripeHarian = 0;
            $totalRipeHarian = 0;
            $totalOverripeHarian = 0;
            $totalEmptyBunchHarian = 0;
            $totalAbnormalHarian = 0;

            foreach ($logMingguanJson as $index => $sub_array) {
                foreach ($sub_array as $data) {
                    $totalUnripeHarian += $data['unripe'];
                    $totalRipeHarian += $data['ripe'];
                    $totalOverripeHarian += $data['overripe'];
                    $totalEmptyBunchHarian += $data['empty_bunch'];
                    $totalAbnormalHarian += $data['abnormal'];

                    $arrLogPerhari[$index]['hari'] = $data['nameDay'];
                    $arrLogPerhari[$index]['timestamp'] = $data['timestamp'];
                    $arrLogPerhari[$index]['unripe'] = $totalUnripeHarian;
                    $arrLogPerhari[$index]['ripe'] = $totalRipeHarian;
                    $arrLogPerhari[$index]['overripe'] = $totalOverripeHarian;
                    $arrLogPerhari[$index]['empty_bunch'] = $totalEmptyBunchHarian;
                    $arrLogPerhari[$index]['abnormal'] = $totalAbnormalHarian;
                }
            }

            // dd($arrLogPerhari);
            //ubah skema array per minggu menjadi ploting pada grafik
            foreach ($arrLogPerhari as $value) {

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

            $LogHarianView = [
                'plot1'     => 'Unripe',
                'plot2'     => 'Ripe',
                'plot3'     => 'Overripe',
                'plot4'     => 'Empty Bunch',
                'plot5'     => 'Abnormal',
                'data'      => $LogPerhari
            ];


            return view('grafik', [
                'arrLogHariini' => $arrLogHariini,
                'LogHarianView' => $LogHarianView,
                'dateToday' => $dateToday,
            ]);
        } else {
            return view('grafik', ['arrLogHariini' => $arrLogHariini, 'LogHarianView' => $LogHarianView, 'dateToday' => $dateToday, 'msg' => 'Tidak ada Log  hari ini']);
        }
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
