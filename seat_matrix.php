<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>GMU Admission Seat Matrix Dashboard</title>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/searchpanes/2.2.0/css/searchPanes.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.7.0/css/select.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

    <!-- Bootstrap & Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Chart.js -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.css">

    <style>
        :root {
            --primary-gold: linear-gradient(to left, #ecc35c, #f7f3b7, #ecc35c);
            --secondary-gold: linear-gradient(to left, #ecc35c, #f7f3b7, #ecc35c);
            --light-gold: linear-gradient(to left, #ecc35c, #f7f3b7, #ecc35c);
            --dark-brown: #5b1f1f;
            --medium-brown: #5b1f1f;
            --light-brown: #5b1f1f;
            --off-white: #FAF9F6;
            --card-shadow: 0 8px 32px rgba(91, 31, 31, 0.1);
            --hover-shadow: 0 12px 40px rgba(91, 31, 31, 0.15);
        }

        body {
            background: var(--dark-brown);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--off-white);
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .main-content {
            margin-left: 250px;
            /* Match your sidebar width */
            padding: 20px;
            padding-top: 80px;
            /* Space for navbar */
            min-height: 100vh;
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
        }

        /* When sidebar is collapsed */
        .main-content.collapsed {
            margin-left: 80px;
        }

        .header {
            background: rgba(91, 31, 31, 0.95);
            backdrop-filter: blur(15px);
            border-radius: 25px;
            padding: 2rem;
            margin: 1rem;
            text-align: center;
            box-shadow: var(--card-shadow);
        }

        .header h1 {
            background: var(--primary-gold);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .header p {
            color: var(--off-white);
            font-size: 1.1rem;
            margin: 0;
            opacity: 0.9;
        }

        .container-fluid {
            padding: 0 1rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .dashboard-card {
            background: rgba(91, 31, 31, 0.95);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(236, 195, 92, 0.2);
            transition: all 0.3s ease;
            overflow: hidden;
            position: relative;
        }

        .dashboard-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gold);
            border-radius: 20px 20px 0 0;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--hover-shadow);
        }

        .stat-card {
            text-align: center;
            padding: 2rem 1.5rem;
            border-radius: 20px;
            background: var(--dark-brown);
            color: var(--off-white);
            margin-bottom: 1.5rem;
            font-weight: 600;
            box-shadow: var(--card-shadow);
            height: 100%;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(236, 195, 92, 0.2);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transform: rotateZ(45deg);
            transition: all 0.6s;
            opacity: 0;
        }

        .stat-card:hover::before {
            animation: shine 0.6s ease-in-out;
        }

        .stat-card h3 {
            background: var(--primary-gold);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            font-weight: 700;
        }

        .stat-card p {
            color: var(--off-white);
            font-size: 0.95rem;
            margin: 0;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .chart-container {
            position: relative;
            height: 400px;
            width: 100%;
            padding: 1rem 0;
        }

        .chart-container canvas {
            max-height: 100% !important;
            border-radius: 15px;
        }

        h5 {
            margin-bottom: 1.5rem;
            color: var(--off-white);
            font-weight: 600;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        h5::before {
            content: '';
            width: 4px;
            height: 20px;
            background: var(--primary-gold);
            border-radius: 2px;
        }

        /* DataTable Styling */
        .dataTables_wrapper {
            font-size: 0.9rem;
            background: #fff;
            padding: 20px;
            border-radius: 15px;
            box-shadow: var(--card-shadow);
        }

        .table {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            color: #333;
            background: #fff;
        }

        .thead-dark {
            background: var(--dark-brown) !important;
            color: var(--off-white);
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #fff;
        }

        .table-striped tbody tr:nth-of-type(even) {
            background-color: #f8f9fa;
        }

        .table td,
        .table th {
            padding: 12px;
            vertical-align: middle;
            border-top: 1px solid #dee2e6;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_processing,
        .dataTables_wrapper .dataTables_paginate {
            color: #333 !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            color: #333 !important;
            background: #fff;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            margin: 2px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--primary-gold) !important;
            color: var(--dark-brown) !important;
            border: none;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #f8f9fa !important;
            color: var(--dark-brown) !important;
            border: 1px solid #dee2e6;
        }

        .btn-custom {
            background: var(--primary-gold);
            border: none;
            border-radius: 10px;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            color: var(--dark-brown);
            margin: 5px;
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .dt-buttons {
            margin-bottom: 15px;
        }

        /* Filter Controls */
        .filter-controls {
            background: rgba(91, 31, 31, 0.95);
            backdrop-filter: blur(15px);
            border-radius: 15px;
            padding: 1rem;
            margin-bottom: 1rem;
            box-shadow: var(--card-shadow);
        }

        .filter-controls label {
            color: var(--off-white);
        }

        .form-control {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(236, 195, 92, 0.2);
            color: var(--off-white);
        }

        .form-control:focus {
            background-color: rgba(255, 255, 255, 0.15);
            border-color: rgba(236, 195, 92, 0.5);
            color: var(--off-white);
            box-shadow: 0 0 0 0.2rem rgba(236, 195, 92, 0.25);
        }

        .form-control option {
            background-color: var(--dark-brown);
            color: var(--off-white);
        }

        /* Loading Animation */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(91, 31, 31, 0.9);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            backdrop-filter: blur(5px);
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 3px solid rgba(236, 195, 92, 0.3);
            border-top: 3px solid #ecc35c;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        /* Animations */
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes shine {
            0% {
                transform: translateX(-100%) translateY(-100%) rotateZ(45deg);
                opacity: 0;
            }

            50% {
                opacity: 1;
            }

            100% {
                transform: translateX(100%) translateY(100%) rotateZ(45deg);
                opacity: 0;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translate3d(0, 40px, 0);
            }

            to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }

        /* Stagger animation delays */
        .dashboard-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .dashboard-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .dashboard-card:nth-child(3) {
            animation-delay: 0.3s;
        }

        .dashboard-card:nth-child(4) {
            animation-delay: 0.4s;
        }

        /* Success/Error Messages */
        .alert-custom {
            border-radius: 15px;
            border: none;
            box-shadow: var(--card-shadow);
            margin-bottom: 1rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding-top: 20px;
            }

            .header h1 {
                font-size: 2rem;
            }

            .stat-card h3 {
                font-size: 2rem;
            }

            .chart-container {
                height: 300px;
            }
        }
    </style>
</head>

<body>

    <?php include 'navbar.php'; ?>
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="header">
            <h1><i class="fas fa-graduation-cap me-3"></i> GMU Admission Seat Matrix Dashboard</h1>
            <p>Comprehensive Analytics & Data Visualization</p>
        </div>

        <div class="container-fluid">
            <!-- Filter Controls -->
            <div class="filter-controls">
                <div class="row">
                    <div class="col-md-3">
                        <label for="yearFilter">Academic Year:</label>
                        <select id="yearFilter" class="form-control">
                            <option value="">All Years</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="collegeFilter">College:</label>
                        <select id="collegeFilter" class="form-control">
                            <option value="">All Colleges</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="programmeFilter">Programme:</label>
                        <select id="programmeFilter" class="form-control">
                            <option value="">All Programmes</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button id="resetFilters" class="btn btn-custom btn-block">
                            <i class="fas fa-sync-alt"></i> Reset Filters
                        </button>
                    </div>
                </div>
            </div>

            <!-- Summary Statistics -->
            <div class="row">
                <div class="col-md-3">
                    <div class="stat-card">
                        <h3 id="totalIntake">0</h3>
                        <p><i class="fas fa-users"></i> Total Intake</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <h3 id="totalAdmitted">0</h3>
                        <p><i class="fas fa-user-graduate"></i> Students Admitted</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <h3 id="totalRevenue">₹0</h3>
                        <p><i class="fas fa-rupee-sign"></i> Actual Revenue</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <h3 id="totalColleges">0</h3>
                        <p><i class="fas fa-building"></i> Active Colleges</p>
                    </div>
                </div>
            </div>

            <!-- Charts Section 1 -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="dashboard-card">
                        <h5><i class="fas fa-chart-bar"></i> College-wise Admission Distribution</h5>
                        <div class="chart-container">
                            <canvas id="admissionChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="dashboard-card">
                        <h5><i class="fas fa-chart-radar"></i> Programme Performance Analysis</h5>
                        <div class="chart-container">
                            <canvas id="programmeRadarChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section 2 -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="dashboard-card">
                        <h5><i class="fas fa-chart-bubble"></i> Fee Structure Analysis</h5>
                        <div class="chart-container">
                            <canvas id="feeChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="dashboard-card">
                        <h5><i class="fas fa-chart-pie"></i> Quota Distribution</h5>
                        <div class="chart-container">
                            <canvas id="quotaPolarChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section 3 -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="dashboard-card">
                        <h5><i class="fas fa-chart-line"></i> Revenue Analysis</h5>
                        <div class="chart-container">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="dashboard-card">
                        <h5><i class="fas fa-chart-bar"></i> Fill Rate by Course</h5>
                        <div class="chart-container">
                            <canvas id="fillRateChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="row">
                <div class="col-12">
                    <div class="dashboard-card">
                        <h5><i class="fas fa-table"></i> Detailed Admission Data</h5>
                        <div class="table-responsive">
                            <table id="admissionTable" class="table table-bordered table-striped" style="width:100%">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Academic Year</th>
                                        <th>College</th>
                                        <th>Programme</th>
                                        <th>Course</th>
                                        <th>Discipline</th>
                                        <th>Quota</th>
                                        <th>Intake</th>
                                        <th>Admitted</th>
                                        <th>Fee</th>
                                        <th>Expected Revenue</th>
                                        <th>Actual Revenue</th>
                                        <th>Fill Rate %</th>
                                        <th>Regular Status</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add loading overlay -->
    <div id="loadingOverlay" style="display: none;">
        <div class="spinner"></div>
    </div>

    <!-- Add error message container -->
    <div id="errorMessage" class="alert alert-danger" style="display: none;"></div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>
    
    <!-- DataTables and Extensions -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/searchpanes/2.2.0/js/dataTables.searchPanes.min.js"></script>
    <script src="https://cdn.datatables.net/searchpanes/2.2.0/js/searchPanes.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.7.0/js/dataTables.select.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    
    <!-- Chart.js and plugins -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>

    <script>
        // Remove any existing chartData declaration
        if (window.chartData) {
            delete window.chartData;
        }
        
    $(document).ready(function () {
            // Show loading overlay initially
            $('#loadingOverlay').show();

            // Function to filter data based on current filter values
            function getFilteredData() {
                const yearFilter = $('#yearFilter').val();
                const collegeFilter = $('#collegeFilter').val();
                const programmeFilter = $('#programmeFilter').val();

                if (!window.fullData || !Array.isArray(window.fullData)) {
                    console.warn('No data available for filtering');
                    return [];
                }

                return window.fullData.filter(row => {
                    return (!yearFilter || row[0] === yearFilter) &&
                           (!collegeFilter || row[1] === collegeFilter) &&
                           (!programmeFilter || row[2] === programmeFilter);
                });
            }

            // DataTable initialization
            var table = $('#admissionTable').DataTable({
                    dom: '<"row"<"col-sm-12 col-md-6"B><"col-sm-12 col-md-6"f>>rtip',
                    processing: true,
                    serverSide: false,
                ajax: {
                    url: 'fetch_table.php',
                    type: 'POST',
                        dataSrc: function (json) {
                            if (json.error) {
                                console.error('Data fetch error:', json.message);
                                $('#errorMessage').html('Error loading data: ' + json.message).show();
                                $('#loadingOverlay').hide();
                                return [];
                            }
                            if (!json.data || !Array.isArray(json.data)) {
                                console.error('Invalid data format:', json);
                                $('#errorMessage').html('Invalid data format received').show();
                                return [];
                            }
                            console.log('Data loaded successfully:', json.data.length + ' records');
                            window.fullData = json.data; // Store just the data array
                            return json.data;
                    }
                },
                columns: [
                        { 
                            data: '0',
                            title: 'Academic Year'
                        },
                        { 
                            data: '1',
                            title: 'College'
                        },
                        { 
                            data: '2',
                            title: 'Programme'
                        },
                        { data: '3', title: 'Course' },
                        { data: '4', title: 'Discipline' },
                        { 
                            data: '5',
                            title: 'Quota'
                        },
                        { 
                            data: '6',
                            title: 'Intake',
                            render: function(data) {
                                return parseInt(data).toLocaleString();
                            }
                        },
                        { 
                            data: '7',
                            title: 'Admitted',
                            render: function(data) {
                                return parseInt(data).toLocaleString();
                            }
                        },
                        { 
                            data: '8',
                            title: 'Fee',
                            render: function(data) {
                                return '₹' + parseInt(data).toLocaleString();
                            }
                        },
                        { 
                            data: '9',
                            title: 'Expected Revenue',
                            render: function(data) {
                                return '₹' + parseInt(data).toLocaleString();
                            }
                        },
                        { 
                            data: '10',
                            title: 'Actual Revenue',
                            render: function(data) {
                                return '₹' + parseInt(data).toLocaleString();
                            }
                        },
                        { 
                            data: '11',
                            title: 'Fill Rate %',
                            render: function(data) {
                                const rate = parseFloat(data);
                                const color = rate >= 90 ? 'success' :
                                            rate >= 70 ? 'warning' :
                                            'danger';
                                return `<span class="badge badge-${color}">${rate.toFixed(1)}%</span>`;
                            }
                        },
                        { data: '12', visible: false }
                    ],
                    buttons: [
                        {
                            extend: 'collection',
                            text: '<i class="fas fa-download"></i> Export',
                            className: 'btn-custom',
                            buttons: [
                                {
                                    extend: 'excel',
                                    text: '<i class="fas fa-file-excel"></i> Excel',
                                    className: 'btn-sm',
                                    exportOptions: {
                                        columns: ':visible'
                                    }
                                },
                                {
                                    extend: 'csv',
                                    text: '<i class="fas fa-file-csv"></i> CSV',
                                    className: 'btn-sm',
                                    exportOptions: {
                                        columns: ':visible'
                                    }
                                },
                                {
                                    extend: 'print',
                                    text: '<i class="fas fa-print"></i> Print',
                                    className: 'btn-sm',
                                    exportOptions: {
                                        columns: ':visible'
                                    }
                                }
                            ]
                        },
                        {
                            extend: 'colvis',
                            text: '<i class="fas fa-columns"></i> Columns',
                            className: 'btn-custom'
                        }
                    ],
                    language: {
                        processing: '<div class="spinner"></div>',
                        emptyTable: 'No data available',
                        zeroRecords: 'No matching records found'
                    },
                    pageLength: 10,
                    order: [[0, 'desc'], [1, 'asc'], [7, 'asc']],
                responsive: true,
                    select: true,
                initComplete: function(settings, json) {
                        if (!json.error) {
                            if (json.data && json.data.length > 0) {
                                console.log('Table initialized with data');
                populateFilters(json.data);
                                updateChartsAndStats();
                            } else {
                                console.warn('No data available for initialization');
                                $('#errorMessage').html('No data available').show();
                            }
                        } else {
                            console.error('Error during table initialization:', json.error);
                            $('#errorMessage').html('Error initializing table: ' + json.error).show();
                        }
                        $('#loadingOverlay').hide();
                    }
                });

                // Initialize SearchPanes
                new $.fn.dataTable.SearchPanes(table, {
                    layout: 'columns-3',
                    controls: false,
                    clear: true
                });
                
                table.searchPanes.container().prependTo(table.table().container());
                table.searchPanes.resizePanes();

            // Filter controls
            function populateFilters(data) {
                if (!data || !Array.isArray(data)) {
                    console.warn('Invalid data for filter population');
                    return;
                }

                var years = new Set(), colleges = new Set(), programmes = new Set();
                data.forEach(function (row) {
                    years.add(row[0]);
                    colleges.add(row[1]);
                    programmes.add(row[2]);
                });

                fillSelect($('#yearFilter'), years, 'All Years');
                fillSelect($('#collegeFilter'), colleges, 'All Colleges');
                fillSelect($('#programmeFilter'), programmes, 'All Programmes');
            }

            function fillSelect($select, items, allText) {
                if (!$select || !items) {
                    console.warn('Invalid parameters for fillSelect');
                    return;
                }

                var val = $select.val();
                $select.empty().append(`<option value="">${allText}</option>`);
                Array.from(items).sort().forEach(function (item) {
                    $select.append(`<option value="${item}">${item}</option>`);
                });
                if (items.has(val)) {
                    $select.val(val);
                }
            }

            // Update visualizations when filters change
            $('#yearFilter, #collegeFilter, #programmeFilter').on('change', function() {
                $('#loadingOverlay').fadeIn(300);
                setTimeout(() => {
                    try {
                        const filteredData = getFilteredData();
                        console.log('Filter changed - Filtered data length:', filteredData.length);
                        updateSummary(filteredData);
                        chartManager.updateAllCharts(filteredData);
                        $('#errorMessage').hide();
                    } catch (error) {
                        console.error('Error updating after filter change:', error);
                        $('#errorMessage').html('Error updating visualizations: ' + error.message).show();
                    }
                    $('#loadingOverlay').fadeOut(300);
                }, 100);
            });

            $('#resetFilters').on('click', function () {
                $('#yearFilter, #collegeFilter, #programmeFilter').val('');
                $('#loadingOverlay').fadeIn(300);
                setTimeout(() => {
                    try {
                        updateChartsAndStats();
                    } catch (error) {
                        console.error('Error updating after filter reset:', error);
                        $('#errorMessage').html('Error updating visualizations: ' + error.message).show();
                    }
                    $('#loadingOverlay').fadeOut(300);
                }, 100);
            });

            // Function to update summary statistics
            function updateSummary(filteredData) {
                if (!window.fullData || !Array.isArray(window.fullData)) {
                    console.warn('No data available for summary');
                    return;
                }

                // Calculate total intake from the full dataset (unfiltered)
                const totalIntake = window.fullData.reduce((sum, row) => sum + (parseInt(row[6]) || 0), 0);

                // Calculate other statistics from filtered data
                const totalAdmitted = filteredData.reduce((sum, row) => sum + (parseInt(row[7]) || 0), 0);
                const totalRevenue = filteredData.reduce((sum, row) => sum + (parseInt(row[10]) || 0), 0);
                const colleges = new Set(filteredData.map(row => row[1]));

                // Log the values for debugging
                console.log('Statistics Update:', {
                    totalIntake,
                    totalAdmitted,
                    totalRevenue,
                    collegeCount: colleges.size,
                    filteredDataLength: filteredData.length
                });

                // Update the display with animations
                animateNumber('#totalIntake', totalIntake);
                animateNumber('#totalAdmitted', totalAdmitted);
                animateNumber('#totalRevenue', totalRevenue, true);
                animateNumber('#totalColleges', colleges.size);
            }

            function animateNumber(elementId, finalValue, isCurrency = false) {
                const $element = $(elementId);
                const startValue = parseInt($element.text().replace(/[^0-9]/g, '')) || 0;
                const duration = 1000;
                const steps = 50;
                const increment = (finalValue - startValue) / steps;
                let currentStep = 0;

                const timer = setInterval(() => {
                    currentStep++;
                    const currentValue = Math.floor(startValue + (increment * currentStep));
                    $element.text(isCurrency ? '₹' + currentValue.toLocaleString() : currentValue.toLocaleString());

                    if (currentStep >= steps) {
                        clearInterval(timer);
                        $element.text(isCurrency ? '₹' + finalValue.toLocaleString() : finalValue.toLocaleString());
                    }
                }, duration / steps);
            }

            // Chart configuration
            const chartColors = {
                primary: '#ecc35c',
                secondary: '#5b1f1f',
                tertiary: '#f7f3b7',
                background: 'rgba(236, 195, 92, 0.1)',
                border: '#5b1f1f',
                highlight: '#f7f3b7',
                gradients: [
                    'rgba(236, 195, 92, 0.8)',
                    'rgba(91, 31, 31, 0.8)',
                    'rgba(247, 243, 183, 0.8)',
                    'rgba(180, 85, 85, 0.8)',
                    'rgba(209, 112, 112, 0.8)'
                ]
            };

            const chartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            color: '#FAF9F6',
                            font: { size: 12 }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(91, 31, 31, 0.9)',
                        titleColor: '#FAF9F6',
                        bodyColor: '#FAF9F6',
                        borderColor: '#ecc35c',
                        borderWidth: 1
                    }
                }
            };

            class ChartManager {
                constructor() {
                    this.charts = {
                        admissionBar: null,
                        programmePie: null,
                        revenueTrend: null,
                        quotaDoughnut: null,
                        fillRateBar: null,
                        feeDistribution: null
                    };

                    this.colors = {
                        primary: ['rgba(54, 162, 235, 0.8)', 'rgba(54, 162, 235, 1)'],   // Blue
                        secondary: ['rgba(75, 192, 192, 0.8)', 'rgba(75, 192, 192, 1)'], // Teal
                        success: ['rgba(40, 167, 69, 0.8)', 'rgba(40, 167, 69, 1)'],     // Green
                        warning: ['rgba(255, 159, 64, 0.8)', 'rgba(255, 159, 64, 1)'],   // Orange
                        danger: ['rgba(220, 53, 69, 0.8)', 'rgba(220, 53, 69, 1)'],      // Red
                        info: ['rgba(23, 162, 184, 0.8)', 'rgba(23, 162, 184, 1)'],      // Cyan
                        
                        // Professional color palette
                        palette: [
                            'rgba(54, 162, 235, 0.8)',  // Blue
                            'rgba(75, 192, 192, 0.8)',  // Teal
                            'rgba(40, 167, 69, 0.8)',   // Green
                            'rgba(255, 159, 64, 0.8)',  // Orange
                            'rgba(220, 53, 69, 0.8)',   // Red
                            'rgba(153, 102, 255, 0.8)', // Purple
                            'rgba(23, 162, 184, 0.8)',  // Cyan
                            'rgba(108, 117, 125, 0.8)'  // Gray
                        ]
                    };

                    this.baseOptions = {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    padding: 20,
                                    font: {
                                        family: "'Segoe UI', Arial, sans-serif",
                                        size: 12,
                                        weight: 500
                                    }
                                }
                            },
                            title: {
                                display: true,
                                font: {
                                    family: "'Segoe UI', Arial, sans-serif",
                                    size: 16,
                                    weight: 600
                                },
                                padding: {
                                    top: 20,
                                    bottom: 20
                                }
                            },
                            datalabels: {
                                color: '#fff',
                                font: {
                                    weight: 'bold'
                                },
                                formatter: (value) => {
                                    if (value >= 1000000) {
                                        return '₹' + (value / 1000000).toFixed(1) + 'M';
                                    } else if (value >= 1000) {
                                        return '₹' + (value / 1000).toFixed(1) + 'K';
                                    }
                                    return value;
                                }
                            }
                        }
                    };
                }

                updateAllCharts(data) {
                    if (!data || data.length === 0) {
                        console.warn('No data available for charts');
                        return;
                    }

                    try {
                        this.updateAdmissionBarChart(data);
                        this.updateProgrammePieChart(data);
                        this.updateRevenueTrendChart(data);
                        this.updateQuotaDoughnutChart(data);
                        this.updateFillRateBarChart(data);
                        this.updateFeeDistributionChart(data);
                    } catch (error) {
                        console.error('Error updating charts:', error);
                    }
                }

                // 1. Admission Bar Chart
                updateAdmissionBarChart(data) {
                    const ctx = document.getElementById('admissionChart');
                    if (!ctx) return;

                    if (this.charts.admissionBar) {
                        this.charts.admissionBar.destroy();
                    }

                    const collegeData = {};
                    data.forEach(row => {
                        const college = row[1];
                        if (!collegeData[college]) {
                            collegeData[college] = {
                                admitted: parseInt(row[7]) || 0,
                                intake: parseInt(row[6]) || 0
                            };
                        } else {
                            collegeData[college].admitted += parseInt(row[7]) || 0;
                            collegeData[college].intake += parseInt(row[6]) || 0;
                        }
                    });

                    const labels = Object.keys(collegeData);
                    const admittedData = labels.map(college => collegeData[college].admitted);
                    const intakeData = labels.map(college => collegeData[college].intake);

                    this.charts.admissionBar = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [
                                {
                                    label: 'Admitted Students',
                                    data: admittedData,
                                    backgroundColor: this.colors.success[0],
                                    borderColor: this.colors.success[1],
                                    borderWidth: 1
                                },
                                {
                                    label: 'Total Intake',
                                    data: intakeData,
                                    backgroundColor: this.colors.primary[0],
                                    borderColor: this.colors.primary[1],
                                    borderWidth: 1
                                }
                            ]
                        },
                        options: {
                            ...this.baseOptions,
                            plugins: {
                                ...this.baseOptions.plugins,
                                title: {
                                    ...this.baseOptions.plugins.title,
                                    text: 'College-wise Admission Distribution'
                                }
                            },
                            scales: {
                                x: {
                                    grid: {
                                        display: false
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Number of Students'
                                    }
                                }
                            }
                        }
                    });
                }

                // 2. Programme Distribution Pie Chart
                updateProgrammePieChart(data) {
                    const ctx = document.getElementById('programmeRadarChart');
                    if (!ctx) return;

                    if (this.charts.programmePie) {
                        this.charts.programmePie.destroy();
                    }

                    const programmeData = {};
                    data.forEach(row => {
                        const programme = row[2];
                        if (!programmeData[programme]) {
                            programmeData[programme] = parseInt(row[7]) || 0;
                        } else {
                            programmeData[programme] += parseInt(row[7]) || 0;
                        }
                    });

                    const labels = Object.keys(programmeData);
                    const values = Object.values(programmeData);

                    this.charts.programmePie = new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: labels,
                            datasets: [{
                                data: values,
                                backgroundColor: this.colors.palette,
                                borderColor: '#fff',
                                borderWidth: 2
                            }]
                        },
                        options: {
                            ...this.baseOptions,
                            plugins: {
                                ...this.baseOptions.plugins,
                                title: {
                                    ...this.baseOptions.plugins.title,
                                    text: 'Programme-wise Distribution'
                                },
                                datalabels: {
                                    formatter: (value, ctx) => {
                                        const sum = ctx.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = (value * 100 / sum).toFixed(1) + '%';
                                        return percentage;
                                    }
                                }
                            }
                        }
                    });
                }

                // 3. Revenue Trend Chart
                updateRevenueTrendChart(data) {
                    const ctx = document.getElementById('revenueChart');
                    if (!ctx) return;

                    if (this.charts.revenueTrend) {
                        this.charts.revenueTrend.destroy();
                    }

                    const yearlyRevenue = {};
                    data.forEach(row => {
                        const year = row[0];
                        if (!yearlyRevenue[year]) {
                            yearlyRevenue[year] = {
                                expected: parseInt(row[9]) || 0,
                                actual: parseInt(row[10]) || 0
                            };
                        } else {
                            yearlyRevenue[year].expected += parseInt(row[9]) || 0;
                            yearlyRevenue[year].actual += parseInt(row[10]) || 0;
                        }
                    });

                    const years = Object.keys(yearlyRevenue).sort();
                    const expectedData = years.map(year => yearlyRevenue[year].expected);
                    const actualData = years.map(year => yearlyRevenue[year].actual);

                    this.charts.revenueTrend = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: years,
                            datasets: [
                                {
                                    label: 'Expected Revenue',
                                    data: expectedData,
                                    backgroundColor: this.colors.warning[0],
                                    borderColor: this.colors.warning[1],
                                    borderWidth: 1,
                                    type: 'bar'
                                },
                                {
                                    label: 'Actual Revenue',
                                    data: actualData,
                                    backgroundColor: this.colors.success[0],
                                    borderColor: this.colors.success[1],
                                    borderWidth: 1,
                                    type: 'bar'
                                }
                            ]
                        },
                        options: {
                            ...this.baseOptions,
                            plugins: {
                                ...this.baseOptions.plugins,
                                title: {
                                    ...this.baseOptions.plugins.title,
                                    text: 'Revenue Analysis by Year'
                                }
                            },
                            scales: {
                                x: {
                                    grid: {
                                        display: false
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Revenue (₹)'
                                    },
                                    ticks: {
                                        callback: (value) => {
                                            if (value >= 10000000) {
                                                return '₹' + (value / 10000000).toFixed(1) + 'Cr';
                                            }
                                            return '₹' + (value / 100000).toFixed(1) + 'L';
                                        }
                                    }
                                }
                            }
                        }
                    });
                }

                // 4. Quota Distribution Doughnut Chart
                updateQuotaDoughnutChart(data) {
                    const ctx = document.getElementById('quotaPolarChart');
                    if (!ctx) return;

                    if (this.charts.quotaDoughnut) {
                        this.charts.quotaDoughnut.destroy();
                    }

                    const quotaData = {};
                    data.forEach(row => {
                        const quota = row[5];
                        if (!quotaData[quota]) {
                            quotaData[quota] = parseInt(row[7]) || 0;
                        } else {
                            quotaData[quota] += parseInt(row[7]) || 0;
                        }
                    });

                    const labels = Object.keys(quotaData);
                    const values = Object.values(quotaData);

                    this.charts.quotaDoughnut = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: labels,
                            datasets: [{
                                data: values,
                                backgroundColor: this.colors.palette,
                                borderColor: '#fff',
                                borderWidth: 2
                            }]
                        },
                        options: {
                            ...this.baseOptions,
                            plugins: {
                                ...this.baseOptions.plugins,
                                title: {
                                    ...this.baseOptions.plugins.title,
                                    text: 'Quota-wise Distribution'
                                },
                                datalabels: {
                                    formatter: (value, ctx) => {
                                        const sum = ctx.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = (value * 100 / sum).toFixed(1) + '%';
                                        return percentage;
                                    }
                                }
                            },
                            cutout: '60%'
                        }
                    });
                }

                // 5. Fill Rate Bar Chart
                updateFillRateBarChart(data) {
                    const ctx = document.getElementById('fillRateChart');
                    if (!ctx) return;

                    if (this.charts.fillRateBar) {
                        this.charts.fillRateBar.destroy();
                    }

                    const courseData = {};
                    data.forEach(row => {
                        const course = row[3];
                        const fillRate = parseFloat(row[11]) || 0;
                        if (!courseData[course] || courseData[course].rate < fillRate) {
                            courseData[course] = {
                                rate: fillRate,
                                admitted: parseInt(row[7]) || 0,
                                intake: parseInt(row[6]) || 0
                            };
                        }
                    });

                    const sortedCourses = Object.entries(courseData)
                        .sort((a, b) => b[1].rate - a[1].rate)
                        .slice(0, 10);

                    const labels = sortedCourses.map(([course]) => course);
                    const fillRates = sortedCourses.map(([, data]) => data.rate);

                    this.charts.fillRateBar = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Fill Rate',
                                data: fillRates,
                                backgroundColor: fillRates.map(rate => 
                                    rate >= 90 ? this.colors.success[0] :
                                    rate >= 70 ? this.colors.warning[0] :
                                    this.colors.danger[0]
                                ),
                                borderColor: fillRates.map(rate => 
                                    rate >= 90 ? this.colors.success[1] :
                                    rate >= 70 ? this.colors.warning[1] :
                                    this.colors.danger[1]
                                ),
                                borderWidth: 1
                            }]
                        },
                        options: {
                            ...this.baseOptions,
                            indexAxis: 'y',
                            plugins: {
                                ...this.baseOptions.plugins,
                                title: {
                                    ...this.baseOptions.plugins.title,
                                    text: 'Top 10 Courses by Fill Rate'
                                },
                                datalabels: {
                                    align: 'end',
                                    anchor: 'end',
                                    formatter: value => value.toFixed(1) + '%'
                                }
                            },
                            scales: {
                                x: {
                                    beginAtZero: true,
                                    max: 100,
                                    title: {
                                        display: true,
                                        text: 'Fill Rate (%)'
                                    }
                                },
                                y: {
                                    grid: {
                                        display: false
                                    }
                                }
                            }
                        }
                    });
                }

                // 6. Fee Distribution Chart
                updateFeeDistributionChart(data) {
                    const ctx = document.getElementById('feeChart');
                    if (!ctx) return;

                    if (this.charts.feeDistribution) {
                        this.charts.feeDistribution.destroy();
                    }

                    const feeRanges = {
                        '0-50K': 0,
                        '50K-1L': 0,
                        '1L-1.5L': 0,
                        '1.5L-2L': 0,
                        '2L+': 0
                    };

                    data.forEach(row => {
                        const fee = parseInt(row[8]) || 0;
                        if (fee <= 50000) feeRanges['0-50K']++;
                        else if (fee <= 100000) feeRanges['50K-1L']++;
                        else if (fee <= 150000) feeRanges['1L-1.5L']++;
                        else if (fee <= 200000) feeRanges['1.5L-2L']++;
                        else feeRanges['2L+']++;
                    });

                    this.charts.feeDistribution = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: Object.keys(feeRanges),
                            datasets: [{
                                label: 'Number of Courses',
                                data: Object.values(feeRanges),
                                backgroundColor: this.colors.info[0],
                                borderColor: this.colors.info[1],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            ...this.baseOptions,
                            plugins: {
                                ...this.baseOptions.plugins,
                                title: {
                                    ...this.baseOptions.plugins.title,
                                    text: 'Fee Structure Distribution'
                                }
                            },
                            scales: {
                                x: {
                                    grid: {
                                        display: false
                                    },
                                    title: {
                                        display: true,
                                        text: 'Fee Ranges'
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Number of Courses'
                                    }
                                }
                            }
                        }
                    });
                }

                // Update charts and statistics
                updateChartsAndStats(getFilteredDataCallback, updateSummaryCallback) {
                    const filteredData = getFilteredDataCallback();
                    updateSummaryCallback(filteredData);
                    this.updateAllCharts(filteredData);
                }

                // Cleanup
                destroyAllCharts() {
                    Object.values(this.charts).forEach(chart => {
                        if (chart) chart.destroy();
                    });
                }
            }

            // Initialize the chart manager
            const chartManager = new ChartManager();

            // Update all charts and stats
            function updateChartsAndStats() {
                try {
                    console.log('Updating charts and stats...');
                    const filteredData = getFilteredData();
                    console.log('Filtered data length:', filteredData.length);
                    
                    if (!filteredData || filteredData.length === 0) {
                        console.warn('No data available for charts');
                        $('#errorMessage').html('No data available for visualization').show();
                        return;
                    }

                    updateSummary(filteredData);
                    chartManager.updateAllCharts(filteredData);
                    console.log('Charts and stats updated successfully');
                    $('#errorMessage').hide();
                } catch (error) {
                    console.error('Error updating charts:', error);
                    $('#errorMessage').html('Error updating visualizations: ' + error.message).show();
                }
            }

            // Handle cleanup when needed
            function cleanupCharts() {
                try {
                    chartManager.destroyAllCharts();
                    console.log('Charts cleaned up successfully');
                } catch (error) {
                    console.error('Error cleaning up charts:', error);
                }
            }

            // Add window error handler for Chart.js
            window.addEventListener('error', function(e) {
                if (e.error && e.error.toString().includes('Chart')) {
                    console.error('Chart.js error:', e.error);
                    $('#errorMessage').html('Chart error: ' + e.error.message).show();
                }
            });

            // Export for use in other modules
            if (typeof module !== 'undefined' && module.exports) {
                module.exports = { ChartManager, updateChartsAndStats, cleanupCharts };
            }
    });
    </script>
</body>

</html>