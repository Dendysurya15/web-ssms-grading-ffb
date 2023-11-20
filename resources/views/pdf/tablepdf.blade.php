<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <div class="container">
        <div style="display: flex; justify-content: center; margin-top: 1px; margin-bottom: 2px; margin-left: 3px; margin-right: 3px; border: 1px solid black; background-color: #f8f4f4">
            <h2 style="text-align: center;">Laporan Grading AI </h2>
        </div>


        <table style="width: 100%; border-collapse: collapse;">
            <tr>

                <td style="width:30%;border:0;">

                    <p style="text-align: left; font-size: 20px;">Nama Mill : {{$data['millnama']}}</p>

                </td>
                <td style=" width: 20%;border:0;">
                </td>
                <td style="vertical-align: middle; text-align: right;width:40%;border:0;">
                    <div class="right-container">
                        <div class="text-container">
                            <p style="text-align: right; font-size: 20px;">TANGGAL : {{$data['date']}} </p>
                        </div>
                    </div>
                </td>
            </tr>
        </table>

        <p>Table Perjam</p>

        <table style="width: 100%; border-collapse: collapse;border: 1px solid black;">
            <tr>
                <th style="background-color:aqua;border: 1px solid black;">Jam Masuk</th>
                <th style="background-color:aqua;border: 1px solid black;">Total Ripe</th>
                <th style="background-color:aqua;border: 1px solid black;">Total Unripe</th>
                <th style="background-color:aqua;border: 1px solid black;">Total overripe</th>
                <th style="background-color:aqua;border: 1px solid black;">Total Empty</th>
                <th style="background-color:aqua;border: 1px solid black;">Total Abnormal</th>
                <th style="background-color:aqua;border: 1px solid black;">Total Kastrasi</th>
            </tr>

            @php
            foreach ($data['datahours'] as $item){
            $jam = $item['jam'];
            $ripe = $item['ripe'];
            $unripe = $item['unripe'];
            $overripe = $item['overripe'];
            $empty_bunch = $item['empty_bunch'];
            $abnormal = $item['abnormal'];
            $kastrasi = $item['kastrasi'];
            $totaljjg = $item['totaljjg'];
            }

            @endphp

            <tr style="border: 1px solid black;">
                <td style="border:1px solid black;text-align: center;">{{$jam}}</td>
                <td style="border:1px solid black;text-align: center;">{{$ripe}}</td>
                <td style="border:1px solid black;text-align: center;">{{$unripe}}</td>
                <td style="border:1px solid black;text-align: center;">{{$overripe}}</td>
                <td style="border:1px solid black;text-align: center;">{{$empty_bunch}}</td>
                <td style="border:1px solid black;text-align: center;">{{$abnormal}}</td>
                <td style="border:1px solid black;text-align: center;">{{$kastrasi}}</td>

            </tr>
            <tr>
                <td style="text-align:center;" colspan="5"></td>
                <td style="text-align:right;">Total:</td>
                <td style=" text-align:center;border: 1px solid black;">{{$totaljjg}}</td>
            </tr>

        </table>


        <p style="margin-top:50px">Table Permenit</p>


        <table style="width: 100%; border-collapse: collapse;border: 1px solid black;margin-top:20px">
            <tr>
                <th style="background-color:aqua;border: 1px solid black;">Jam Masuk</th>
                <th style="background-color:aqua;border: 1px solid black;">Total Ripe</th>
                <th style="background-color:aqua;border: 1px solid black;">Total Unripe</th>
                <th style="background-color:aqua;border: 1px solid black;">Total overripe</th>
                <th style="background-color:aqua;border: 1px solid black;">Total Empty</th>
                <th style="background-color:aqua;border: 1px solid black;">Total Abnormal</th>
                <th style="background-color:aqua;border: 1px solid black;">Total Kastrasi</th>
            </tr>
            @foreach ($data['dataM'] as $key => $items)
            @foreach($items as $key2 => $item)

            <tr style="border: 1px solid black;">
                <td style="border:1px solid black;text-align: center;">{{$key}}</td>
                <td style="border:1px solid black;text-align: center;">{{$item['ripe']}}</td>
                <td style="border:1px solid black;text-align: center;">{{$item['unripe']}}</td>
                <td style="border:1px solid black;text-align: center;">{{$item['overripe']}}</td>
                <td style="border:1px solid black;text-align: center;">{{$item['empty_bunch']}}</td>
                <td style="border:1px solid black;text-align: center;">{{$item['abnormal']}}</td>
                <td style="border:1px solid black;text-align: center;">{{$item['kastrasi']}}</td>
            </tr>


            @endforeach
            @endforeach
            <tr>
                <td style="text-align:center;" colspan="5"></td>
                <td style="text-align:right;">Total:</td>
                <td style=" text-align:center;border: 1px solid black;">{{$totaljjg}}</td>
            </tr>
        </table>





    </div>




    </div>

</body>

</html>