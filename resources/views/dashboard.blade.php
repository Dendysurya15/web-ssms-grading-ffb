@include('layout.header')
<style>
    /* .content { */
    /* font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif; */
    /* font-size: 15px; */
    /* } */

    @media (max-width: 576px) {
        .totalFormat {
            /* background-color: lightblue; */
            font-size: 18px;
        }

        .stnd_mutu {
            font-size: 10px;
        }
    }

    .piechartClass {
        background: white;
        border-radius: 5px;
        /* border: 1px solid red; */
    }

    @media only screen and (min-width: 992px) {
        ... .stnd_mutu {
            font-size: 14px;
        }

        .totalFormat {
            font-size: 50px;
        }

        .persentase {
            font-size: 30px
        }

    }
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="col-12 col-lg-3">
            Pilih Tanggal
            <form class="" action="{{ route('dashboard') }}" method="get">
                <input class="form-control" type="date" name="tgl" onchange="this.form.submit()">
            </form>
        </div>
        <div class="container-fluid pt-2 pl-3 pr-3">
            <div class="row">
                {{-- <div class="col-12">
                    test
                </div>
                <div class="col-12">
                    test
                </div>
                <div class="col-12">
                    test
                </div> --}}
                <div class="col-12 col-lg-4 p-5  mb-2" style="background-color: white;border-radius: 5px">
                    <h2 style="color:#013C5E;font-weight: 550">Dashboard Grading TBS
                    </h2>
                    <p style="color:#013C5E;">Portal website ini digunakan untuk memonitoring data dari proses grading
                        dengan
                        bantuan <span style="font-style: italic;color: #4CAF50"> Aritifical Inteligence (AI)</span>
                        dengan perantara
                        kamera
                        CCTV yang terpasang di conveyor PKS Sungai
                        Kuning Mill.
                    </p>

                    {{-- <div style="color: #013C5E">
                        Standar Mutu Grading :
                        <ul>
                            <li>Unripe 0%</li>
                            <li>Ripe >= 90%</li>
                            <li>Overripe <=5% </li>
                            <li>Empty Bunch 0%</li>
                            <li>Abnormal <= 5%</li>
                        </ul>
                        <p style="font-style: italic;font-size: 14px" class="text-secondary">
                            Sumber : Standar Prosedur Analisa Mutu TBS (SOP-PKS.GN-010)
                        </p>
                    </div> --}}

                </div>
                <div class="col-12 col-lg-4 mb-2 piechartClass" id="boxPiechart">
                    <div style="">
                        <div id="piechart">
                        </div>
                    </div>
                    @if ($prctgeAll != '')
                    <div id="piechart" {{-- style="width: 100%; height: 300px;" --}}>
                    </div>
                    @else
                    Tidak ada data yg dikirim
                    @endif
                </div>

                <div class=" col-12 col-lg-4 mb-2" style="background-color:white;border-radius:5px">
                    <p class="pt-3 pl-3 pr-3 text-center" style=" color: #013C5E;
                    font-weight: 550;
                    position: absolute;
                    width: 100%">Foto
                        Udara PKS
                        Sungai
                        Kuning Mill
                    </p>
                    <div class="p-5" style="height: 100%;border-radius: 5px;background-color: white">
                        <a href="https://www.google.com/maps/place/PKS+Sungai+Kuning%2FBatu+Kotam+(+CBI+)/@-2.3079174,111.4959546,764m/data=!3m2!1e3!4b1!4m5!3m4!1s0x2e089fddc54db897:0x9d08de2c7c2d1f61!8m2!3d-2.3079228!4d111.4981433"
                            target=”_blank”>
                            <img src="{{ asset('img/foto_udara_pks_skm.jpeg') }}"
                                style="height: 100%;object-fit: cover;width: 100%;border-radius:5px">
                            {{-- akdsfj --}}
                        </a>
                    </div>
                </div>
            </div>
            <hr>
            <p style="color:#013C5E;font-size: 17px"> Update hasil grading TBS tanggal <span class="font-weight-bold">
                    {{$dateToday}} </span> pada pukul <span class="font-weight-bold"> {{$jamNow}} wib</span> dengan
                total TBS
                <span class="font-weight-bold"> {{$totalAll}}</span> buah
            </p>
            {{-- <div id style="border:1px solid red"> --}}
                <div class="row">

                    @foreach ($prctgeAll as $key => $item)
                    @if ($item['persentase'] <= $item['stnd_mutu']) <div class="col-6 col-xl ">
                        <div class="card">
                            <div class="card-header" style="background-color:#013C5E;color:white">
                                <span class="font-weight-bold" style="font-size: 18px">{{$item['kategori']}}</span> <br>
                                <span class="font-italic stnd_mutu">Standar Mutu :
                                    <span class="font-weight-normal"> {{$item['stnd_mutu']}} </span> Tbs</span> <br>
                            </div>
                            <div class="card-body">
                                <div>
                                    <span class="totalFormat"> {{$item['totalFormat']}}</span> Buah
                                </div>
                                <div class="persentase">
                                    ({{$item['persentase']}}%)
                                </div>
                            </div>
                        </div>
                </div>
                @else
                <div class="col-6 col-xl">
                    <div class="card">
                        <div class="card-header" style="background-color:#C92E26;color:white">
                            <span class="font-weight-bold" style="font-size: 18px">{{$item['kategori']}}</span> <br>
                            <span class="font-italic stnd_mutu">Standar Mutu :
                                <span class="font-weight-normal"> {{$item['stnd_mutu']}} </span> Tbs</span> <br>
                        </div>
                        <div class="card-body">
                            <div>
                                <span class="totalFormat"> {{$item['totalFormat']}}</span> Buah
                            </div>
                            <div class="persentase">
                                ({{$item['persentase']}}%)
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @endforeach
            </div>
            <hr>
            {{--
        </div> --}}

        <div class=" row">

            <div class="col-md-12">
                <!-- Curah Hujan -->
                <div class="card">
                    <div class="card-header" style="background-color: #013C5E;color:white">
                        <div class=" card-title">
                            <i class="fas fa-chart-line pr-2"></i>Grafik Realtime Grading di
                            Conveyor PKS SKM dalam 24 jam terakhir
                            {{$dateToday}} {{$jamNow}}
                        </div>
                        <div class="float-right">
                            <div class="list-inline">
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col">
                                {{-- @if ($arrLogHariini['data'] != '') --}}
                                <div id="logHariini" {{-- style="width: 100%; height: 300px;" --}}>
                                </div>
                                {{-- @else --}}
                                {{-- Tidak ada data yg dikirim --}}
                                {{-- @endif --}}
                            </div>

                        </div>
                    </div><!-- /.card-body -->
                </div><!-- Curah Hujan -->


            </div>
            {{-- <div class="col-md-6">
                <div class="card">
                    <div class="row"> --}}

                        {{-- <div class="col"> --}}

                            {{-- @if ($prctgeAll[0] != '') --}}

                            {{-- @else --}}
                            {{-- Tidak ada data yg dikirim --}}
                            {{-- @endif --}}
                            {{-- </div>

                    </div>
                </div>
            </div> --}}
        </div>

</div>
<!-- /.row -->
{{--
</div><!-- /.container-fluid --> --}}
</section>
<!-- /.content -->
</div>
@include('layout.footer')

<!-- jQuery -->
<script src="{{ asset('/public/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('/public/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('/public/plugins/chart.js/Chart.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/public/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('/public/js/demo.js') }}"></script>

<script src="{{ asset('/public/js/loader.js') }}"></script>


<script type="text/javascript">
    width = $(window).width();
    if(width > 700){
        // document.querySelector("#boxPiechart").remove('piechart');
        const div =  document.querySelector('#boxPiechart');
        div.classList.remove('piechartClass');
    };

    google.charts.load('current', {
    'packages': ['corechart']
  });
  google.charts.setOnLoadCallback(drawChart);
  google.charts.setOnLoadCallback(drawPie);

  function drawChart() {  
    
    var plot_unripe = '<?php echo $arrLogHariini['plot1']; ?>';
    var plot_ripe = '<?php echo $arrLogHariini['plot2']; ?>';
    var plot_overripe = '<?php echo $arrLogHariini['plot3']; ?>';
    var plot_empty_bunch = '<?php echo $arrLogHariini['plot4']; ?>';
    var plot_abnormal = '<?php echo $arrLogHariini['plot5']; ?>';
    
    var dataLogHariini = new google.visualization.DataTable();
    dataLogHariini.addColumn('string', 'Name');
    dataLogHariini.addColumn('number', plot_unripe);
    dataLogHariini.addColumn('number', plot_ripe);
    dataLogHariini.addColumn('number', plot_overripe);
    dataLogHariini.addColumn('number', plot_empty_bunch);
    dataLogHariini.addColumn('number', plot_abnormal);
    dataLogHariini.addRows([
      <?php echo $arrLogHariini['data']; ?>
    ]);

    var optionsLogHariIIni = {
        chartArea: {},
        theme: 'material',
        colors:['#001E3C', '#AB221D','#FF9800','#BE8C64','#4CAF50'],
        legend: { position: 'top',
        textStyle: {fontSize: 15}},
        lineWidth: 2,
        hAxis: {
           
    },
        height:400,
    };

    var test = new google.visualization.LineChart(document.getElementById('logHariini'));
    test.draw(dataLogHariini,optionsLogHariIIni);

  }

  function drawPie(){
    var unripe = '<?php echo  $prctgeAll[0]['total']; ?>';
    var ripe = '<?php echo   $prctgeAll[1]['total']; ?>';
    var overripe = '<?php echo   $prctgeAll[2]['total']; ?>';
    var empty_bunch = '<?php echo  $prctgeAll[3]['total']; ?>';
    var abnormal = '<?php echo  $prctgeAll[4]['total']; ?>';
    
    var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Unripe',     Number(unripe)],
          ['Ripe',      Number(ripe)] ,
          ['Overripe',  Number(overripe)],
          ['Empty Bunch', Number(empty_bunch)],
          ['Abnormal',    Number(abnormal)]
        ]);

        var options = {
            title: 'Persebaran TBS yang masuk ke PKS SKM dalam 24 jam terakhir <?php echo  $dateToday; ?>',
            titleTextStyle: {
                color: "#013C5E",               // color 'red' or '#cc00cc'
                fontName: "",    // 'Times New Roman'
                fontSize: 15,               // 12, 18
                bold: true,                 // true or false
                italic: false                // true of false
            },
          legend: 'bottom',
          colors:['#001E3C', '#AB221D','#FF9800','#BE8C64','#4CAF50'],
          height:400
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
  }
  
</script>