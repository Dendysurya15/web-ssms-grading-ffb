<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@include('layout.header')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    </section>


    <section class="content">
        <div class="card">
            <div class="card-body">
                FILTER
                <div class="row">
                    <div class="col-12 col-lg-3">
                        <label for="">Pilih Tanggal</label>
                        <form class="" action="" method="get">
                            {{ csrf_field() }}
                            <input class="form-control" type="date" name="tgl" id="inputDate">
                        </form>
                    </div>
                    <div class="col-12 col-lg-3">
                        <label for="selectReg">Reg</label>
                        <select name="selectReg" id="selectReg" class="form-control">
                            @foreach ($list_reg as $key => $item)
                            <option value="{{ $item['id'] }}">{{ $item['nama'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-lg-3">
                        <label for="selectWil">Wil</label>
                        <select name="selectWil" id="selectWil" class="form-control">
                            <!-- Options will be dynamically added using JavaScript -->
                        </select>
                    </div>

                </div>
                <div class="row">
                    <div class="col-12 col-lg-3">
                        <label for="">EST</label>
                        <select name="selectEst" id="selectEst" class="form-control">

                        </select>
                    </div>
                    <div class="col-12 col-lg-3">
                        <label for="">Mill</label>
                        <select name="list_mil" id="list_mil" class="form-control">
                            <!-- @foreach ($list_mil as $key => $item)
                            <option value="{{ $item['id'] }}">{{ $item['mill'] }}</option>
                            @endforeach -->
                        </select>
                    </div>
                    <div class="col-12 col-lg-3">
                        <label for="">No Plat</label>
                        <select name="list_plat" id="list_plat" class="form-control">
                            <!-- <option value="">askdjf</option> -->
                        </select>
                    </div>

                </div>
                <div class="row">

                    <div class="col-12 col-lg-3">
                        <label for="">Driver</label>
                        <select name="list_driver" id="list_driver" class="form-control">

                        </select>
                    </div>

                    <div class="col-12 col-lg-3">
                        <label for="">STATUS</label>
                        <select name="status" id="status" class="form-control">

                        </select>
                    </div>

                </div>
            </div>
        </div>


        <div class="card">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center" id="rekapWaterLevel">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>TANGGAL</th>
                                <th>RIPENESS</th>
                                <th>JANJANG</th>
                                <th>RIPE</th>
                                <th>UNRIPE</th>
                                <th>OVERRIPE</th>
                                <th>EMPTY BUNCH</th>
                                <th>ABNORMAL</th>
                                <th>Kastrasi</th>
                                <th>TP</th>
                                <th>MILL</th>
                                <th>REG</th>
                                <th>WIL</th>
                                <th>EST</th>
                                <th>INTI</th>
                                <th>PLAT</th>
                                <th>DRIVER</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
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
            </div>
        </div>


    </section>

</div>
@include('layout.footer')

<!-- <script src="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"></script> -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function() {
        // DOM Elements
        const elements = {
            selectReg: document.getElementById("selectReg"),
            selectWil: document.getElementById("selectWil"),
            selectEst: document.getElementById("selectEst"),
            inputDate: document.getElementById("inputDate"),
            listMil: document.getElementById("list_mil"),
            listplat: document.getElementById("list_plat"),
            listdriver: document.getElementById("list_driver"),
            status: document.getElementById("status"),
            showButton: document.getElementById("showButton")
        };

        // Initial Setup
        const {
            selectReg,
            selectWil,
            selectEst,
            listMil,
            listplat,
            listdriver,
            status
        } = elements;

        let filtersChanged = false;
        let isFetching = false;

        // Disable Elements
        let isUpdating = false;


        selectReg.disabled = true;
        selectWil.disabled = true;
        selectEst.disabled = true;
        listMil.disabled = true;
        listplat.disabled = true;
        listdriver.disabled = true;
        status.disabled = true;


        selectReg.addEventListener("change", handleRegionChange);
        selectWil.addEventListener("change", handleWilayahChange);
        selectEst.addEventListener("change", updateResults);
        inputDate.addEventListener("change", enableFiltersAndUpdateResults);

        function handleRegionChange() {
            const selectedRegId = selectReg.value;
            clearDropdown(selectWil);
            clearDropdown(selectEst);

            const filteredWils = filterByRegion(selectedRegId);
            populateDropdown(selectWil, filteredWils, "id", "nama");

            selectWil.dispatchEvent(new Event('change'));
            updateResults();
        }

        function handleWilayahChange() {
            const selectedWilId = selectWil.value;
            clearDropdown(selectEst);

            const filteredEsts = filterByWilayah(selectedWilId);
            populateDropdown(selectEst, filteredEsts, "est", "nama");

            updateResults();
        }

        function enableFiltersAndUpdateResults() {
            enableFilters();
            updateResults();
        }

        function filterByRegion(regionalId) {
            return <?php echo json_encode($list_will); ?>.filter(wil => wil.regional == regionalId);
        }

        function filterByWilayah(wilayahId) {
            return <?php echo json_encode($list_est); ?>.filter(est => est.wil == wilayahId);
        }

        function clearDropdown(dropdown) {
            dropdown.innerHTML = "";
        }

        function populateDropdown(dropdown, options, valueProp, labelProp) {
            options.forEach(option => {
                const optionElement = document.createElement("option");
                optionElement.value = option[valueProp];
                optionElement.textContent = option[labelProp];
                dropdown.appendChild(optionElement);
            });
        }

        function updateResults() {
            if (isFetching) {
                return;
            }

            var _token = $('input[name="_token"]').val();
            var date = $("#inputDate").val();
            var regional = $("#selectReg").val();
            var wilayah = $("#selectWil").val();
            var estate = $("#selectEst").val();

            $.ajax({
                url: "{{ route('getFilterTemuan') }}",
                method: "get",
                data: {
                    date: date,
                    regional: regional,
                    wilayah: wilayah,
                    estate: estate,
                    _token: _token
                },
                success: function(result) {
                    const parseResult = JSON.parse(result);
                    const {
                        list_mill,
                        list_plat,
                        list_driver,
                        list_status
                    } = parseResult;

                    clearAndEnableDropdown(listMil);
                    populateDropdown(listMil, list_mill, "id", "nama_mill");
                    addChangeListener(listMil, function() {
                        const selectedMilId = parseInt(listMil.value);
                        clearAndEnableDropdown(listplat);
                        populateFilteredDropdown(listplat, list_plat, "no_plat", "no_plat", plat => plat.mill_id === selectedMilId);
                        clearAndEnableDropdown(listdriver);
                    });

                    addChangeListener(listplat, function() {
                        const selectedPlat = listplat.value;
                        populateFilteredDropdown(listdriver, list_driver, "nama_driver", "nama_driver", drv => drv.no_plat === selectedPlat);
                    });

                    addChangeListener(listdriver, function() {
                        const selectedDriver = listdriver.value;
                        populateFilteredDropdown(status, list_driver, "status", "status", drv => drv.nama_driver === selectedDriver);
                    });


                    listMil.dispatchEvent(new Event("change"));
                    listplat.dispatchEvent(new Event("change"));
                    listdriver.dispatchEvent(new Event("change"));
                    status.dispatchEvent(new Event("change"));

                },

                error: function(xhr, status, error) {
                    console.error('AJAX request error:', error);
                },
                complete: function() {
                    isFetching = false;
                }
            });
        }

        function clearAndEnableDropdown(dropdown) {
            dropdown.innerHTML = "";
            dropdown.disabled = false;
        }

        function populateDropdown(dropdown, options, valueProp, labelProp) {
            options.forEach(option => {
                const optionElement = createOptionElement(option[valueProp], option[labelProp]);
                dropdown.appendChild(optionElement);
            });
        }

        function populateFilteredDropdown(dropdown, options, valueProp, labelProp, filterFunction) {
            clearAndEnableDropdown(dropdown);
            const filteredOptions = options.filter(filterFunction);
            populateDropdown(dropdown, filteredOptions, valueProp, labelProp);
        }

        function addChangeListener(element, changeHandler) {
            element.addEventListener("change", changeHandler);
        }

        function createOptionElement(value, label) {
            const option = document.createElement("option");
            option.value = value;
            option.textContent = label;
            return option;
        }

        function enableFilters() {
            selectReg.disabled = false;
            selectWil.disabled = false;
            selectEst.disabled = false;
            listMil.disabled = false;
            listplat.disabled = false;
            listdriver.disabled = false;
            status.disabled = false;
        }

        updateResults();

        function triggerFilterChangeEvents() {
            selectReg.dispatchEvent(new Event("change"));
            selectWil.dispatchEvent(new Event("change"));
            selectEst.dispatchEvent(new Event("change"));
            inputDate.dispatchEvent(new Event("change"));
        }

        // Trigger the change events after setting up the initial state
        triggerFilterChangeEvents();





    });


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


    $(document).ready(function() {
        // Initialize initial values
        var date = $("#inputDate").val() || getCurrentDate();
        var wilayah = $("#selectWil").val();
        var estate = $("#selectEst").val();
        var mill = $("#list_mil").val();
        var no_plat = $("#list_plat").val();
        var driver = $("#list_driver").val();
        var driverStatus = $("#status").val();

        // Flag to prevent multiple requests
        var isUpdating = false;
        var dataTable = $('#rekapWaterLevel').DataTable({
            columns: [{
                    data: 'id'
                },
                {
                    data: 'waktu_selesai_formed'
                },
                {
                    data: 'ripeness'
                },
                {
                    data: 'janjang'
                },
                {
                    data: 'ripe'
                },
                {
                    data: 'unripe'
                },
                {
                    data: 'overripe'
                },
                {
                    data: 'empty_bunch'
                },
                {
                    data: 'abnormal'
                },
                {
                    data: 'kastrasi'
                },
                {
                    data: 'tp'
                },
                {
                    data: 'mill'
                },
                {
                    data: 'bisnis_unit'
                },
                {
                    data: 'divisi'
                },
                {
                    data: 'blok'
                },
                {
                    data: 'status'
                },
                {
                    data: 'no_plat'
                },
                {
                    data: 'nama_driver'
                }
            ],
        });


        $("#selectWil, #selectEst, #list_mil, #list_plat, #list_driver, #status, #inputDate").on("change", function() {
            if (!isUpdating) {
                isUpdating = true;
                // Clear existing data in the DataTable
                dataTable.clear().draw();
                // Add a delay before performing the AJAX request
                setTimeout(function() {
                    performAjaxRequest();
                }, 3500);
            }
        });

        // Event listener for date input
        $("#inputDate").on("change", function() {
            date = $(this).val(); // Update the date value
            if (!isUpdating) {
                isUpdating = true;
                // Add a delay of 2 seconds (2000 milliseconds) before performing the AJAX request
                setTimeout(function() {
                    performAjaxRequest();
                }, 3500);
            }
        });

        function performAjaxRequest() {
            // Get the values of the dropdowns inside the function
            var date = inputDate.value;
            var wilayah = selectWil.value;
            var estate = selectEst.value;
            var mill = $("#list_mil").val();
            var no_plat = $("#list_plat").val();
            var driver = $("#list_driver").val();
            var driverStatus = $("#status").val();
            $('#chart-pie').empty()
            $.ajax({
                url: "{{ route('newDatatables') }}",
                method: "GET",

                data: {
                    wilayah: wilayah,
                    estate: estate,
                    mill: mill,
                    no_plat: no_plat,
                    driver: driver,
                    driverStatus: driverStatus,
                    date: date,
                    _token: $('input[name="_token"]').val()
                },
                success: function(result) {
                    // Handle the success response
                    var data = result.data;
                    var chart = result.chart;
                    var percen = result.percen;

                    dataTable.clear().draw();

                    // Repopulate the table with the updated data
                    dataTable.rows.add(data);
                    dataTable.draw();

                    // Get the reference to the h1 element inside the title div
                    var titleElement = document.querySelector("#title h1");

                    // Set the dynamic value as the innerHTML of the h1 element
                    titleElement.innerHTML = chart.est + " " + chart.date; // Concatenate the values with a space in between




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


                    isUpdating = false;
                },
                error: function(xhr, status, error) {
                    console.error('AJAX request error:', error);
                    // Reset the flag after request completes
                    isUpdating = false;
                }
            });
        }


        // Function to get current date in "YYYY-MM-DD" format
        function getCurrentDate() {
            var today = new Date();
            var year = today.getFullYear();
            var month = String(today.getMonth() + 1).padStart(2, '0');
            var day = String(today.getDate()).padStart(2, '0');
            return year + '-' + month + '-' + day;
        }
    });
</script>