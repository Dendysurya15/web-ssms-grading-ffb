@extends('auth.auth_form')
@section('content')

<div class="row justify-content-center">

    <div class="col-11 col-md-7 col-lg-5">
        <div class="card">
            <p
                style="margin:5% 3% 0 3%;color: #013C5E;font-size: 50px; font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif">
                Log in.</p>
            <p class="text-secondary"
                style="margin:1% 3% 0 3%;font-style: italic;font-size: 14px;font-family:  Arial, Helvetica, sans-serif">
                Silakan masukkan Username dan Password yang ada miliki untuk mengakses portal <span
                    style="color: #4CAF50">Grading TBS
                    SKM</span>!
            </p>
            @error('msg')
            <div id="boxAlert" style="margin: 3% 3% -3% 3%">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong> {{ $message }}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
            @enderror
            <div class="card-body" style="font-family: Arial, Helvetica, sans-serif">
                <form method="POST" action="{{ route('login.custom') }}">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="exampleInputEmail1" class="mb-3">Username</label>
                        <input type="text" placeholder="Masukkan username" id="username" class="form-control"
                            name="username" required autofocus>
                    </div>
                    <div class="form-group mb-3">
                        <label for="exampleInputEmail1" class="mb-3">Password</label>
                        <input type="password" placeholder="Masukkan password" id="password" class="form-control"
                            name="password" required>
                        @if ($errors->has('password'))
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                    </div>

                    <div class="mt-3 d-grid gap-2">
                        <button type="submit" class="btn btn-success mt-3">Submit</button>
                    </div>
                </form>
            </div>


        </div>
    </div>


</div>


<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('js/demo.js') }}"></script>

<script src="{{ asset('js/loader.js') }}"></script>

<script>
    $('#boxAlert').click(function() {
        $('#boxAlert').attr('hidden', true);
    })
</script>
@endsection