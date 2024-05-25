<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@include('layout.header')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    </section>


    <section class="content">

        <div class="card">
            <div class="card-body">
                New FIlter
                <div class="row">
                    <div class="col-12 col-lg-3">
                        <label for="">Pilih Tanggal</label>
                        <form class="" action="" method="get">
                            {{ csrf_field() }}
                            <input class="form-control" type="date" name="tgl" id="inputDatex">
                        </form>
                    </div>
                    <div class="col-12 col-lg-3">
                        <label for="selectRegx">Reg</label>
                        <select name="selectRegx" id="selectRegx" class="form-control" onchange="populateWil(this.value)">
                            <!-- Options will be dynamically added using JavaScript -->
                        </select>
                    </div>
                    <div class="col-12 col-lg-3">
                        <label for="selectWilx">Wil</label>
                        <select name="selectWilx" id="selectWilx" class="form-control" onchange="populateEstate(this.value)">
                            <!-- Options will be dynamically added using JavaScript -->
                        </select>
                    </div>

                </div>


                <div class="row">
                    <div class="col-12 col-lg-3">
                        <label for="">EST</label>
                        <select name="selectEstx" id="selectEstx" class="form-control" onchange="populatemil(this.value)">
                            <!-- Options will be dynamically added using JavaScript -->
                        </select>
                    </div>


                    <div class="col-12 col-lg-3">
                        <label for="">Mill</label>
                        <select name="list_milx" id="list_milx" class="form-control">

                        </select>
                    </div>
                    <div class="col-12 col-lg-3">
                        <label for="">No Plat</label>
                        <select name="list_platx" id="list_platx" class="form-control">
                            <!-- <option value="">askdjf</option> -->
                        </select>
                    </div>

                </div>
                <div class="row">

                    <div class="col-12 col-lg-3">
                        <label for="">Driver</label>
                        <select name="list_driverx" id="list_driverx" class="form-control">

                        </select>
                    </div>

                    <div class="col-12 col-lg-3">
                        <label for="">STATUS</label>
                        <select name="statusx" id="statusx" class="form-control">

                        </select>
                    </div>

                    <div class="col-12 col-lg-3" style="margin-top: 33px;">
                        <button type="button" id="submit" name="submit" class="btn btn-primary">Show</button>
                    </div>
                </div>



            </div>
        </div>



        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <!-- <h1 style="text-align: center;">Tabel Mutu Ancak</h1> -->
                        <table class="table table-striped table-bordered" id="log_sample">
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



        <div class="card">
            <div class="row">
                <div id="title">
                    <h1 style="text-align: center;"></h1>

                </div>

                <div class="col-md-6">
                    <div id="chart-pie"></div>
                </div>
                <div class="col-md-6">
                    <div id=chart-line></div>
                </div>

                <div class="col-md-12">
                    <div id=ripeness></div>
                </div>

                <div class="col-md-12">
                    <div class="content-wrapper">
                        <section class="content">
                            <div class="container-fluid pt-2 pl-3 pr-3">
                                <div class="row">
                                    <div class="col-12 col-lg-6" style="background-color: white; border-radius: 5px">
                                        <p class="pl-3 pr-3 pt-3 text-center" style="color: #013C5E; font-size: 17px">
                                            Sampel foto terakhir
                                            <span class="font-weight-bold">kualitas baik</span> di conveyor
                                        </p>
                                        <div class="p-3" style="display: flex; align-items: center; justify-content: center; margin-bottom: 30px">
                                            <img src="{{ asset('img/ffb/' . $files[2]) }}" style="border-radius: 5px; max-width: 100%; max-height: 100%;">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6" style="background-color: white; border-radius: 5px">
                                        <p class="pl-3 pr-3 pt-3 text-center" style="color: #013C5E; font-size: 17px">
                                            Sampel foto terakhir
                                            <span class="font-weight-bold">kualitas rendah</span> di conveyor
                                        </p>
                                        <div class="p-3" style="display: flex; align-items: center; justify-content: center; margin-bottom: 30px">
                                            <img src="{{ asset('img/ffb/' . $files[3]) }}" style="border-radius: 5px; max-width: 100%; max-height: 100%;">
                                        </div>
                                    </div>

                        </section>
                    </div>
                </div>
            </div>
        </div>


    </section>

</div>
@include('layout.footer')

<!-- <script src="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"></script> -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script type="text/javascript">
    var options = {
        series: [44, 55, 41, 17, 15],
        chart: {
            type: 'donut',
            height: 300,
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 200
                },
                legend: {
                    position: 'bottom'
                }
            }
        }]
    };
    var chart = new ApexCharts(document.querySelector("#chart-pie"), options);
    chart.render();


    var Options2 = {
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
            curve: 'straight'
        },
        title: {
            text: 'Product Trends by Month',
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

    var Lines = new ApexCharts(document.querySelector("#chart-line"), Options2);
    Lines.render();
    var ripenes = new ApexCharts(document.querySelector("#ripeness"), Options2);
    ripenes.render();

    function getCurrentDate() {
        var today = new Date();
        var year = today.getFullYear();
        var month = String(today.getMonth() + 1).padStart(2, '0');
        var day = String(today.getDate()).padStart(2, '0');
        return year + '-' + month + '-' + day;
    }

    var opt_reg = <?php echo json_encode($list_reg); ?>;
    var opt_will = <?php echo json_encode($list_will); ?>;
    var opt_est = <?php echo json_encode($list_est); ?>;
    var opt_mil = <?php echo json_encode($list_mil); ?>;
    var data = <?php echo json_encode($data); ?>;

    var afdregSelect = document.getElementById('selectRegx');
    var wilSelect = document.getElementById('selectWilx');
    var estateSelect = document.getElementById('selectEstx');
    var millSelect = document.getElementById('list_milx');





    // Function to populate a select element with options
    function populateSelect(selectElement, options) {
        // Clear existing options
        selectElement.innerHTML = '';

        // Create and add new options
        options.forEach(function(option) {
            var optionElement = document.createElement('option');
            optionElement.value = option.id;
            optionElement.textContent = option.nama;
            selectElement.appendChild(optionElement);
        });
    }

    populateSelect(afdregSelect, opt_reg);


    function populateWil(selectedRegionalId) {
        // Clear existing options
        wilSelect.innerHTML = '';

        // Filter the opt_will array based on the selectedRegionalId
        var filteredEstates = opt_will.filter(function(estate) {
            return estate.regional == selectedRegionalId; // Use '==' for loose equality
        });

        // Create and add new options based on the filtered results
        populateSelect(wilSelect, filteredEstates);

        // Trigger a change event to populate the EST dropdown based on the selected Wil
        wilSelect.dispatchEvent(new Event('change'));
    }

    function populateEstate(selectedWilIdx) {
        // Clear existing options

        // console.log(selectedWilIdx);
        estateSelect.innerHTML = '';

        // Filter the opt_est array based on the selectedWilIdx
        var filteredEstates = opt_est.filter(function(estate) {
            return estate.wil == selectedWilIdx;
        });
        filteredEstates.forEach(function(estate) {
            var optionElement = document.createElement('option');
            optionElement.value = estate.wil + '-' + estate.est;
            optionElement.textContent = estate.nama;
            estateSelect.appendChild(optionElement);
        });



        estateSelect.dispatchEvent(new Event('change'));
    }


    function populatemil(selectedEstId) {
        // console.log(selectedEstId);

        let new_id = selectedEstId;
        var parts = new_id.split('-');

        if (parts.length === 2) {
            var valueAfterHyphen = parts[0];
            // console.log(valueAfterHyphen);
        } else {
            // console.log("Invalid input format");
        }

        // console.log(opt_mil);
        millSelect.innerHTML = '';

        // Filter the opt_mil array based on the selectedEstId
        var filteredMill = opt_mil.filter(function(mill) {
            return mill.wil == valueAfterHyphen;
        });
        // console.log(filteredMill);

        filteredMill.forEach(function(mill) {
            var optionElement = document.createElement('option');
            optionElement.value = mill.id;
            optionElement.textContent = mill.nama_mill;

            // console.log(optionElement);
            millSelect.appendChild(optionElement);
        });


        millSelect.dispatchEvent(new Event('change'));

    }


    // Get the default selected Regional option (for example, the first option)
    var defaultSelectedRegionalId = opt_reg[0].id;

    // Populate the Estate options based on the default selected Regional option
    populateWil(defaultSelectedRegionalId);

    $(document).ready(function() {
        // Create a flag to track whether an AJAX request is in progress
        var ajaxInProgress = false;

        // Attach change event handlers to the filter elements
        $('#inputDatex, #selectEstx, #list_milx').change(function() {
            // Check if an AJAX request is already in progress
            if (ajaxInProgress) {
                return; // Do nothing if an AJAX request is still pending
            }

            // Set the flag to indicate that an AJAX request is in progress
            ajaxInProgress = true;

            // Get the selected values from the filter elements
            var tanggal = $('#inputDatex').val();
            var est = $('#selectEstx').val();
            var list_milx = $('#list_milx').val();
            var _token = $('input[name="_token"]').val();

            // Make the AJAX request with the updated filter values

            var ajax = false;
            $.ajax({
                url: "{{ route('filterLog') }}",
                method: "GET",
                data: {
                    tanggal: tanggal,
                    est: est,
                    list_mil: list_milx,
                    _token: _token
                },
                headers: {
                    'X-CSRF-TOKEN': _token
                },
                success: function(result) {
                    let log = result.log;
                    // console.log(log);
                    var platSelect = document.getElementById('list_platx');
                    var driverSelect = document.getElementById('list_driverx');
                    var statusSelect = document.getElementById('statusx');

                    function populate_plat(log) {
                        platSelect.innerHTML = ''; // Clear the current options

                        log.forEach(function(entry) {
                            var optionElement = document.createElement('option');
                            optionElement.value = entry.no_plat === "" ? "isnull" : entry.no_plat;;
                            optionElement.textContent = entry.no_plat === "" ? "Plat not set" : entry.no_plat;
                            platSelect.appendChild(optionElement);
                        });

                        // console.log(log);
                        // Trigger a change event on the select if needed
                        platSelect.dispatchEvent(new Event('change'));
                    }

                    // Call the populate_plat function with the 'log' data
                    populate_plat(log);


                    // Add an event listener to platSelect to trigger the driver function
                    platSelect.addEventListener('change', function() {
                        var selectedPlat = platSelect.value;
                        driver(selectedPlat); // Pass the selectedPlat value to the driver function
                    });

                    // Define your driver function
                    function driver(selectedPlat) {
                        driverSelect.innerHTML = ''; // Clear existing options

                        // Filter the log data based on the selectedPlat
                        var filteredLog = log.filter(function(entry) {
                            return entry.no_plat === selectedPlat;
                        });

                        // Populate driverSelect with the filtered data
                        log.forEach(function(entry) {
                            var optionElement = document.createElement('option');
                            optionElement.value = entry.nama_driver === "" ? "isnull" : entry.nama_driver;;
                            optionElement.textContent = entry.nama_driver === "" ? "Driver Name not set" : entry.nama_driver;
                            // optionElement.textContent = entry.nama_driver;
                            driverSelect.appendChild(optionElement);
                        });

                        // Trigger a change event on the select if needed
                        driverSelect.dispatchEvent(new Event('change'));
                    }

                    platSelect.addEventListener('change', function() {
                        var selecteddriver = driverSelect.value;
                        status(selecteddriver);
                    });

                    // Define your driver function
                    function status(selecteddriver) {
                        statusSelect.innerHTML = ''; // Clear existing options


                        // Populate statusSelect with the filtered data
                        log.forEach(function(entry) {
                            var optionElement = document.createElement('option');
                            optionElement.value = entry.status;
                            optionElement.textContent = entry.status;
                            statusSelect.appendChild(optionElement);
                        });

                        // Trigger a change event on the select if needed
                        statusSelect.dispatchEvent(new Event('change'));
                    }


                },
                error: function(xhr, status, error) {
                    // Handle any errors that occurred during the AJAX request
                    console.error('Error:', error);
                },
                complete: function() {
                    // Reset the flag when the AJAX request is complete
                    ajaxInProgress = false;
                }
            });
        });
    });


    $('#submit').click(function() {
        // Your AJAX request code here

        var tanggal = $('#inputDatex').val();
        var list_milx = $('#list_milx').val();
        var list_platx = $('#list_platx').val();
        var list_driverx = $('#list_driverx').val();
        var statusx = $('#statusx').val();
        var _token = $('input[name="_token"]').val();
        // console.log(tanggal);
        // Create a data object to hold the parameters
        var requestData = {
            tanggal: tanggal,
            list_mil: list_milx,
            list_platx: list_platx,
            list_driverx: list_driverx,
            statusx: statusx,
            _token: _token
        };
        if ($.fn.DataTable.isDataTable('#log_sample')) {
            $('#log_sample').DataTable().destroy();
        }
        $.ajax({
            type: "GET", // Use the appropriate HTTP method (GET or POST) for your server
            url: "newDatatables",
            data: requestData, // Use the requestData object
            success: function(result) {

                var log_sample = $('#log_sample').DataTable({
                    columns: [{
                            title: 'ID',
                            data: 'id'
                        },
                        {
                            title: 'Waktu Selesai',
                            data: 'waktu_selesai_formed'
                        },
                        {
                            title: 'Ripeness',
                            data: 'ripeness'
                        },
                        {
                            title: 'Janjang',
                            data: 'janjang'
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
                            title: 'TP',
                            data: 'tp'
                        },
                        {
                            title: 'Mill',
                            data: 'mill'
                        },
                        {
                            title: 'Bisnis Unit',
                            data: 'bisnis_unit'
                        },
                        {
                            title: 'Divisi',
                            data: 'divisi'
                        },
                        {
                            title: 'Blok',
                            data: 'blok'
                        },
                        {
                            title: 'Status',
                            data: 'status'
                        },
                        {
                            title: 'Nomor Plat',
                            data: 'no_plat'
                        },
                        {
                            title: 'Nama Driver',
                            data: 'nama_driver'
                        }
                    ],
                });

                log_sample.clear().rows.add(result['data']).draw();



                var chart = result.chart;
                var percen = result.percen;
                // Get the reference to the h1 element inside the title div
                var titleElement = document.querySelector("#title h1");

                // Set the dynamic value as the innerHTML of the h1 element
                titleElement.innerHTML = "-" || chart.est + " " + chart.date; // Concatenate the values with a space in between




                // Destroy the existing chart container
                var chartContainer = document.querySelector("#chart-pie");
                while (chartContainer.firstChild) {
                    chartContainer.removeChild(chartContainer.firstChild);
                }

                // console.log(chart);
                var newSeriesData = [
                    chart.total_kastrasi,
                    chart.total_ripe,
                    chart.total_unripe,
                    chart.total_overripe,
                    chart.total_bunch,
                    chart.total_abnormal,

                ];
                var categories = [
                    'Total Kastrasi',
                    'Total Ripe',
                    'Total Unripe',
                    'Total Overripe',
                    'Total Empty Bunch',
                    'Total Abnormal',
                ];

                var LegendTotal = [
                    chart.total_janjang,
                    chart.est,
                    chart.date,
                ];

                var legendCategories = [
                    'Total Janjang',
                    'Estate',
                    'Tanggal',
                ]
                // Create a new chart with updated data
                var updatedChart = new ApexCharts(chartContainer, {
                    series: newSeriesData,
                    chart: {
                        type: 'donut',
                        height: 300,
                    },
                    labels: categories,
                    responsive: [{
                        breakpoint: undefined,
                        options: {
                            chart: {
                                animations: {
                                    enabled: true,
                                    easing: 'easeinout',
                                    speed: 800,
                                    animateGradually: {
                                        enabled: true,
                                        delay: 150
                                    },
                                    dynamicAnimation: {
                                        enabled: true,
                                        speed: 350
                                    }
                                }
                            },
                        },
                    }]
                });

                updatedChart.render();

                Lines.updateSeries([{
                    name: 'Janjang',
                    data: newSeriesData,

                }])
                Lines.updateOptions({
                    xaxis: {
                        categories: categories
                    },
                    title: {
                        text: 'Grading AI ',
                        align: 'left'
                    },
                })
                // Extract time values (categories) and Percen_ripe values (data points)
                const timeValues = Object.keys(percen);
                const percenRipeValues = Object.values(percen).map(entry => entry.Percen_ripe);

                // Assuming you have initialized the ApexCharts instance as "ripenes"
                ripenes.updateSeries([{
                    name: 'Janjang',
                    data: percenRipeValues,
                }, ]);

                ripenes.updateOptions({
                    xaxis: {
                        categories: timeValues,
                    },
                    title: {
                        text: 'Ripeness by Hours',
                        align: 'left',
                    },
                });


            },
            error: function(xhr, status, error) {
                // Handle any errors that occur during the AJAX request
                console.error("AJAX Error: " + error);
            }
        });
    });
</script>