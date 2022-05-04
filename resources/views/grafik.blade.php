@include('layout.header')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <!-- Curah Hujan -->
                    <div class="card card-red">
                        <div class="card-header">
                            <div class=" card-title">
                                <i class="fas fa-water pr-2"></i>Grading TBS dalam 24 jam terakhir
                                {{$dateToday}}
                            </div>
                            <div class="float-right">
                                <div class="list-inline">
                                    {{-- <h5 class="list-inline-item">Lokasi</h5> --}}
                                    {{-- <form class="list-inline-item col-md-5"
                                        action="{{ route('water_level_grafik') }}" method="get">
                                        <select name="id" class="form-control-sm" onchange="this.form.submit()">
                                            <option value="" selected disabled>Pilih Lokasi</option>
                                            @foreach ($listLoc as $key => $list)
                                            <option value="{{$key}}">{{$list}}</option>
                                            @endforeach
                                        </select>
                                    </form> --}}
                                </div>
                            </div>

                        </div>
                        <div class="card-body">

                            @if ($LogPerHariView['data'] != '')
                            <div class="chart" id="logHariini">
                            </div>
                            @else
                            Tidak ada data dalam 24 jam terakhir
                            @endif

                        </div><!-- /.card-body -->
                    </div><!-- Curah Hujan -->


                    <!-- Curah Hujan -->
                    {{-- <div class="card card-cyan"> --}}
                        {{-- <div class="card-header"> --}}
                            {{-- <h3 class="card-title"> --}}

                                {{-- </h3> --}}
                            {{-- <div class="float-right"> --}}
                                {{-- <div class="list-inline">
                                    <h5 class="list-inline-item">Lokasi</h5>
                                    <form class="list-inline-item col-md-5" action="{{ route('water_level_grafik') }}"
                                        method="get">
                                        <select name="id" class="form-control-sm" onchange="this.form.submit()">
                                            <option value="" selected disabled>Pilih Lokasi</option>
                                            @foreach ($listLoc as $key => $list)
                                            <option value="{{$key}}">{{$list}}</option>
                                            @endforeach
                                        </select>
                                    </form>
                                </div> --}}
                                {{-- </div> --}}
                            {{-- </div> --}}
                        {{-- <div class="card-body">
                            <div class="chart" id="awsPerMinggu">
                            </div>
                        </div><!-- /.card-body --> --}}
                        {{-- </div><!-- Curah Hujan --> --}}

                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <!-- Curah Hujan -->
                    <div class="card">
                        <div class="card-header" style="background-color: #013C5E;color:white">
                            <div class=" card-title">
                                <i class="fas fa-water pr-2"></i>Grafik Total Hitung per kategori TBS dalam seminggu
                            </div>
                            <div class="float-right">
                                <div class="list-inline">
                                </div>
                            </div>

                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col">

                                    @if ($LogMingguanView['data'] != '')
                                    <div id="logMingguan">
                                    </div>
                                    @else
                                    Tidak ada data satu minggu ini
                                    @endif
                                </div>

                            </div>
                        </div><!-- /.card-body -->
                    </div><!-- Curah Hujan -->


                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
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
     //perminggu
     var plot_perhari_unripe = '<?php echo $LogMingguanView['plot1']; ?>';
    var plot_perhari_ripe = '<?php echo $LogMingguanView['plot2']; ?>';
    var plot_perhari_overripe = '<?php echo $LogMingguanView['plot3']; ?>';
    var plot_perhari_emptybunch = '<?php echo $LogMingguanView['plot4']; ?>';
    var plot_perhari_abnormal = '<?php echo $LogMingguanView['plot5']; ?>';

    var dataPerhari = new google.visualization.DataTable();
    dataPerhari.addColumn('string', 'Name');
    dataPerhari.addColumn('number', plot_perhari_unripe);
    dataPerhari.addColumn('number', plot_perhari_ripe);
    dataPerhari.addColumn('number', plot_perhari_overripe);
    dataPerhari.addColumn('number', plot_perhari_emptybunch);
    dataPerhari.addColumn('number', plot_perhari_abnormal);
    dataPerhari.addRows([
      <?php echo $LogMingguanView['data']; ?>
    ]);

    var optionsLogPerhari = {
        chartArea: {},
      theme: 'material',
        colors:['#001E3C', '#AB221D','#FF9800','#BE8C64','#4CAF50'],
        legend: { position: 'top',
        textStyle: {fontSize: 15}},
        lineWidth: 2,
        height:400,
    };       
   
    var logHarianView = new google.visualization.ColumnChart(document.getElementById('logMingguan'));
    logHarianView.draw(dataPerhari,optionsLogPerhari); 
    
    var plot_unripe = '<?php  $LogPerHariView['plot1']; ?>';
    var plot_ripe = '<?php  $LogPerHariView['plot2']; ?>';
    var plot_overripe = '<?php  $LogPerHariView['plot3']; ?>';
    var plot_empty_bunch = '<?php  $LogPerHariView['plot4']; ?>';
    var plot_abnormal = '<?php  $LogPerHariView['plot5']; ?>';
    
    var dataLogHariini = new google.visualization.DataTable();
    dataLogHariini.addColumn('string', 'Name');
    dataLogHariini.addColumn('number', plot_unripe);
    dataLogHariini.addColumn('number', plot_ripe);
    dataLogHariini.addColumn('number', plot_overripe);
    dataLogHariini.addColumn('number', plot_empty_bunch);
    dataLogHariini.addColumn('number', plot_abnormal);
    dataLogHariini.addRows([
      <?php echo $LogPerHariView['data']; ?>
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
    arrLogHariini.draw(dataLogHariini,optionsLogHariIIni );

}
  $(window).resize(function() {
    drawStuff();
  });
</script>