<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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
    <div id="piechart" style="width: 900px; height: 500px;"></div>
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
            updated
        </div>
    </div>
</body>


<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous">
</script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    var plot_unripe = '<?php echo  $summary['harianUnripe']; ?>';
    var plot_ripe = '<?php echo   $summary['harianRipe']; ?>';
    var plot_overripe = '<?php echo   $summary['harianOverripe']; ?>';
    var plot_empty_bunch = '<?php echo  $summary['harianEmptyBunch']; ?>';
    var plot_abnormal = '<?php echo  $summary['harianAbnormal']; ?>';

    function drawChart() {

      var data = google.visualization.arrayToDataTable([
        ['Unripe', plot_unripe],
        ['Ripe',     plot_ripe],
        ['Overripe',  plot_overripe],
        ['Empty Bunch',  plot_empty_bunch],
        ['Abnormal', plot_abnormal],
      ]);

      var options = {
        title: 'My Daily Activities'
      };

      var chart = new google.visualization.PieChart(document.getElementById('piechart'));
      chart.draw(data, options);
    }
</script>

</html>