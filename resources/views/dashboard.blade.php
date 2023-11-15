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
        ... .stnd_mutu {
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
                    <option selected disabled>Pilih Mill</option>
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

                    <div class="row text-center"
                        style="margin-top:40px;line-height:25px;height:30px;background:#DAE9F5;border: 2px solid #013C5E;border-radius:10px 10px 0 0;">
                        <p style="color:#013C5E" class="font-weight-bold">Update <span id="date_request4"></span> : </p>
                    </div>
                    <div class="row text-center"
                        style="color:#013C5E;background:#DAE9F5;font-size:35px;height:280px;line-height:140px;font-weight:bold;border-left:2px solid #013C5E;border-right:2px solid #013C5E;border-bottom:2px solid #013C5E;border-radius:0 0 10px 10px;">
                        <div class="col-6">
                            <div
                                style="font-size: 20px;position:absolute;left:0;right: 0;
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
                align-items: center;" id="boxPiechart"
                    style="background: white;height:640px;border-radius:5px;color:#013C5E;padding-top: 50px">
                    <div style="">
                        <p class="text-center  font-weight-bold " style="margin-bottom:0px;"> Persebaran TBS yang masuk
                            ke <span id="nama_pks2"></span> pada
                            <span id="date_request"></span>
                            <span id="jam_last"></span>
                        </p>
                        <div id="piechart" class="piechart_div">
                        </div>
                    </div>
                </div>

                <div class="pt-3 font-italic col-12 col-lg-4 ffb_div"
                    style="color:#013C5E;background-color:white;border-radius:5px;">
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

                    Update hasil grading TBS berdasarkan AI pada hari <span id="date_request2"
                        class="font-weight-bold"></span>
                    <span id="jam_last2" class="font-weight-bold"> </span> WIB dengan total <span id="totalCounter"
                        class="font-weight-bold"></span>
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
                            <span id="nama_pks3"></span> pada hari
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

{{-- <script src="{{ asset('lottie/93121-no-data-preview.json') }}" type="text/javascript"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.9.4/lottie.min.js"
    integrity="sha512-ilxj730331yM7NbrJAICVJcRmPFErDqQhXJcn+PLbkXdE031JJbcK87Wt4VbAK+YY6/67L+N8p7KdzGoaRjsTg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- jQuery -->
<script src="{{ asset('/public/plugins/jquery/jquery.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('/public/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('/public/plugins/chart.js/Chart.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/public/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('/public/js/demo.js') }}"></script>

<script src="{{ asset('/public/js/loader.js') }}"></script>


<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    var colorArray = ['#AB221D', '#4CAF50', '#FF9800', '#BE8C64', '#001E3C'];
var labels = @json($nama_kategori_tbs);

var seriesData = [];

for (var i = 0; i < colorArray.length; i++) {
    var series = {
        name: labels[i],
        data: [], // Replace this with your actual data
        color: colorArray[i],
    };
    seriesData.push(series);
}

var initialData = {
    series: seriesData,
    chart: {
        type: 'line',
        height: 350,
        curve: 'smooth',
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        curve: "smooth"
    },
    grid: {
        padding: {
            right: 30,
            left: 20
        }
    },
    xaxis: {
        categories: @json($arrJam)
    },
    
};

// Initialize the chart
var chartLine = new ApexCharts(document.querySelector("#logHariini"), initialData);
chartLine.render();

var initialDataPieChart = {
            chart: {
                type: 'pie',
    height:'400px',
            },
           
            plotOptions: {
                pie: {
                    size: '70%', // Set the size of the pie chart
                },
            },
            legend: {
                position: 'bottom', // Set the position of the legend (options: 'top', 'bottom', 'left', 'right')
            },
            series: [],
            labels: @json($nama_kategori_tbs),
            colors: ['#AB221D', '#4CAF50', '#FF9800', '#BE8C64', '#001E3C'],
        };

        // Create the pie chart with initial data
        var chartPie = new ApexCharts(document.querySelector("#piechart"), initialDataPieChart);
        chartPie.render();

    // Get references to the date input and list_mill select element
    var inputDate = document.getElementById('inputDate');
    var listMill = document.getElementById('list_mill');
    // var counterDay = document.getElementById('counterDay');

    inputDate.valueAsDate = new Date(); // Set the date input to today's date
    listMill.value = '1'; // Set the select element to option 1

    function removeExistingCards() {
    var container = document.getElementById('card_data_exist');
    while (container.firstChild) {
        container.removeChild(container.firstChild);
    }
}

// Function to create and append cards based on data
function createAndAppendCards(dataArray) {
    dataArray.forEach(function (item) {
        
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

    function pushData() {
        tgl = inputDate.value
        mill = listMill.value
        var _token = $('input[name="_token"]').val();
        Swal.fire({
                title: 'Loading',
                html: '<span class="loading-text">Mohon Tunggu...</span>',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }

            });
        $.ajax({
        url:"{{ route('get_dashboard_data') }}",
        method:"POST",
        data:{ tgl:tgl,mill:mill, _token:_token},
        
        success:function(result)
        {
            Swal.close();
            var currentDate = new Date();

            // Convert tgl to a Date object (assuming tgl is a valid date string)
            var tglDate = new Date(tgl);

            // Check if tglDate is the same as currentDate
            var isSameDate = tglDate.getDate() === currentDate.getDate() &&
                tglDate.getMonth() === currentDate.getMonth() &&
                tglDate.getFullYear() === currentDate.getFullYear();

            var dateRequestElement = document.getElementById('date_request');
            var dateRequest2Element = document.getElementById('date_request2');
            var dateRequest3Element = document.getElementById('date_request3');
            var dateRequest4Element = document.getElementById('date_request4');
            var dateNamaMillElement = document.getElementById('nama_pks');
            var dateNamaMill2Element = document.getElementById('nama_pks2');
            var dateNamaMill3Element = document.getElementById('nama_pks3');
            dateNamaMillElement.textContent =  result.nama_mill ;
            dateNamaMill2Element.textContent =  result.nama_mill ;
            dateNamaMill3Element.textContent =  result.nama_mill ;
            dateRequestElement.textContent =  result.date_request ;
            dateRequest2Element.textContent =  result.date_request ;
            dateRequest3Element.textContent =  result.date_request ;
            dateRequest4Element.textContent =  result.date_only ;

            if (isSameDate) {
                var dateJamLastElement = document.getElementById('jam_last');
            var dateJamLast2Element = document.getElementById('jam_last2');
            var dateJamLast3Element = document.getElementById('jam_last3');
            dateJamLastElement.textContent = 'hingga pukul ' + result.jamLast ;
            dateJamLast2Element.textContent = 'hingga pukul ' + result.jamLast ;
            dateJamLast3Element.textContent = 'hingga pukul ' + result.jamLast ;
            } else{
                // Clear the text content of the span elements when the date is not the same
    
    
    var dateJamLastElement = document.getElementById('jam_last');
    var dateJamLast2Element = document.getElementById('jam_last2');
    var dateJamLast3Element = document.getElementById('jam_last3');

    dateJamLastElement.textContent = '';
    dateJamLast2Element.textContent = '';
    dateJamLast3Element.textContent = '';
            }
            
            
            var dateTotalCounterElement = document.getElementById('totalCounter');
            dateTotalCounterElement.textContent =  result.totalCounter ;
            var dateHiOerElement = document.getElementById('hiOer');
            dateHiOerElement.textContent = result.hiOer;
            var dateShiOerElement = document.getElementById('shiOer');
            dateShiOerElement.textContent = result.shiOer;
            var dateHiRipenessElement = document.getElementById('hiRipeness');
            dateHiRipenessElement.textContent = result.hiRipeness;
            var dateShiRipenessElement = document.getElementById('shiRipeness');
            dateShiRipenessElement.textContent = result.shiRipeness;

            if(result.totalCounter >0){
    
            $('#card_data_empty').hide();
            removeExistingCards();
            var dataArray = result.itemPerClass;
            var dataChart = result.data;
            createAndAppendCards(dataArray)
        
            chartLine.updateSeries([
            { data: result.unripe },
            { data: result.ripe },
            { data: result.overripe },
            { data: result.empty_bunch },
            { data: result.abnormal }
        ]);
            chartPie.updateSeries(result.totalMasingKategori)
            }else{
            $('#card_data_empty').show();
            }
            
        }
        })
    }
    inputDate.addEventListener('change', pushData);
    listMill.addEventListener('change', pushData);
    pushData();

    const params = new URLSearchParams(window.location.search)
    var paramArr = [];
    for (const param of  params) {
        paramArr = param
    }   

    if(paramArr.length > 0){
        date = paramArr[1]
    }else{
        date = new Date().toISOString().slice(0, 10)
    }

    $(document).ready(function(){
        document.getElementById("inputDate").value = date;
    });
    
    bodymovin.loadAnimation({
    // animationData: { /* ... */ },
    container: document.getElementById('no-graph'), // required
    path: 'https://assets2.lottiefiles.com/packages/lf20_7be1jtxw.json', // required
    renderer: 'svg', // required
    loop: true, // optional
    autoplay: true, // optional
    name: "Demo Animation", // optional
  });

    var animation = bodymovin.loadAnimation({
    // animationData: { /* ... */ },
    container: document.getElementById('sampel_good'), // required
    path: 'https://assets8.lottiefiles.com/packages/lf20_exi9acin.json', // required
    renderer: 'svg', // required
    loop: true, // optional
    autoplay: true, // optional
    name: "Demo Animation", // optional
  });

  bodymovin.loadAnimation({
    // animationData: { /* ... */ },
    container: document.getElementById('sampel_bad'), // required
    path: 'https://assets8.lottiefiles.com/packages/lf20_exi9acin.json', // required
    renderer: 'svg', // required
    loop: true, // optional
    autoplay: true, // optional
    name: "Demo Animation", // optional
  });

  bodymovin.loadAnimation({
    // animationData: { /* ... */ },
    container: document.getElementById('no_data_grading'), // required
    path: 'https://assets7.lottiefiles.com/packages/lf20_n2m0isqh.json', // required
    renderer: 'svg', // required
    loop: true, // optional
    autoplay: true, // optional
    name: "Demo Animation", // optional
  });

    width = $(window).width();
    if(width > 700){
        // document.querySelector("#boxPiechart").remove('piechart');
        const div =  document.querySelector('#boxPiechart');
        div.classList.remove('piechartClass');
    };
    

    google.charts.load('current', {
    'packages': ['corechart']
  });
  
</script>