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
                                            <th>NO</th>
                                            <th>Tanggal</th>
                                            <th>Unripe</th>
                                            <th style="width:15%;">Ripe</th>
                                            <th>Overripe</th>
                                            <th>Empty Bunch</th>
                                            <th>Abnormal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($dataLog as $value)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <?php
                                                        $tanggal = date('H:i:s d-m-Y', strtotime($value->timestamp));
                                                        ?>
                                                {{ $tanggal }}
                                            </td>
                                            <td>{{$value->unripe}}</td>
                                            <td>{{ $value->ripe }}</td>
                                            <td>{{ $value->overripe }}</td>
                                            <td>{{ $value->empty_bunch }}</td>
                                            <td>{{ $value->abnormal }}</td>
                                        </tr>
                                        @endforeach
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
<script src="{{ asset('/public/plugins/jquery/jquery.min.js') }}"></script>
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
        });
    });
</script>