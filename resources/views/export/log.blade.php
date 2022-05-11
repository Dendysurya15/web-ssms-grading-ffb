<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TBS {{$summary['timestamp']}}</title>
    <style>
        * {
            font-family: arial, calibri, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        th {
            font-size: 12px;
            font-weight: bold;
        }

        #header {
            padding: 20px 50px;
            text-align: center;
        }

        #header h1 {
            font-size: 18px;
            font-weight: bold;
        }

        #header h3 {
            font-size: 16px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div id="header" style="clear: right;">
        {{-- <h2>Daftar Peserta Lulus {{ $data->jenis_ujian }} </h2> --}}
        <h3>Rekap TBS PKS Sungai Kuning Mill {{$summary['timestamp']}}</h3>
        <table class="table" aria-describedby="TableDescription">
            {{-- <tr>
                <th scope="col" style=" width: 60%;" border="0">
                    ID
                </th>
                <td style=" width: 70%;" border="0">
                    : {{ $summary['id'] }}
                </td>
            </tr> --}}
            <tr>
                <th scope="col" style=" width: 60%;" border="0">
                    Tanggal
                </th>
                <td style=" width: 70%;" border="0">
                    : {{ $summary['timestamp'] }}
                </td>
            </tr>
            <tr>
                <th scope="col" style=" width: 60%;" border="0">
                    Harian Unripe
                </th>
                <td style=" width: 70%;" border="0">
                    : {{ $summary['harianUnripe'] }}
                </td>
            </tr>
            <tr>
                <th scope="col" style=" width: 60%;" border="0">
                    Harian Ripe
                </th>
                <td style=" width: 70%;" border="0">
                    : {{ $summary['harianRipe'] }}
                </td>
            </tr>
            <tr>
                <th scope="col" style=" width: 60%;" border="0">
                    Harian Overripe
                </th>
                <td style=" width: 70%;" border="0">
                    : {{ $summary['harianOverripe'] }}
                </td>
            </tr>
            <tr>
                <th scope="col" style=" width: 60%;" border="0">
                    Harian Empty Bunch
                </th>
                <td style=" width: 70%;" border="0">
                    : {{ $summary['harianEmptyBunch'] }}
                </td>
            </tr>
            <tr>
                <th scope="col" style=" width: 60%;" border="0">
                    Harian Abnormal
                </th>
                <td style=" width: 70%;" border="0">
                    : {{ $summary['harianAbnormal'] }}
                </td>
            </tr>
            <tr>
                <th scope="col" style=" width: 60%;" border="0">
                    Total TBS Harian
                </th>
                <td style=" width: 70%;" border="0">
                    : {{ $summary['total'] }}
                </td>
            </tr>
        </table>
    </div>

    <div id="content">
        <div id="content-detail">
            <table aria-describedby="tableExport" style="border-collapse: collapse;">
                <tr>
                    <th scope="col" rowspan="1">No</th>
                    <th scope="col" rowspan="1">Jam</th>
                    <th scope="col" rowspan="1">Unripe</th>
                    <th scope="col" rowspan="1">Ripe</th>
                    <th scope="col" rowspan="1">Overripe</th>
                    <th scope="col" rowspan="1">Empty Bunch</th>
                    <th scope="col" rowspan="1">Abnormal</th>
                </tr>

                @foreach ($data as $key => $item)
                <tr>
                    <td scope="col" border="1">{{$key + 1}}</td>
                    <td scope="col" border="1">{{$item->timestamp ?: '-'}}</td>
                    <td scope="col" border="1">{{$item->unripe ?: '-'}}</td>
                    <td scope="col" border="1">{{$item->ripe ?: '-'}}</td>
                    <td scope="col" border="1">{{$item->overripe ?:'-'}}</td>
                    <td scope="col" border="1">{{$item->empty_bunch ?:'-'}}</td>
                    <td scope="col" border="1">{{$item->abnormal ?: "-"}}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</body>

</html>