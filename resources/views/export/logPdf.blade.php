<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>

<body style="border: 1px solid black">
    <div id="header " style="margin: 10px 20px 0 20px">
        {{-- <img src="{{ asset('img/logo-SSS.png') }}" class="" style="width: 50px;border-radius:5px;height:100%"> --}}
        <p style="text-align: center;font-weight: bold;font-size:15px">Laporan Grading TBS dengan AI PKS Sungai Kuning
            <br>
            <span style="text-align: center;font-size:14px;font-weight: normal;">{{ $summary['timestamp'] }}</span>
        </p>
        <br>
        <br>
        <div style="font-size: 14px">
            <p style="font-weight: bold"> Rekap Ripeness {{$summary['timestamp']}}:</p>
            <div style="margin-right:20px">
                <p style="margin">SHI
                    <span style="margin-left: 120px">: {{$shiBulan}} %
                    </span>
                </p>
                <p style="margin-top:-10px">HI
                    <span style="margin-left: 130px">: {{$arrHari['persenRipe']}} %
                    </span>
                </p>
            </div>

            <p style="font-weight: bold">Rekap per klasifikasi TBS :</p>

            <div>
                <p style="margin">Ripe
                    <span style="margin-left: 115px">:
                        <span style="font-weight: bold">
                            @php
                            echo '('. $arrHari['persenRipe'] . ' %) ';
                            @endphp
                        </span>
                        @php
                        echo number_format($summary['harianRipe'], 0, ".", ".");
                        @endphp
                    </span>
                </p>
                <p style="margin-top:-6px">Unripe
                    <span style="margin-left: 102px">:
                        <span style="font-weight: bold">
                            @php
                            echo '('. $arrHari['persenUnripe'] . ' %) ';
                            @endphp
                        </span>
                        @php
                        echo number_format($summary['harianUnripe'], 0, ".", ".");
                        @endphp
                    </span>
                </p>
                <p style="margin-top:-6px">Overripe
                    <span style="margin-left: 90px">:
                        <span style="font-weight: bold">
                            @php
                            echo '('. $arrHari['persenOverripe'] . ' %) ';
                            @endphp
                        </span>
                        @php
                        echo number_format($summary['harianOverripe'], 0, ".", ".");
                        @endphp
                    </span>
                </p>
                <p style="margin-top:-6px">Empty Bunch
                    <span style="margin-left: 60px">:
                        <span style="font-weight: bold">
                            @php
                            echo '('. $arrHari['persenEmptyBunch'] . ' %) ';
                            @endphp
                        </span>
                        @php
                        echo number_format($summary['harianEmptyBunch'], 0, ".", ".");
                        @endphp
                    </span>
                </p>
                <p style="margin-top:-6px">Abnormal
                    <span style="margin-left: 83px">:
                        <span style="font-weight: bold">
                            @php
                            echo '('. $arrHari['persenAbnormal'] . ' %) ';
                            @endphp
                        </span>
                        @php
                        echo number_format($summary['harianAbnormal'], 0, ".", ".");
                        @endphp
                    </span>
                </p>

            </div>

        </div>
        <div class="fixed-bottom" style="font-size: 12px">
            <div class="float-right font-italic text-muted">
                Updated : {{ $summary['timestamp']}} {{$summary['updated']}}
            </div>
        </div>
    </div>
    <br>

</body>


</html>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"
    integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"
    integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
</script>