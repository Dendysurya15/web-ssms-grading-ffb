@include('layout.header')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- Curah Hujan -->
                    <div class="card">
                        <div class="card-header" style="background-color: #02A452;color:white">
                            <div class=" card-title">
                                <i class="fas fa-chart-line pr-2"></i>Grafik Ripeness Harian Grading Ai Sungai Kuning
                            </div>
                        </div>
                        <div class="card-body mb-3">
                            <div class="row">
                                <div class="col">
                                    <div id="logAll">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm-5">
                                    <h2 class="m-2 ">
                                        Tabel Log TBS
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <div style="margin-left: auto; margin-right: auto;">
                                <table class="table table-bordered table-hover text-center" id="rekapWaterLevel">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th style="width:15%;">Total TBS Masuk</th>
                                            <th>OER Harian</th>
                                            <th style="width:15%;">Ripeness</th>
                                            <th>Unripe</th>
                                            <th>Overripe</th>
                                            <th>Empty Bunch</th>
                                            <th>Abnormal</th>
                                            <th>Unduh</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
@include('layout.footer')

<!-- jQuery -->
{{-- <script src="{{ asset('/public/plugins/jquery/jquery.min.js') }}"></script> --}}
<!-- Bootstrap 4 -->
<script src="{{ asset('/public/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('/public/plufgins/chart.js/Chart.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/public/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('/public/js/demo.js') }}"></script>

<script src="{{ asset('/public/js/loader.js') }}"></script>

<script type="text/javascript">
    var judul = 'DATA LOG GRADING AI';
    $(function() {
        $('#rekapWaterLevel').DataTable({
            "searching": true,
            "pageLength": 10,
            "columnDefs": [
    { "width": "10%", "targets": 8 },
    { "width": "15%", "targets": 1 },
    { "width": "10%", "targets": 3 }
  ],
            processing: true,
            serverSide: true,
            ajax: "{{ route('data') }}",
            columns: [
            { data: 'id', name: 'id' },
            { data: 'timestamp', name: 'timestamp' },
            { data: 'total', name: 'total' },
            { data: 'oer', name: 'oer' },
            { data: 'harianRipe', name: 'harianRipe' },
            { data: 'harianUnripe', name: 'harianUnripe' },
            { data: 'harianOverripe', name: 'harianOverripe' },
            { data: 'harianEmptyBunch', name: 'empty_bunch' },
            { data: 'harianAbnormal', name: 'harianAbnormal' },
            { data: 'action', name: 'action' },
        ],
        
        });
    });

    google.charts.load('current', {
    'packages': ['corechart']
  });
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {  
    
    
    var plot_ripe = '<?php echo $logPerhariView['plot2']; ?>';
    
    var dataLogAll = new google.visualization.DataTable();
    dataLogAll.addColumn('string', 'Name');
    dataLogAll.addColumn('number', plot_ripe);
    dataLogAll.addRows([
      <?php echo $logPerhariView['data']; ?>
    ]);

    var optionsLogHariIIni = {
        chartArea: {},
        theme: 'material',
        colors:[ '#4CAF50'],
        legend: { position: 'top',
        textStyle: {fontSize: 15}},
        lineWidth: 2,
        hAxis: {
           
    },
        height:250,
    };

    var log = new google.visualization.LineChart(document.getElementById('logAll'));
    log.draw(dataLogAll,optionsLogHariIIni);
  }
</script>