@include('layout.header')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    <h2 style="color:#013C5E;font-weight: 550">Dashboard Grading Palm Oil
                    </h2>
                    <p style="color:#013C5E;">Portal website ini digunakan untuk memonitoring data dari prose grading
                        dengan
                        bantuan <span style="font-style: italic;color: #4CAF50"> Aritifical Inteligence (AI)</span>
                        dengan perantara
                        kamera
                        CCTV yang terpasang di conveyor PKS Sungai
                        Kuning Mill.
                    </p>
                    <hr>
                </div>
            </div>

            <p style="color:#013C5E"> Berdasarkan perhitungan menggunakan AI didapatkan ...</p>
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header" style="background-color:#013C5E;color:white">
                            <span class="font-weight-bold" style="font-size: 18px"> Total Unripe</span> <br>
                            <span style="font-size: 14px" class="font-italic">{{$dateToday}}</span> <br>
                        </div>
                        <div class="card-body">
                            <span style="font-size: 50px">{{$totalUnripe}}</span><span> buah</span>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-header" style="background-color:#013C5E;color:white">
                            <span class="font-weight-bold" style="font-size: 18px"> Total Ripe</span> <br>
                            <span style="font-size: 14px" class="font-italic">{{$dateToday}}</span> <br>
                        </div>
                        <div class="card-body">
                            <span style="font-size: 50px">{{$totalRipe}}</span><span> buah</span>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-header" style="background-color:#013C5E;color:white">
                            <span class="font-weight-bold" style="font-size: 18px"> Total Overripe</span> <br>
                            <span style="font-size: 14px" class="font-italic">{{$dateToday}}</span> <br>
                        </div>
                        <div class="card-body">
                            <span style="font-size: 50px">{{$totalOverripe}}</span><span> buah</span>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-header" style="background-color:#013C5E;color:white">
                            <span class="font-weight-bold" style="font-size: 18px"> Total Empty Bunch</span> <br>
                            <span style="font-size: 14px" class="font-italic">{{$dateToday}}</span> <br>
                        </div>
                        <div class="card-body">
                            <span style="font-size: 50px">{{$totalEmptyBunch}}</span><span> buah</span>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-header" style="background-color:#013C5E;color:white">
                            <span class="font-weight-bold" style="font-size: 18px"> Total Abnormal</span> <br>
                            <span style="font-size: 14px" class="font-italic">{{$dateToday}}</span> <br>
                        </div>
                        <div class="card-body">
                            <span style="font-size: 50px">{{$totalAbnormal}}</span><span> buah</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-md-12">
                    <!-- Curah Hujan -->
                    <div class="card">
                        <div class="card-header" style="background-color: #02A452;color:white">
                            <div class=" card-title">
                                <i class="fas fa-water pr-2"></i>Grafik Grading Palm Oil Hari ini
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
                                    <div id="logHariini">
                                    </div>
                                    @else
                                    @if(isset($msg))
                                    {{ $msg }}
                                    @endif
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
    
      theme: 'material',
        legend: {
            position: 'top',
      },
      colors:['#467184', '#2C8A84', '#F7941D', '#F46725', '#9C415F'],
      
    };

    var arrLogHariini = new google.visualization.ColumnChart(document.getElementById('logHariini'));
    arrLogHariini.draw(dataLogHariini,optionsLogHariIIni );
   
  }

  $(window).resize(function() {
    drawStuff();
  });
</script>