@include('layout.header')
<style>
    .google-visualization-tooltip-item {
        white-space: nowrap;
    }
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="col-12 col-lg-3">
            Pilih Tanggal Harian
            <form class="" action="{{ route('grafik') }}" method="get">
                <input class="form-control" type="date" name="tgl" onchange="this.form.submit()">
            </form>
        </div>
        <div class="container-fluid pt-2">
            <div class="row">
                <div class="col">
                    <!-- Curah Hujan -->
                    <div class="card card-red">
                        <div class="card-header" style="background-color: #02A452;color:white">
                            <div class=" card-title">
                                <i class="fas fa-water pr-2"></i>Grading realtime jumlah janjang masuk PKS Sungai Kuning
                                hari
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

                            {{-- @if ($LogPerHariView['data'] != '') --}}
                            <div class="chart" id="logHariini">
                            </div>
                            {{-- @else
                            Tidak ada data dalam 24 jam terakhir
                            @endif --}}

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
                        <div class="card-header" style="background-color: #02A452;color:white">
                            <div class=" card-title">
                                <i class="fas fa-water pr-2"></i>Grafik Total Hitung per kategori TBS dalam seminggu
                                ({{$arrLogMingguan[0]['hari']}} - {{$arrLogMingguan[7]['hari']}} )
                            </div>
                            <div class="float-right">
                                <div class="list-inline">
                                </div>
                            </div>

                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="col">

                                    {{-- @if ($LogMingguanView['data'] != '') --}}
                                    <div id="logMingguan">
                                    </div>
                                    {{-- @else --}}
                                    {{-- Tidak ada data satu minggu ini --}}
                                    {{-- @endif --}}
                                </div>

                            </div>
                        </div><!-- /.card-body -->

                        <div class="d-flex justify-content-center">
                            <div class="col-12 col-lg-10">
                                <p class="text-center font-italic">Rekap Tabel Chart
                                    ({{$arrLogMingguan[0]['hari']}} - {{$arrLogMingguan[7]['hari']}} ) </p>
                                <table id="myTable" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col"> </th>
                                            @foreach ($arrLogMingguan as $item)
                                            <th scope="col" style="text-align: center">{{$item['hari']}}
                                            </th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td>Unripe</td>
                                            @foreach ($arrLogMingguan as $item)
                                            <td>
                                                <div class="text-center">
                                                    @if ($item['unripe'] != 0)
                                                    @php
                                                    echo number_format(round($item['unripe'], 2), 0, ".", ".")
                                                    @endphp
                                                    <br>
                                                    <div class="font-weight-bold">
                                                        ({{$item['prctgUn']}}%)
                                                    </div>
                                                    @else
                                                    0
                                                    @endif
                                                </div>

                                            </td>
                                            @endforeach

                                        </tr>
                                        <tr>
                                            <td>Ripe</td>
                                            @foreach ($arrLogMingguan as $item)
                                            <td>

                                                <div class="text-center">
                                                    @if ($item['ripe'] != 0)
                                                    @php
                                                    echo number_format(round($item['ripe'], 2), 0, ".", ".")
                                                    @endphp
                                                    <br>
                                                    <div class="font-weight-bold">
                                                        ({{$item['prctgRi']}}%)
                                                    </div>
                                                    @else
                                                    0
                                                    @endif
                                                </div>
                                            </td>

                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td>Overripe</td>
                                            @foreach ($arrLogMingguan as $item)
                                            <td>
                                                <div class="text-center">
                                                    @if ($item['overripe'] != 0)
                                                    @php
                                                    echo number_format(round($item['overripe'], 2), 0, ".", ".")
                                                    @endphp
                                                    <br>
                                                    <div class="font-weight-bold">
                                                        ({{$item['prctgOv']}}%)
                                                    </div>
                                                    @else
                                                    0
                                                    @endif
                                                </div>
                                            </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td>Empty Bunch</td>
                                            @foreach ($arrLogMingguan as $item)
                                            <td>
                                                <div class="text-center">
                                                    @if ($item['empty_bunch'] != 0)
                                                    @php
                                                    echo number_format(round($item['empty_bunch'], 2), 0, ".", ".")
                                                    @endphp
                                                    <br>
                                                    <div class="font-weight-bold">
                                                        ({{$item['prctgEb']}}%)
                                                    </div>
                                                    @else
                                                    0
                                                    @endif
                                                </div>
                                            </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td>Abnormal</td>
                                            @foreach ($arrLogMingguan as $item)
                                            <td>
                                                <div class="text-center">
                                                    @if ($item['abnormal'] != 0)
                                                    @php
                                                    echo number_format(round($item['abnormal'], 2), 0, ".", ".")
                                                    @endphp
                                                    <br>
                                                    <div class="font-weight-bold">
                                                        ({{$item['prctgAb']}}%)
                                                    </div>
                                                    @else
                                                    0
                                                    @endif
                                                </div>
                                            </td>
                                            @endforeach
                                        </tr>
                                        <tr class="font-weight-bold ">
                                            <td>Total</td>
                                            <div>
                                                @foreach ($arrLogMingguan as $item)
                                                <td class="text-center">
                                                    @php
                                                    echo number_format(round($item['total'], 2), 0, ".", ".")
                                                    @endphp
                                                </td>
                                                @endforeach
                                            </div>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <br>
                            </div>

                        </div>
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


  $(document).ready( function () {
    $('#myTable').DataTable({
        'paging':false,
        "searching": false,
        "ordering": false,
        "bInfo": false,
    });
} );

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
        dataPerhari.addColumn({type: 'string', role: 'tooltip'});
        dataPerhari.addColumn('number', plot_perhari_ripe);
        dataPerhari.addColumn({type: 'string', role: 'tooltip'});
        dataPerhari.addColumn('number', plot_perhari_overripe);
        dataPerhari.addColumn({type: 'string', role: 'tooltip'});
        dataPerhari.addColumn('number', plot_perhari_emptybunch);
        dataPerhari.addColumn({type: 'string', role: 'tooltip'});
        dataPerhari.addColumn('number', plot_perhari_abnormal);
        dataPerhari.addColumn({type: 'string', role: 'tooltip'});
        // A column for custom tooltip content
        dataPerhari.addRows([
            <?php echo $LogMingguanView['data']; ?>
        ]);

        var options = {
            chartArea: {},
        theme: 'material',
        colors:['#001E3C', '#AB221D','#FF9800','#BE8C64','#4CAF50'],
        legend: { position: 'top',
        textStyle: {fontSize: 15}},
        hAxis: {
                //   title: 'Jam',
                  textStyle: {
                     color: 'black',
                     fontSize: 12,
                    //  bold: true
                  },
                  titleTextStyle: {
                     color: '#1a237e',
                     fontSize: 24,
                     bold: true
                  }
               }, 
        lineWidth: 2,
        height:400,
        isStacked:true,
          
        // height:400,
    };  
        var chart = new google.visualization.ColumnChart(document.getElementById('logMingguan'));
        chart.draw(dataPerhari, options);

        var plot_unripe = '<?php echo  $LogPerHariView['plot1']; ?>';
    var plot_ripe = '<?php echo   $LogPerHariView['plot2']; ?>';
    var plot_overripe = '<?php echo   $LogPerHariView['plot3']; ?>';
    var plot_empty_bunch = '<?php echo  $LogPerHariView['plot4']; ?>';
    var plot_abnormal = '<?php echo  $LogPerHariView['plot5']; ?>';
    
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
        hAxis: {
                //   title: 'Jam',
                  textStyle: {
                     color: 'black',
                     fontSize: 12,
                    //  bold: true
                  },
                  titleTextStyle: {
                     color: '#1a237e',
                     fontSize: 24,
                     bold: true
                  }
               }, 
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