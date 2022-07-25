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
            font-size: 40px;
        }

        .dashboard_div {
            height: 590px;
        }

        .ffb_div {
            height: 590px;
        }

        .piechart_div {
            height: 590px;
        }

        .img_pks_skm {
            height: 200px;
        }

        .linechart_div {
            height: 400px;
        }
    }



    @media only screen and (min-width: 1366px) {
        .dashboard_div {
            height: 800px;
        }

        .ffb_div {
            height: 800px;
        }

        .piechart_div {
            height: 800px;
        }

        .img_pks_skm {
            height: 500px;
        }

        .linechart_div {
            height: 600px;
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
                <div class="col-12 col-lg-4 p-5 mb-2 dashboard_div" style="background-color: white;border-radius: 5px;">
                    <h2 style="color:#013C5E;font-weight: 550">Dashboard Grading TBS
                    </h2>
                    <p style="color:#013C5E;">Portal website ini digunakan untuk memonitoring data dari proses grading
                        dengan
                        bantuan <span style="font-style: italic;color: #4CAF50"> Aritifical Inteligence (AI)</span>
                        dengan perantara
                        kamera
                        CCTV yang terpasang di conveyor PKS Sungai
                        Kuning
                    </p>
                    <a href="https://www.google.com/maps/place/PKS+Sungai+Kuning%2FBatu+Kotam+(+CBI+)/@-2.3079174,111.4959546,764m/data=!3m2!1e3!4b1!4m5!3m4!1s0x2e089fddc54db897:0x9d08de2c7c2d1f61!8m2!3d-2.3079228!4d111.4981433"
                        target=”_blank”>
                        <img src="{{ asset('img/foto_udara_pks_skm.jpeg') }}" class="img_pks_skm"
                            style="object-fit: cover;width: 100%;border-radius:5px;">
                        {{-- akdsfj --}}
                    </a>
                    <p class="pt-3 font-italic text-center" style=" color: #013C5E;">Foto
                        Udara PKS
                        Sungai
                        Kuning Mill
                    </p>
                </div>
                <div class="col-12 col-lg-4 mb-2 piechartClass" id="boxPiechart">
                    <div style="">
                        <div id="piechart" class="piechart_div">
                        </div>
                    </div>
                </div>

                <div class="pt-3 font-italic col-12 col-lg-4 ffb_div"
                    style="color:#013C5E;background-color:white;border-radius:5px;">
                    <p class="text-center  font-weight-bold " style="margin-bottom:0px;"> Foto terbaru FFB di conveyor
                        PKS Sungai Kuning
                    </p>
                    <br>

                    <div style="display: flex;
                    align-items: center;
                    justify-content: center;">
                        <a href="{{ asset('/foto') }}">
                            <img src="{{ asset('img/ffb/'.$file[0]) }}" style="border-radius: 8px;
                            max-width: 100%;
                            max-height: 100%;">
                        </a>
                    </div>
                    <p class="text-center font-italic">Sampel foto FFB kualitas baik</p>


                    <div style="display: flex;
                    align-items: center;
                    justify-content: center;">
                        <a href="{{ asset('/foto') }}">
                            <img src="{{ asset('img/ffb/'.$file[1]) }}" style="border-radius: 8px;
                            max-width: 100%;
                            max-height: 100%;">
                        </a>
                    </div>
                    <p class="text-center font-italic">Sampel foto FFB kualitas rendah</p>

                </div>
            </div>


            <div>
                <hr>
                <p style="color:#013C5E;font-size: 17px"> Update hasil grading TBS berdasarkan AI pada hari <span
                        class="font-weight-bold">
                        {{$dateToday}} </span>
                    @if (!request()->has('tgl'))
                    hingga pukul <span class="font-weight-bold"> {{$jamNow}} wib</span>
                    @endif
                    dengan
                    total TBS
                    <span class="font-weight-bold"> {{$totalAll}}</span> buah
                </p>
                @if($prctgeAll[0]['totalAll'] != 0)

                {{-- <div id style="border:1px solid red"> --}}
                    <div class="row">
                        @foreach ($prctgeAll as $key => $item)
                        @if ($item['kategori'] == 'Unripe' && $item['persentase'] <= $item['stnd_mutu']) <div
                            class="col-6 col-xl ">
                            <div class="card">
                                <div class="card-header" style="background-color:#013C5E;color:white">
                                    <span class="font-weight-bold" style="font-size: 18px">{{$item['kategori']}}</span>
                                    <br>
                                    <span class="font-italic stnd_mutu">Standar Mutu :
                                        <span class="font-weight-normal"> {{$item['stnd_view']}} </span> Tbs</span> <br>
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

                    @elseif ($item['kategori'] == 'Ripe' && $item['persentase'] >= $item['stnd_mutu'])
                    <div class="col-6 col-xl ">
                        <div class="card">
                            <div class="card-header" style="background-color:#013C5E;color:white">
                                <span class="font-weight-bold" style="font-size: 18px">{{$item['kategori']}}</span> <br>
                                <span class="font-italic stnd_mutu">Standar Mutu :
                                    <span class="font-weight-normal"> {{$item['stnd_view']}} </span> Tbs</span> <br>
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

                    @elseif ($item['kategori'] == 'Overripe' && $item['persentase'] <=$item['stnd_mutu']) <div
                        class="col-6 col-xl ">
                        <div class="card">
                            <div class="card-header" style="background-color:#013C5E;color:white">
                                <span class="font-weight-bold" style="font-size: 18px">{{$item['kategori']}}</span> <br>
                                <span class="font-italic stnd_mutu">Standar Mutu :
                                    <span class="font-weight-normal"> {{$item['stnd_view']}} </span> Tbs</span> <br>
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
                @elseif ($item['kategori'] == 'Empty Bunch' && $item['persentase'] <= $item['stnd_mutu']) <div
                    class="col-6 col-xl ">
                    <div class="card">
                        <div class="card-header" style="background-color:#013C5E;color:white">
                            <span class="font-weight-bold" style="font-size: 18px">{{$item['kategori']}}</span> <br>
                            <span class="font-italic stnd_mutu">Standar Mutu :
                                <span class="font-weight-normal"> {{$item['stnd_view']}} </span> Tbs</span> <br>
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
            @elseif ($item['kategori'] == 'Abnormal' && $item['persentase'] <= $item['stnd_mutu']) <div
                class="col-6 col-xl ">
                <div class="card">
                    <div class="card-header" style="background-color:#013C5E;color:white">
                        <span class="font-weight-bold" style="font-size: 18px">{{$item['kategori']}}</span> <br>
                        <span class="font-italic stnd_mutu">Standar Mutu :
                            <span class="font-weight-normal"> {{$item['stnd_view']}} </span> Tbs</span> <br>
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
                        <span class="font-weight-normal"> {{$item['stnd_view']}} </span> Tbs</span> <br>
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
        @else
        <div class="pb-3">
            <div class="col-xl" style="background-color:white;border-radius:5px;">
                <div class="p-5 text-center">
                    <div style="width: 100%;height:200px;" id="no_data_grading"></div>
                    Tidak ada data yang masuk
                </div>
            </div>
        </div>
        @endif
</div>
</div>
{{--
</div> --}}
@if ($prctgeAll[0]['totalAll'] != 0)
<hr>
<div class="row">

    <div class="col-md-12">
        <!-- Curah Hujan -->
        <div class="card">
            <div class="card-header" style="background-color: #013C5E;color:white">
                <div class=" card-title">
                    <i class="fas fa-chart-line pr-2"></i>Grafik Realtime Jumlah Janjang masuk
                    PKS SKM pada hari
                    {{$dateToday}} pukul {{$jamNow}}
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
                        <div id="logHariini" class="linechart_div">
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
@endif

</div>
<!-- /.row -->
{{--
</div><!-- /.container-fluid --> --}}
</section>
<!-- /.content -->
</div>
@include('layout.footer')

{{-- <script src="{{ asset('lottie/93121-no-data-preview.json') }}" type="text/javascript"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.9.4/lottie.min.js"
    integrity="sha512-ilxj730331yM7NbrJAICVJcRmPFErDqQhXJcn+PLbkXdE031JJbcK87Wt4VbAK+YY6/67L+N8p7KdzGoaRjsTg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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



<script>
    bodymovin.loadAnimation({
    // animationData: { /* ... */ },
    container: document.getElementById('no-graph'), // required
    path: 'https://assets2.lottiefiles.com/packages/lf20_7be1jtxw.json', // required
    renderer: 'svg', // required
    loop: true, // optional
    autoplay: true, // optional
    name: "Demo Animation", // optional
  });

    var animation = bodymovin.loadAnimation({
    // animationData: { /* ... */ },
    container: document.getElementById('sampel_good'), // required
    path: 'https://assets8.lottiefiles.com/packages/lf20_exi9acin.json', // required
    renderer: 'svg', // required
    loop: true, // optional
    autoplay: true, // optional
    name: "Demo Animation", // optional
  });

  bodymovin.loadAnimation({
    // animationData: { /* ... */ },
    container: document.getElementById('sampel_bad'), // required
    path: 'https://assets8.lottiefiles.com/packages/lf20_exi9acin.json', // required
    renderer: 'svg', // required
    loop: true, // optional
    autoplay: true, // optional
    name: "Demo Animation", // optional
  });

  bodymovin.loadAnimation({
    // animationData: { /* ... */ },
    container: document.getElementById('no_data_grading'), // required
    path: 'https://assets7.lottiefiles.com/packages/lf20_n2m0isqh.json', // required
    renderer: 'svg', // required
    loop: true, // optional
    autoplay: true, // optional
    name: "Demo Animation", // optional
  });

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
        colors:[ '#AB221D','#4CAF50','#FF9800','#BE8C64','#001E3C'],
        legend: { position: 'top',
        textStyle: {fontSize: 15}},
        lineWidth: 2,
        hAxis: {
           
    },
        // height:400,
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
            title: 'Persebaran TBS yang masuk ke PKS Sungai Kuning pada <?php echo  $dateToday; ?>',
            titleTextStyle: {
                color: "#013C5E",               // color 'red' or '#cc00cc'
                fontName: "",    // 'Times New Roman'
                fontSize: 15,               // 12, 18
                bold: true,                 // true or false
                italic: false                // true of false
            },
          legend: {position:'bottom',maxLines: 1},
          colors:[ '#AB221D','#4CAF50','#FF9800','#BE8C64','#001E3C'],
        //   height:590
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
  }
  
</script>