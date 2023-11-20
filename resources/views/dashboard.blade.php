@include('layout.header')
<style>
    /* .content { */
    /* font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif; */
    /* font-size: 15px; */
    /* } */

    @media (max-width: 576px) {
        .totalFormat {
            /* background-color: lightblue; */
            font-size: 18px;
        }

        .stnd_mutu {
            font-size: 10px;
        }
    }

    .piechartClass {
        background: white;
        border-radius: 5px;
        /*  */
    }

    @media only screen and (min-width: 992px) {
        .stnd_mutu {
            font-size: 14px;
        }

        .totalFormat {
            font-size: 40px;
        }

        .dashboard_div {
            height: 640px;
        }

        .ffb_div {
            height: 640px;
        }

        .piechart_div {
            height: 640px;
        }

        .img_pks_skm {
            height: 200px;
        }

        .linechart_div {
            height: 400px;
        }
    }



    @media only screen and (min-width: 1366px) {
        .dashboard_div {
            height: 840px;
        }

        .ffb_div {
            height: 840px;
        }

        .piechart_div {
            height: 840px;
        }

        .img_pks_skm {
            height: 500px;
        }

        .linechart_div {
            height: 600px;
        }
    }
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    </section>
    <div id="loadingAnimation" class="text-center" style="display: none;">
        <!-- Include your loading animation here, such as an animated GIF or Bodymovin animation -->
    </div>

    <div class="col">
        <div id="chartest">
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="col-12">
            {{csrf_field()}}
            <div class="row p-1 ">
                Filter Tanggal dan Mill :
            </div>
            <div class="row p-1">
                <input class="form-control col-md-3" type="date" name="tgl" id="inputDate">
                <br>
                <select id="list_mill" class="form-control col-md-3">
                    <Label>Pilih MIll</Label>
                    @foreach($listMill as $key => $value)
                    <option value="{{$key}}" {{ $key==0 ? 'selected' : '' }}>{{$value}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="container-fluid pt-2 pl-3 pr-3">
            <div class="row">
                <div class="col-12 col-lg-4 p-5 mb-2 dashboard_div" style="background-color: white;border-radius: 5px;">
                    <h2 style="color:#013C5E;font-weight: 550">Dashboard Grading TBS
                    </h2>
                    <p style="color:#013C5E;">Portal website ini digunakan untuk memonitoring data dari proses grading
                        dengan
                        bantuan <span style="font-style: italic;color: #4CAF50"> Aritifical Inteligence (AI)</span>
                        dengan perantara
                        kamera
                        CCTV yang terpasang di conveyor <span id="nama_pks"></span>
                    </p>

                    <div class="row text-center" style="margin-top:40px;line-height:25px;height:30px;background:#DAE9F5;border: 2px solid #013C5E;border-radius:10px 10px 0 0;">
                        <p style="color:#013C5E" class="font-weight-bold">Update <span id="date_request4"></span> : </p>
                    </div>
                    <div class="row text-center" style="color:#013C5E;background:#DAE9F5;font-size:35px;height:280px;line-height:140px;font-weight:bold;border-left:2px solid #013C5E;border-right:2px solid #013C5E;border-bottom:2px solid #013C5E;border-radius:0 0 10px 10px;">
                        <div class="col-6">
                            <div style="font-size: 20px;position:absolute;left:0;right: 0;
                                margin-left: auto; margin-right: auto;border-right:2px solid #013C5E;height:280px;line-height:140px;">
                            </div>
                            <span style="font-size: 20px;position:absolute;margin-top:-30px;left:0;right: 0;
                                margin-left: auto; margin-right: auto;">HI
                                RIPENESS</span>
                            <span id="hiRipeness"></span>
                        </div>
                        <div class="col-6">
                            {{-- <div
                                style="margin-left:-10px;width:100%;height:150px;line-height:160px;border:1px solid green;position: absolute;">
                            </div> --}}
                            <span style="font-size: 20px;position:absolute;margin-top:-30px;left: 0; 
                            right: 0; 
                            margin-left: auto; 
                            margin-right: auto;">SHI
                                RIPENESS</span> <span id="shiRipeness"></span>
                        </div>
                        <div class="col-6" style="border-top:2px solid #013C5E;">

                            <span style="font-size: 20px;position:absolute;margin-top:-30px;left: 0; 
                            right: 0; 
                            margin-left: auto; 
                            margin-right: auto;"> HI OER
                            </span>
                            <span id="hiOer"></span>
                        </div>
                        <div class="col-6" style="border-top:2px solid #013C5E;">
                            {{-- <div
                                style="margin-left:-10px;width:100%;height:150px;line-height:160px;border:1px solid green;position: absolute;">
                            </div> --}}
                            <span style="font-size: 20px;position:absolute;margin-top:-30px;left: 0; 
                            right: 0; 
                            margin-left: auto; 
                            margin-right: auto;">SHI
                                OER</span> <span id="shiOer"></span>
                        </div>
                    </div>


                </div>
                <div class=" col-12 col-lg-4 mb-2  justify-content: center;
                align-items: center;" id="boxPiechart" style="background: white;height:640px;border-radius:5px;color:#013C5E;padding-top: 50px">
                    <div style="">
                        <p class="text-center  font-weight-bold " style="margin-bottom:0px;"> Persebaran TBS yang masuk
                            ke <span id="list_mil2"></span> pada
                            <span id="date_request"></span>
                            <span id="jam_last"></span>
                        </p>
                        <div id="piechart" class="piechart_div">
                        </div>
                    </div>
                </div>

                <div class="pt-3 font-italic col-12 col-lg-4 ffb_div" style="color:#013C5E;background-color:white;border-radius:5px;">
                    <p class="text-center  font-weight-bold " style="margin-bottom:0px;"> Foto terbaru FFB di conveyor
                        PKS Sungai Kuning
                    </p>
                    <br>

                    <div style="display: flex;
                    align-items: center;
                    justify-content: center;">
                        <a href="{{ asset('/foto') }}">
                            <img src="{{ asset('img/ffb/'.$file[0]) }}" style="border-radius: 8px;
                            max-width: 100%;
                            max-height: 100%;">
                        </a>
                    </div>
                    <p class="text-center font-italic">Sampel foto FFB kualitas baik</p>

                    <div style="display: flex;
                    align-items: center;
                    justify-content: center;">
                        <a href="{{ asset('/foto') }}">
                            <img src="{{ asset('img/ffb/'.$file[1]) }}" style="border-radius: 8px;
                            max-width: 100%;
                            max-height: 100%;">
                        </a>
                    </div>
                    <p class="text-center font-italic">Sampel foto FFB kualitas rendah</p>

                </div>
            </div>


            <div>
                <hr>
                <p style="color:#013C5E;font-size: 17px"> <span class="font-weight-bold">
                    </span>

                    Update hasil grading TBS berdasarkan AI pada hari <span id="date_request2" class="font-weight-bold"></span>
                    <span id="jam_last2" class="font-weight-bold"> </span> WIB dengan total <span id="totalCounter" class="font-weight-bold"></span>
                    buah TBS.
                </p>


                <div id="card_data_exist" class="row"></div>

                <div class="hidden pb-3 " id='card_data_empty'>
                    <div class="col-xl" style="background-color:white;border-radius:5px;">
                        <div class="p-5 text-center">
                            <div style="width: 100%;height:200px;" id="no_data_grading"></div>
                            Tidak ada data yang masuk
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <hr>
        <div class="row">

            <div class="col-md-12">

                <div class="card">
                    <div class="card-header" style="background-color: #013C5E;color:white">
                        <div class=" card-title">
                            <i class="fas fa-chart-line pr-2"></i>Grafik Realtime Jumlah Janjang masuk
                            PKS SKM pada hari
                            <span id="date_request3"></span> <span id="jam_last3"></span>
                        </div>
                        <div class="float-right">
                            <div class="list-inline">
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col">
                                <div id="logHariini" class="linechart_div">
                                </div>
                            </div>

                        </div>
                    </div><!-- /.card-body -->
                </div><!-- Curah Hujan -->


            </div>
        </div>
        {{-- @endif --}}

</div>
<!-- /.row -->
{{--
</div><!-- /.container-fluid --> --}}
</section>
<!-- /.content -->
</div>
@include('layout.footer')

<script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.9.4/lottie.min.js" integrity="sha512-ilxj730331yM7NbrJAICVJcRmPFErDqQhXJcn+PLbkXdE031JJbcK87Wt4VbAK+YY6/67L+N8p7KdzGoaRjsTg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    // testing 


    // endtesting 









    var categories = [
        'Total Unripe',
        'Total Ripe',
        'Total Overripe',
        'Total Empty Bunch',
        'Total Abnormal',
        'Total Kastrasi',
    ];




    var options = {
        series: [44, 55, 41, 17, 15, 99],
        chart: {
            type: 'pie',
            height: 300,
        },
        labels: categories,
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 200
                },
                legend: {
                    position: 'bottom'
                },

            }
        }]
    };
    var chartPie = new ApexCharts(document.querySelector("#piechart"), options);
    chartPie.render();
    inputDate.valueAsDate = new Date(); // Set the date input to today's date

    function removeExistingCards() {
        var container = document.getElementById('card_data_exist');
        while (container.firstChild) {
            container.removeChild(container.firstChild);
        }
    }

    // Function to create and append cards based on data
    function createAndAppendCards(dataArray) {
        dataArray.forEach(function(item) {

            var container = document.getElementById('card_data_exist');
            var card = document.createElement('div');
            card.className = 'col-xl card'; // Default class for all cards

            // Determine the background color based on the condition
            var backgroundColor = item.persentase > item.stnd_mutu ? '#013C5E' : '#C92E26';

            // Populate the card content based on 'item' and the background color condition
            card.innerHTML = `
            <div class="card-header" style="background-color:${backgroundColor};color:white">
                <span class="font-weight-bold" style="font-size: 18px">${item.kategori}</span> <br>
                <span class="font-italic stnd_mutu">Standar Mutu :
                    <span class="font-weight-normal">${item.stnd_view}</span> Tbs</span> <br>
            </div>
            <div class="card-body">
                <div>
                    <span class="totalFormat">${item.total}</span> Buah
                </div>
                <div class="persentase">${item.persentase}%</div>
            </div>
        `;
            container.appendChild(card);
        });
    }



    var optionstest = {
        series: [{
            data: [30, 34, 51, 62, 63, 62, 21, 74, 12, 51, 24, 15, 75, 21, 12]
        }],
        chart: {
            id: 'realtime',
            height: 350,
            type: 'line',
            animations: {
                enabled: true,
                easing: 'linear',
                dynamicAnimation: {
                    speed: 1000
                }
            },
            toolbar: {
                show: false
            },
            zoom: {
                enabled: false
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth'
        },
        title: {
            text: 'Dynamic Updating Chart',
            align: 'left'
        },
        markers: {
            size: 0
        },
        // yaxis: {
        //     max: 100
        // },
        legend: {
            show: false
        },
    };



    var chartest = new ApexCharts(document.querySelector("#logHariini"), optionstest);
    chartest.render();

    var intervalId; // Define the intervalId variable outside the functions to access it globally


    const dashboardRoute = "{{ route('get_dashboard_data') }}";

    $(document).ready(function() {
        // Your chart setup
        // ...

        const dashboardRoute = "{{ route('get_dashboard_data') }}";

        // Call the initial function on page load
        initialAjaxRequest();

        $('#inputDate, #list_mill').on('change', function() {
            clearInterval(intervalId); // Clear the previous interval
            initialAjaxRequest(); // Perform the AJAX request again
        });
    });

    function initialAjaxRequest() {
        performAjaxRequest();
    }

    function performAjaxRequest() {
        var _token = $('input[name="_token"]').val();
        var getDate = $("#inputDate").val();
        var mill = $("#list_mill").val();

        // Check if getDate is empty, and if so, set it to the current date
        if (!getDate) {
            var currentDate = new Date();
            var year = currentDate.getFullYear();
            var month = String(currentDate.getMonth() + 1).padStart(2, '0');
            var day = String(currentDate.getDate()).padStart(2, '0');
            getDate = year + '-' + month + '-' + day;
            $("#inputDate").val(getDate);
        }

        // Make AJAX request
        $.ajax({
            url: dashboardRoute,
            method: "GET",
            data: {
                tgl: getDate,
                mill: mill,
                _token: _token
            },
            success: function(result) {
                var hours = result.perJam

                var currentIndex = 0;

                intervalId = window.setInterval(function() {
                    var currentHour = hours[currentIndex];

                    chartest.updateOptions({
                        xaxis: {
                            categories: hours.slice(0, currentIndex + 1) // Update x-axis categories dynamically
                        }
                    });

                    currentIndex++;
                    if (currentIndex >= hours.length) {
                        currentIndex = 0; // Reset the index to restart the animation
                    }

                    // Update series data based on the current hour index
                    // var newData = optionstest.series[0].data.slice(0, currentIndex + 1);

                    var unripe = result.unripe_line.slice(0, currentIndex + 1);
                    var ripe = result.ripe_line.slice(0, currentIndex + 1);
                    var overripe = result.overripe_line.slice(0, currentIndex + 1);
                    var empty = result.empty_bunch_line.slice(0, currentIndex + 1);
                    var abnormal = result.abnormal_line.slice(0, currentIndex + 1);

                    // console.log(newData);
                    // console.log(abnormal);
                    chartest.updateSeries([{
                        name: "Unripe",
                        data: unripe
                    }, {
                        name: "Ripe",
                        data: ripe
                    }, {
                        name: "Overripe",
                        data: overripe
                    }, {
                        name: "Empty",
                        data: empty
                    }, {
                        name: "Abnormal",
                        data: abnormal
                    }]);
                }, 1000);


                var newSeriesData = [
                    result.unripe,
                    result.ripe,
                    result.overripe,
                    result.empty_bunch,
                    result.abnormal,
                    result.kastrasi
                ];

                chartPie.updateOptions({
                    series: newSeriesData
                })
                var dataseries = [
                    result.unripe_line,
                    result.ripe_line,
                    result.overripe_line,
                    result.empty_bunch_line,
                    result.abnormal_line,
                ];


                // window.setInterval(function() {
                //     chart.updateSeries([{
                //         name: "Unripe",
                //         data: result.unripe_line
                //     }, {
                //         name: "Ripe",
                //         data: result.ripe_line
                //     }, {
                //         name: "Overripe",
                //         data: result.overripe_line
                //     }, {
                //         name: "Empty",
                //         data: result.empty_bunch_line
                //     }, {
                //         name: "Abnormal",
                //         data: result.abnormal_line
                //     }]);

                // chart.updateOptions({
                //     xaxis: {
                //         categories: result.perJam
                //     }
                // });
                // }, 5000); // Update every 5 seconds (5000 milliseconds)
                // chart.updateOptions({
                //     xaxis: {
                //         categories: result.perJam
                //     }
                // });
                // // console.log(result.unripe_line);

                // setInterval(function() {
                //     chart.updateSeries([{
                //         name: "Unripe",
                //         data: result.unripe_line.slice()
                //     }]);
                // }, 1000);

                // var hours = result.perJam; // Assuming result.perJam contains the hours data



                var currentDate = new Date();

                // Convert tgl to a Date object (assuming tgl is a valid date string)
                var tglDate = new Date(getDate);

                // Check if tglDate is the same as currentDate
                var isSameDate = tglDate.getDate() === currentDate.getDate() &&
                    tglDate.getMonth() === currentDate.getMonth() &&
                    tglDate.getFullYear() === currentDate.getFullYear();

                var dateNamaMillElement = document.getElementById('nama_pks');
                var listmil2 = document.getElementById('list_mil2');
                dateNamaMillElement.textContent = result.nama_mill;
                listmil2.textContent = result.nama_mill;


                var dateTotalCounterElement = document.getElementById('totalCounter');
                dateTotalCounterElement.textContent = result.totalCounter;
                var dateHiOerElement = document.getElementById('hiOer');
                dateHiOerElement.textContent = result.hiOer;
                var dateShiOerElement = document.getElementById('shiOer');
                dateShiOerElement.textContent = result.shiOer;
                var dateHiRipenessElement = document.getElementById('hiRipeness');
                dateHiRipenessElement.textContent = result.hiRipeness;
                var dateShiRipenessElement = document.getElementById('shiRipeness');
                dateShiRipenessElement.textContent = result.shiRipeness;

                var date_request = document.getElementById('date_request2');
                date_request.textContent = result.date_request;
                var totaltbs = document.getElementById('totalCounter');
                totaltbs.textContent = result.totaltbs;
                var date_request = document.getElementById('date_request');
                date_request.textContent = result.date_request;
                var jam_last = document.getElementById('jam_last');
                jam_last.textContent = result.jamLast;

                // console.log(result.date_request)

                // chartPie.updateSeries(result.piechart)

                if (result.totalCounter > 0) {

                    $('#card_data_empty').hide();
                    removeExistingCards();
                    var dataArray = result.itemPerClass;
                    createAndAppendCards(dataArray)

                    // chartLine.updateSeries([{
                    //         data: result.unripe
                    //     },
                    //     {
                    //         data: result.ripe
                    //     },
                    //     {
                    //         data: result.overripe
                    //     },
                    //     {
                    //         data: result.empty_bunch
                    //     },
                    //     {
                    //         data: result.abnormal
                    //     }
                    // ]);
                    // chartPie.updateSeries(result.totalMasingKategori)
                } else {
                    $('#card_data_empty').show();
                }

            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }
</script>