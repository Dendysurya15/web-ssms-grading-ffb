@include('layout.header')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Input Curah Hujan Harian untuk PKS Sungai Kuning</h2>
                </div>
                @if ($message = Session::get('success'))
                {{-- @error('msg') --}}
                <div id="boxAlert" style="">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong> {{ $message }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
                {{-- @enderror --}}
                @endif
                @if ($message = Session::get('error'))
                {{-- @error('msg') --}}
                <div id="boxAlert" style="">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong> {{ $message }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
                {{-- @enderror --}}
                @endif
                <form class="form-inline" action="{{ route('ch.store') }}" method="POST">
                    @csrf
                    <label for="title">Curah Hujan (ml) </label>
                    <div class="form-group mx-sm-3 mb-2">
                        <label for="inputPassword2" class="sr-only">Password</label>
                        <input type="text" name="rain_fall" class="form-control" id="inputPassword2"
                            placeholder="Exp : 4.3">
                    </div>
                    <label for="">Tanggal</label>
                    <div class="form-group mx-sm-3 mb-2">
                        <label for="inputPassword2" class="sr-only">Password</label>
                        <input type="date" name="timestamp" class="form-control" id="inputPassword2" placeholder="">
                    </div>
                    @error('ch')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                    <button type="submit" class="btn btn-primary mb-2">Simpan</button>
                </form>
            </div>
        </div>


        <div style="background: white;" class="pb-3">

            <table class="table" id="myTable">
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Curah Hujan (ml)</th>
                    <th width="280px">Action</th>
                </tr>
                @foreach ($data as $item)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$item->tanggal}}</td>
                    <td>{{$item->rain_fall}}</td>
                    <td>
                        <form action="{{ route('ch.destroy',$item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </table>
            {{ $data->links() }}
        </div>
    </section>

    <!-- /.content -->
</div>
@include('layout.footer')