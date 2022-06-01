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
                                            <th>Total TBS Harian</th>
                                            <th>Unripe</th>
                                            <th style="width:15%;">Ripe</th>
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
            "pageLength": 25,
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
            { data: 'harianUnripe', name: 'harianUnripe' },
            { data: 'harianRipe', name: 'harianRipe' },
            { data: 'harianOverripe', name: 'harianOverripe' },
            { data: 'harianEmptyBunch', name: 'empty_bunch' },
            { data: 'harianAbnormal', name: 'harianAbnormal' },
            { data: 'action', name: 'action' },
        ],
        
        });
    });
</script>