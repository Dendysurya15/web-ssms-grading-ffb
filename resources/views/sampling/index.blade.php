@include('layout.header')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    </section>


    <section class="content">
        <div class="card">
            <div class="card-body">
                FILTER
                <div class="row">
                    <div class="col-12 col-lg-3">
                        <label for="">Pilih Tanggal</label>
                        <form class="" action="" method="get">
                            {{ csrf_field() }}
                            <input class="form-control" type="date" name="tgl" id="inputDate"
                                onchange="updateButtonState()">
                        </form>

                    </div>
                    <div class="col-12 col-lg-3">
                        <label for="">Mill</label>
                        <select name="" id="list_mil" class="form-control">
                            @foreach ($list_mill as $key => $item)
                            <option value="{{$key}}">{{$item->mill}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-lg-3">
                        <label for="">No Plat</label>
                        <select name="" id="" class="form-control">
                            <option value="">askdjf</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-3">
                        <label for="">Reg</label>
                        <select name="" id="" class="form-control">

                            <option value="">dd</option>

                        </select>
                    </div>
                    <div class="col-12 col-lg-3">
                        <label for="">WIL</label>
                        <select name="" id="" class="form-control">
                            <option value="">askdjf</option>
                        </select>
                    </div>
                    <div class="col-12 col-lg-3">
                        <label for="">Driver</label>
                        <select name="" id="" class="form-control">
                            <option value="">askdjf</option>
                        </select>
                    </div>

                </div>
                <div class="row">
                    <div class="col-12 col-lg-3">
                        <label for="">EST</label>
                        <select name="" id="" class="form-control">
                            <option value="">askdjf</option>
                        </select>
                    </div>
                    <div class="col-12 col-lg-3">
                        <label for="">STATUS</label>
                        <select name="" id="" class="form-control">
                            <option value="">askdjf</option>
                        </select>
                    </div>
                    <div class="col-12 col-lg-3">
                        <label for="">|</label>
                        <form>
                            {{-- <input class="form-control" type="date" name="tgl" id="inputDate"
                                onchange="this.form.submit()"> --}}
                            <button class="btn btn-primary">Search</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center" id="rekapWaterLevel">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>TANGGAL</th>
                                <th>RIPENESS</th>
                                <th>JANJANG</th>
                                <th>RIPE</th>
                                <th>UNRIPE</th>
                                <th>OVERRIPE</th>
                                <th>EMPTY BUNCH</th>
                                <th>ABNORMAL</th>
                                <th>Kastrasi</th>
                                <th>TP</th>
                                <th>MILL</th>
                                <th>REG</th>
                                <th>WIL</th>
                                <th>EST</th>
                                <th>INTI</th>
                                <th>PLAT</th>
                                <th>DRIVER</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </section>

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
    $(function() {
        $('#rekapWaterLevel').DataTable({
            "searching": true,
            "pageLength": 10,
            "scrollX": true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('get_table') }}",
            columns: [
            { data: 'id', name: 'id' },
            { data: 'waktu_selesai', name: 'waktu_selesai' },
            { data: 'ripeness', name: 'ripeness' },
            { data: 'janjang', name: 'janjang' },
            { data: 'ripe', name: 'ripe' },
            { data: 'unripe', name: 'unripe' },
            { data: 'overripe', name: 'overripe' },
            { data: 'empty_bunch', name: 'empty_bunch' },
            { data: 'abnormal', name: 'abnormal' },
            { data: 'kastrasi', name: 'kastrasi' },
            { data: 'tp', name: 'tp' },
            { data: 'tp', name: 'tp' },
            { data: 'tp', name: 'tp' },
            { data: 'tp', name: 'tp' },
            { data: 'bisnis_unit', name: 'bisnis_unit' },
            { data: 'status', name: 'status' },
            { data: 'no_plat', name: 'no_plat' },
            { data: 'nama_driver', name: 'nama_driver' },

        ],
        
        });
    });
    var filterDate = getCurrentDate(); // Initialize with today's date

function getCurrentDate() {
  // Get the current date and format it as 'Y-m-d'
  var currentDate = new Date();
  var year = currentDate.getFullYear();
  var month = String(currentDate.getMonth() + 1).padStart(2, '0'); // January is 0, so add 1 and pad with 0 if necessary
  var day = String(currentDate.getDate()).padStart(2, '0'); // Pad day with 0 if necessary
  return year + '-' + month + '-' + day;
}

function updateButtonState() {
  filterDate = $("#inputDate").val(); // Update the filterDate variable with the new value
  
  var _token = $('input[name="_token"]').val();
  $.ajax({
    url: "{{ route('filter_sampling') }}",
    method: "GET",
    data: {
      tgl: filterDate,
      _token: _token
    },
    success: function(result) {
      
    }
  });
}
       

</script>