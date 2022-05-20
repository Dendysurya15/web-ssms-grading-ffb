<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>

<body>
    <div id="header">
        {{-- <h2>Daftar Peserta Lulus {{ $data->jenis_ujian }} </h2> --}}
        <h3 style="text-align: center">Rekap TBS PKS Sungai Kuning Mill </h3>
        <br>
        <div>
            <table>
                <thead>
                    <tr>
                        <td>Tanggal</td>
                        <td>: {{ $summary['timestamp'] }}</td>
                    </tr>
                    <tr>
                        <td>Harian Unripe</td>
                        <td>: {{ $summary['harianRipe'] }}</td>
                    </tr>
                    <tr>
                        <td>Harian Ripe</td>
                        <td>: {{ $summary['harianUnripe'] }}</td>
                    </tr>
                    <tr>
                        <td>Harian Overripe</td>
                        <td>: {{ $summary['harianOverripe'] }}</td>
                    </tr>
                    <tr>
                        <td>Harian Empty Bunch</td>
                        <td>: {{ $summary['harianEmptyBunch'] }}</td>
                    </tr>
                    <tr>
                        <td>Harian Abnormal</td>
                        <td>: {{ $summary['harianAbnormal'] }}</td>
                    </tr>
                </thead>
            </table>
        </div>

    </div>
    <br>
    {{-- <div class="content">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Jam</th>
                    <th scope="col">Unripe</th>
                    <th scope="col">Ripe</th>
                    <th scope="col">Overripe</th>
                    <th scope="col">Empty Bunch</th>
                    <th scope="col">Abnormal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key=> $item)
                <tr>
                    <td scope="col">{{$key + 1}}</td>
                    <td scope="col">{{$item->timestamp }}</td>
                    <td scope="col">{{$item->unripe }}</td>
                    <td scope="col">{{$item->ripe }}</td>
                    <td scope="col">{{$item->overripe }}</td>
                    <td scope="col">{{$item->empty_bunch }}</td>
                    <td scope="col">{{$item->abnormal }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div> --}}
    <div class="fixed-bottom" style="font-size: 12px">
        <div class="float-right font-italic text-muted">
            Updated : {{ $summary['timestamp']}} {{$summary['updated']}}
        </div>
    </div>
</body>


</html>