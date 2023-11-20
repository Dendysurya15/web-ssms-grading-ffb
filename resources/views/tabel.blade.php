@include('layout.header')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 end">
                    <label for=""> Pilih Mill : </label>
                    <select name="" id="getmillid">
                        @foreach ($getmil as $data)
                        <option value="{{$data->id}}">{{$data ->nama_mill}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-12">
                    <!-- Curah Hujan -->

                    <div class="card">
                        <div class="card-header" style="background-color: #02A452;color:white">
                            <div class=" card-title">
                                <i class="fas fa-chart-line pr-2"></i>Grafik Ripeness Harian Grading Ai <span id="namgrading"></span>
                            </div>
                        </div>
                        <div class="card-body mb-3">
                            <div class="row">
                                <div class="col">
                                    <div id="logAll">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
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
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th style="width:15%;">Total TBS Masuk</th>
                                            <th>OER Harian</th>
                                            {{-- <th>Curah Hujan</th> --}}
                                            <th style="width:15%;">Ripeness</th>
                                            <th>Unripe</th>
                                            <th>Overripe</th>
                                            <th>Empty Bunch</th>
                                            <th>Abnormal</th>
                                            <th>Unduh</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm-5">
                                    <h2 class="m-2 ">
                                        Tabel Log TBS PerJam
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">

                            <table class="table table-striped table-bordered" id="tbsperhour">
                                <thead>
                                    <!-- Table header content -->
                                </thead>
                                <tbody>
                                    <!-- Table body content will be dynamically generated -->
                                </tbody>
                            </table>
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
<link href="https://cdn.datatables.net/v/dt/dt-1.13.8/datatables.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdn.datatables.net/v/dt/dt-1.13.8/datatables.min.js"></script>

<script type="text/javascript">
    const dashboardRoute = "{{ route('datamill') }}";

    var options = {
        series: [{
            name: "Desktops",
            data: [10, 41, 35, 51, 49, 62, 69, 91, 148]
        }],
        chart: {
            height: 350,
            type: 'line',
            zoom: {
                enabled: false
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth',
        },
        title: {
            text: 'Realtime Ripeness',
            align: 'left'
        },
        grid: {
            row: {
                colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                opacity: 0.5
            },
        },
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
        }
    };

    var chart = new ApexCharts(document.querySelector("#logAll"), options);
    chart.render();

    var intervalId; // Define the intervalId variable outside the functions to access it globally
    var isHovering = false; // Define isHovering globally

    $(document).ready(function() {
        const dashboardRoute = "{{ route('datamill') }}";

        // Call the initial function on page load
        initialAjaxRequest();

        $('#getmillid').on('change', function() {
            clearInterval(intervalId); // Clear the previous interval
            initialAjaxRequest(); // Perform the AJAX request again


        });
    });

    function initialAjaxRequest() {
        performAjaxRequest();
    }



    function performAjaxRequest() {
        var _token = $('input[name="_token"]').val();

        var mill = $("#getmillid").val();
        var millText = $("#getmillid option:selected").text(); // Get the selected text

        var namaMill = document.getElementById('namgrading');
        namaMill.textContent = millText
        // console.log("Text:", millText);

        // console.log(mill);
        if ($.fn.DataTable.isDataTable('#tbsperhour')) {
            $('#tbsperhour').DataTable().destroy();
        }
        if ($.fn.DataTable.isDataTable('#rekapWaterLevel')) {
            $('#rekapWaterLevel').DataTable().destroy();
        }
        // Make AJAX request
        $.ajax({
            url: dashboardRoute,
            method: "GET",
            data: {
                mill: mill,
                _token: _token
            },
            success: function(result) {
                var hours = result.logPerhariView.dates;
                var currentIndex = 0;

                intervalId = setInterval(function() {
                    if (!isHovering) { // Only execute if not hovering
                        var currentHour = hours[currentIndex];

                        chart.updateOptions({
                            xaxis: {
                                categories: hours.slice(0, currentIndex + 1) // Update x-axis categories dynamically
                            }
                        });

                        currentIndex++;
                        if (currentIndex >= hours.length) {
                            currentIndex = 0; // Reset the index to restart the animation
                        }

                        var unripe = result.logPerhariView.ripenes.slice(0, currentIndex + 1);

                        chart.updateSeries([{
                            name: "Ripeness",
                            data: unripe
                        }]);
                    }
                }, 1000);



                var judul = 'DATA LOG GRADING AI';
                $(function() {
                    $('#rekapWaterLevel').DataTable({
                        "searching": true,
                        "pageLength": 10,
                        "columnDefs": [{
                                "width": "10%",
                                "targets": 8
                            },
                            {
                                "width": "15%",
                                "targets": 1
                            },
                            {
                                "width": "10%",
                                "targets": 3
                            }
                        ],
                        processing: true,
                        serverSide: true,
                        ajax: "{{ route('data') }}",
                        columns: [{
                                data: 'id',
                                name: 'id'
                            },
                            {
                                data: 'timestamp',
                                name: 'timestamp'
                            },
                            {
                                data: 'total',
                                name: 'total'
                            },
                            {
                                data: 'oer',
                                name: 'oer'
                            },
                            {
                                data: 'harianRipe',
                                name: 'harianRipe'
                            },
                            {
                                data: 'harianUnripe',
                                name: 'harianUnripe'
                            },
                            {
                                data: 'harianOverripe',
                                name: 'harianOverripe'
                            },
                            {
                                data: 'harianEmptyBunch',
                                name: 'empty_bunch'
                            },
                            {
                                data: 'harianAbnormal',
                                name: 'harianAbnormal'
                            },
                            {
                                data: 'action',
                                name: 'action'
                            },
                        ],

                    });
                });




                // function drawChart() {



                //     var plot_ripe = result.logPerhariView['plot2'];

                //     // console.log(plot_ripe);

                //     var dataLogAll = new google.visualization.DataTable();
                //     dataLogAll.addColumn('string', 'Name');
                //     dataLogAll.addColumn('number', plot_ripe);
                //     dataLogAll.addRows([
                //         result.logPerhariView['data']
                //     ]);

                //     var optionsLogHariIIni = {
                //         chartArea: {},
                //         theme: 'material',
                //         colors: ['#4CAF50'],
                //         legend: {
                //             position: 'top',
                //             textStyle: {
                //                 fontSize: 15
                //             }
                //         },
                //         lineWidth: 2,
                //         hAxis: {

                //         },
                //         height: 250,
                //     };

                //     var log = new google.visualization.LineChart(document.getElementById('logAll'));
                //     log.draw(dataLogAll, optionsLogHariIIni);
                // }

                var datatabperhour = $('#tbsperhour').DataTable({
                    columns: [{
                            title: 'Jam',
                            data: 'jam'
                        },
                        {
                            title: 'Ripe',
                            data: 'ripe'
                        },
                        {
                            title: 'Unripe',
                            data: 'unripe'
                        },
                        {
                            title: 'Overripe',
                            data: 'overripe'
                        },
                        {
                            title: 'Empty',
                            data: 'empty_bunch'
                        },
                        {
                            title: 'Abnormal',
                            data: 'abnormal'
                        },
                        {
                            title: 'Kastrasi',
                            data: 'kastrasi'
                        },
                        {
                            title: 'Total TBS',
                            data: 'totaljjg'
                        },
                        {
                            title: 'Actions',
                            render: function(data, type, row, meta) {
                                var buttons =
                                    '<form action="/downloaddatapdf" method="GET" class="form-inline" style="display: inline;" target="_blank">' +
                                    '<input type="hidden" name="jam" value="' + row.jam + '">' +
                                    '<input type="hidden" name="id" value="' + row.id + '">' +
                                    '<input type="hidden" name="date" value="' + row.date + '">' +
                                    '<input type="hidden" name="millnama" value="' + row.millnama + '">' +
                                    '<button class="downloadHour">Download PDF</button>' +
                                    '</form>';
                                return buttons;
                            }
                        }
                    ]
                });



                var dataH = result.newdata
                // console.log(dataH);

                datatabperhour.clear().rows.add(Object.values(dataH)).draw();



            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }
</script>