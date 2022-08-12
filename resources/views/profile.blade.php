@include('layout.header')
<style>
    @media only screen and (min-width: 992px) {
        ... .stnd_mutu {
            font-size: 14px;
        }

        .totalFormat {
            font-size: 40px;
        }

        .dashboard_div {
            height: 450px;
        }

    }

    @media only screen and (min-width: 1366px) {
        .dashboard_div {
            height: 800px;
        }

    }
</style>
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid pt-2 pl-3 pr-3">
            <div class="row">
                <div class="col-12 col-lg-12 p-5 mb-2 " style="background-color: white;border-radius: 5px;">
                    <h2 style="color:#013C5E;font-weight: 550">Profile User
                    </h2>
                    <hr style="  border: 0;">
                    @if($errors->any())
                    <div id="boxAlert">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>{{$errors->first()}}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    @endif
                    @if(session()->has('message'))
                    <div id="boxAlert">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong> {{ session()->get('message') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    @endif
                    <form action="{{ route('update_profile') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama Lengkap</label>
                            <input type="text" class="form-control" name="name" id="exampleInputEmail1"
                                aria-describedby="emailHelp" placeholder="Masukkan Nama Lengkap"
                                value="{{$user->name}}">

                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Username</label>
                            <input type="text" class="form-control" name="username" id="exampleInputEmail1"
                                aria-describedby="emailHelp" placeholder="Masukkan Email" value="{{$user->username}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nomor Hp</label>
                            <input type="number" class="form-control" id="exampleInputEmail1"
                                aria-describedby="emailHelp" name="no_hp" placeholder="Masukkan Nomor HP"
                                value="{{$user->no_hp}}">
                            <small id="emailHelp" class="form-text text-muted">Format : 081209230000</small>
                            <small id="emailHelp" class="form-text text-muted">Catatan : Nomor HP yang dicantumkan akan
                                menerima pesan rekap perbandingan grading AI PKS Sungai Kuning harian setiap hari pukul
                                <span class="font-weight-bold"></span> 7 pagi</small>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password baru</label>
                            <input type="password" name="password" class="form-control" id="exampleInputPassword1"
                                placeholder="Masukkan Password">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Ulangi Password baru</label>
                            <input type="password" name="password_confirmation" class="form-control"
                                id="exampleInputPassword1" placeholder="Masukkan Password">
                        </div>
                        <button type="submit" class="btn btn-success">Submit</button>
                        <a href="{{ route('dashboard') }}" class="btn btn-danger">Kembali</a>
                    </form>
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
    $('#boxAlert').click(function() {
        $('#boxAlert').attr('hidden', true);
    })
</script>