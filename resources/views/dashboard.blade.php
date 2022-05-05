@include('layout.header')
{{-- <style>
    .content {
        font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif
    }
</style> --}}
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-lg-6">
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

                    <div style="color: #013C5E">
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
                    </div>

                </div>
                <div class="col-12 col-lg-6">
                    <div class="card">
                        <a href="https://www.google.com/maps/place/PKS+Sungai+Kuning%2FBatu+Kotam+(+CBI+)/@-2.3079174,111.4959546,764m/data=!3m2!1e3!4b1!4m5!3m4!1s0x2e089fddc54db897:0x9d08de2c7c2d1f61!8m2!3d-2.3079228!4d111.4981433"
                            target=”_blank”>
                            <img src="{{ asset('img/foto_udara_pks_skm.jpeg') }}" class="img-thumbnail"
                                alt="Responsive image">
                        </a>
                    </div>
                </div>
            </div>
            <hr>
            <p style="color:#013C5E"> Berdasarkan perhitungan menggunakan AI didapatkan ...</p>
            <div class="row">
                @foreach ($prctgeAll as $item)
                <div class="col">
                    <div class="card">
                        <div class="card-header" style="background-color:#013C5E;color:white">
                            <span class="font-weight-bold" style="font-size: 18px">{{$item['kategori']}}</span> <br>
                            <span style="font-size: 14px" class="font-italic">{{$dateToday}}</span> <br>
                        </div>
                        <div class="card-body">
                            <div>
                                <span style="font-size: 50px"> {{$item['total']}}</span> Buah
                            </div>
                            <div style="font-size: 30px">
                                ({{$item['persentase']}}%)
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class=" row">

                <div class="col-md-12">
                    <!-- Curah Hujan -->
                    <div class="card">
                        <div class="card-header" style="background-color: #02A452;color:white">
                            <div class=" card-title">
                                <i class="fas fa-chart-line pr-2"></i>Grafik Realtime Grading di
                                Conveyor PKS SKM per 5
                                menit,
                                {{$dateToday}}
                            </div>
                            <div class="float-right">
                                <div class="list-inline">
                                </div>
                            </div>

                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col">
                                    @if ($arrLogHariini['data'])
                                    <div id="logHariini" {{-- style="width: 100%; height: 300px;" --}}>
                                    </div>
                                    @else
                                    Tidak ada data yg dikirim
                                    @endif
                                </div>

                            </div>
                        </div><!-- /.card-body -->
                    </div><!-- Curah Hujan -->


                </div>
                {{-- <div class="col-md-6">
                    <div class="card">

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
    google.charts.load('current', {
    'packages': ['corechart']
  });
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {  
    
    var plot_unripe = '<?php echo $arrLogHariini['plot1']; ?>';
    var plot_ripe = '<?php echo $arrLogHariini['plot2']; ?>';
    var plot_overripe = '<?php echo $arrLogHariini['plot3']; ?>';
    var plot_empty_bunch = '<?php echo $arrLogHariini['plot4']; ?>';
    var plot_abnormal = '<?php echo $arrLogHariini['plot5']; ?>';
    
    var dataLogHariini = new google.visualization.DataTable();
    dataLogHariini.addColumn('string', '');
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
        height:400,
        
    };

    var arrLogHariini = new google.visualization.LineChart(document.getElementById('logHariini'));
    arrLogHariini.draw(dataLogHariini,optionsLogHariIIni);
   
  }

  $(window).resize(function() {
    drawStuff();
  });
</script>