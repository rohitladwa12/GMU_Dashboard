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
            padding: 2rem;
            border-radius: 20px;
            background: var(--dark-brown);
            color: var(--off-white);
            margin: 1rem;
            font-weight: 600;
            box-shadow: var(--card-shadow);
            height: 250px;
            /* Ensures equal height for all cards */
            width: 100%;
            /* Makes cards responsive */
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(236, 195, 92, 0.2);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .stat-card h3 {
            background: var(--primary-gold);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 2rem;
            /* Adjusted for better visual balance */
            margin-bottom: 0.5rem;
            font-weight: 700;
        }

        .stat-card p {
            color: var(--off-white);
            font-size: 1rem;
            /* Slightly larger for readability */
            margin: 0;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .chart-container {
            position: relative;
            height: 400px;
            width: 100%;
            padding: 1rem;
            background: white;
            border-radius: 15px;
        }

        .chart-container canvas {
            max-height: 100% !important;
            border-radius: 15px;
            background: white;
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

        .stat-card {
            background-color: rgba(91, 31, 31, 0.8);
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            color: #f7f3b7;
            margin: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .stat-card h3 {
            font-size: 1.8rem;
            margin-bottom: 10px;
            font-weight: bold;
            color: #ecc35c;
        }

        .stat-card p {
            margin: 0;
            font-size: 1rem;
            color: #ffffff;
        }

        .stat-card i {
            margin-right: 5px;
            color: #ecc35c;
        }

        .dashboard-card {
            background-color: rgba(91, 31, 31, 0.8);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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
            <div class="row mb-4">
                <div class="col">
                    <div class="stat-card">
                        <h3 id="totalIntake">0</h3>
                        <p><i class="fas fa-users"></i> Total Intake</p>
                    </div>
                </div>
                <div class="col">
                    <div class="stat-card">
                        <h3 id="totalAdmitted">0</h3>
                        <p><i class="fas fa-user-graduate"></i> Students Admitted</p>
                    </div>
                </div>
                <div class="col">
                    <div class="stat-card">
                        <h3 id="totalPayable">₹0</h3>
                        <p><i class="fas fa-money-check-alt"></i> Expected Revenue</p>
                    </div>
                </div>
                <div class="col">
                    <div class="stat-card">
                        <h3 id="totalRevenue">₹0</h3>
                        <p><i class="fas fa-rupee-sign"></i> Actual Revenue</p>
                    </div>
                </div>
                <div class="col">
                    <div class="stat-card">
                        <h3 id="totalBalance">₹0</h3>
                        <p><i class="fas fa-wallet"></i> Total Balance</p>
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
                        <h5><i class="fas fa-chart-pie"></i> Quota Distribution</h5>
                        <div class="chart-container">
                            <canvas id="quotaPolarChart"></canvas>
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
                        <h5><i class="fas fa-chart-radar"></i> Programme Performance Analysis</h5>
                        <div class="chart-container">
                            <canvas id="programmeRadarChart"></canvas>
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
                                        <th>Total Seats</th>
                                        <th>Admitted</th>
                                        <th>Total Fees</th>
                                        <th>Expected Revenue</th>
                                        <th>Actual Revenue</th>
                                        <th>Total Payable</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
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
                dom: 'Bfrtip',
                processing: true,
                serverSide: false,
                ajax: {
                    url: 'fetch_table.php',
                    type: 'POST',
                    dataSrc: function(json) {
                        console.log('Server Response:', json);
                        
                        // Hide loading overlay
                        $('#loadingOverlay').hide();
                        
                        // Check for errors
                        if (json.error) {
                            console.error('Data fetch error:', json.message);
                            $('#errorMessage').html('Error loading data: ' + json.message).show();
                            return [];
                        }
                        
                        // Validate data structure
                        if (!json.data || !Array.isArray(json.data)) {
                            console.error('Invalid data format:', json);
                            $('#errorMessage').html('Invalid data format received').show();
                            return [];
                        }
                        
                        // Log data details
                        console.log('Data received:', {
                            totalRecords: json.recordsTotal,
                            filteredRecords: json.recordsFiltered,
                            dataLength: json.data.length,
                            firstRecord: json.data[0] || null
                        });
                        
                        // Store data for filtering
                        window.fullData = json.data;
                        
                        // Hide error message if everything is OK
                        $('#errorMessage').hide();
                        
                        // Update summary statistics
                        updateSummary(json.data);
                        
                        // Update charts
                        if (typeof chartManager !== 'undefined') {
                            chartManager.updateAllCharts(json.data);
                        }
                        
                        return json.data;
                    },
                    error: function(xhr, error, thrown) {
                        $('#loadingOverlay').hide();
                        console.error('AJAX Error:', {
                            error: error,
                            thrown: thrown,
                            status: xhr.status,
                            response: xhr.responseText
                        });
                        $('#errorMessage').html('Failed to load data: ' + error).show();
                    }
                },
                columns: [
                    { data: 0, name: 'ACADEMIC_YEAR' },
                    { data: 1, name: 'COLLEGE' },
                    { data: 2, name: 'PROGRAMME' },
                    { data: 3, name: 'COURSE' },
                    { data: 4, name: 'DISCIPLINE' },
                    { data: 5, name: 'QUOTA' },
                    { 
                        data: 6,
                        name: 'total_seats',
                        render: function(data) {
                            return parseInt(data).toLocaleString('en-IN');
                        }
                    },
                    { 
                        data: 7,
                        name: 'admitted_count',
                        render: function(data) {
                            return parseInt(data).toLocaleString('en-IN');
                        }
                    },
                    { 
                        data: 8,
                        name: 'total_fees',
                        render: function(data) {
                            return '₹' + parseInt(data).toLocaleString();
                        }
                    },
                    { 
                        data: 9,
                        name: 'expected_revenue',
                        render: function(data) {
                            return '₹' + parseInt(data).toLocaleString();
                        }
                    },
                    { 
                        data: 10,
                        name: 'fee_paid',
                        render: function(data) {
                            return '₹' + parseInt(data).toLocaleString();
                        }
                    },
                    { 
                        data: 11,
                        name: 'fee_payable',
                        render: function(data) {
                            return '₹' + parseInt(data).toLocaleString();
                        }
                    },
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
                                exportOptions: { columns: ':visible' }
                            },
                            {
                                extend: 'csv',
                                text: '<i class="fas fa-file-csv"></i> CSV',
                                className: 'btn-sm',
                                exportOptions: { columns: ':visible' }
                            },
                            {
                                extend: 'print',
                                text: '<i class="fas fa-print"></i> Print',
                                className: 'btn-sm',
                                exportOptions: { columns: ':visible' }
                            }
                        ]
                    },
                    {
                        extend: 'colvis',
                        text: '<i class="fas fa-columns"></i> Columns',
                        className: 'btn-custom'
                    }
                ],
                pageLength: 10,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                order: [[0, 'desc'], [1, 'asc']],
                responsive: true,
                language: {
                    processing: '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>',
                    emptyTable: 'No data available',
                    zeroRecords: 'No matching records found',
                    info: 'Showing _START_ to _END_ of _TOTAL_ entries',
                    infoEmpty: 'Showing 0 to 0 of 0 entries',
                    infoFiltered: '(filtered from _MAX_ total entries)'
                },
                initComplete: function(settings, json) {
                    if (!json || json.error) {
                        console.error('Error initializing table:', json);
                        $('#errorMessage').html('Error initializing table: ' + (json ? json.message : 'Unknown error')).show();
                    } else {
                        console.log('Table initialized successfully');
                        if (json.data && json.data.length > 0) {
                            populateFilters(json.data);
                            updateChartsAndStats();
                        } else {
                            $('#errorMessage').html('No data available').show();
                        }
                    }
                    $('#loadingOverlay').hide();
                }
            });

            // Initialize SearchPanes
            new $.fn.dataTable.SearchPanes(table, {
                layout: 'columns-3',
                initCollapsed: true,
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
            $('#yearFilter, #collegeFilter, #programmeFilter').on('change', function () {
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

                // Add data validation and debug logging
                console.log('Processing data for statistics:', filteredData.slice(0, 3));

                // Calculate statistics with validation
                const totalIntake = filteredData.reduce((sum, row) => {
                    if (!row || !Array.isArray(row)) {
                        console.warn('Invalid row data:', row);
                        return sum;
                    }
                    const seats = parseInt(row[6]);
                    if (isNaN(seats)) {
                        console.warn('Invalid total seats value:', row[6], 'in row:', row);
                        return sum;
                    }
                    return sum + Math.max(0, seats); // Ensure non-negative
                }, 0);

                const totalAdmitted = filteredData.reduce((sum, row) => {
                    if (!row || !Array.isArray(row)) return sum;
                    const admitted = parseInt(row[7]);
                    if (isNaN(admitted)) return sum;
                    return sum + Math.max(0, admitted);
                }, 0);

                const totalRevenue = filteredData.reduce((sum, row) => {
                    if (!row || !Array.isArray(row)) return sum;
                    const totalPaid = parseInt(row[10]); // Using TOTAL_PAID column
                    if (isNaN(totalPaid)) {
                        console.warn('Invalid total paid value:', row[10], 'in row:', row);
                        return sum;
                    }
                    return sum + Math.max(0, totalPaid);
                }, 0);

                const totalPayable = filteredData.reduce((sum, row) => {
                    if (!row || !Array.isArray(row)) return sum;
                    const totalPayable = parseInt(row[9]); // Using TOTAL_PAYABLE column
                    if (isNaN(totalPayable)) {
                        console.warn('Invalid total payable value:', row[9], 'in row:', row);
                        return sum;
                    }
                    return sum + Math.max(0, totalPayable);
                }, 0);
                
                // Calculate total balance (expected revenue - actual revenue, showing positive values only)
                const totalBalance = filteredData.reduce((sum, row) => {
                    const expectedRevenue = parseInt(row[9]); // TOTAL_PAYABLE
                    const actualRevenue = parseInt(row[10]); // TOTAL_PAID
                    if (isNaN(expectedRevenue) || isNaN(actualRevenue)) {
                        console.warn('Invalid revenue values:', { expected: row[9], actual: row[10], row });
                        return sum;
                    }
                    const balance = Math.max(0, expectedRevenue - actualRevenue); // Only consider positive balances
                    return sum + balance;
                }, 0);

                // Log the values for debugging
                console.log('Statistics Update:', {
                    totalIntake,
                    totalAdmitted,
                    totalRevenue,
                    totalPayable,
                    totalBalance,
                    filteredDataLength: filteredData.length
                });

                // Log final calculated values for verification
                console.log('Final calculated values:', {
                    totalIntake,
                    totalAdmitted,
                    totalRevenue,
                    totalPayable,
                    totalBalance,
                    'intake/admitted ratio': totalIntake > 0 ? (totalAdmitted / totalIntake * 100).toFixed(1) + '%' : 'N/A'
                });

                // Update the display with animations and validation
                if (totalIntake >= 0) animateNumber('#totalIntake', totalIntake);
                if (totalAdmitted >= 0) animateNumber('#totalAdmitted', totalAdmitted);
                if (totalRevenue >= 0) animateNumber('#totalRevenue', totalRevenue, true);
                if (totalPayable >= 0) animateNumber('#totalPayable', totalPayable, true);
                if (totalBalance >= 0) animateNumber('#totalBalance', totalBalance, true);
            }

            function animateNumber(elementId, finalValue, isCurrency = false) {
                const $element = $(elementId);
                const startValue = parseInt($element.text().replace(/[^0-9]/g, '')) || 0;
                const duration = 1000;
                const steps = 50;
                const increment = (finalValue - startValue) / steps;
                let currentStep = 0;                    // Function to format numbers in Indian style with proper grouping
                const formatIndianCurrency = (number) => {
                    const numStr = Math.abs(number).toString();
                    if (numStr.length <= 3) return '₹' + numStr;
                    
                    let lastThree = numStr.substring(numStr.length - 3);
                    let otherNumbers = numStr.substring(0, numStr.length - 3);
                    if (otherNumbers !== '') {
                        lastThree = ',' + lastThree;
                    }
                    let formattedNumber = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree;
                    return '₹' + formattedNumber;
                };

                const timer = setInterval(() => {
                    currentStep++;
                    const currentValue = Math.floor(startValue + (increment * currentStep));
                    
                    if (isCurrency) {
                        $element.text(formatIndianCurrency(currentValue));
                    } else {
                        $element.text(currentValue.toLocaleString('en-IN'));
                    }

                    if (currentStep >= steps) {
                        clearInterval(timer);
                        if (isCurrency) {
                            $element.text(formatIndianCurrency(finalValue));
                        } else {
                            $element.text(finalValue.toLocaleString('en-IN'));
                        }
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
                        backgroundColor: 'white',
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    padding: 20,
                                    font: {
                                        family: "'Segoe UI', Arial, sans-serif",
                                        size: 12,
                                        weight: 500
                                    },
                                    color: '#333'
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
                                expected: parseInt(row[9]) || 0,  // Using TOTAL_PAYABLE as expected revenue
                                actual: parseInt(row[10]) || 0    // Using TOTAL_PAID as actual revenue
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
                                    type: 'bar',
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                return 'Expected Revenue: ₹' + context.parsed.y.toLocaleString();
                                            }
                                        }
                                    }
                                },
                                {
                                    label: 'Actual Revenue',
                                    data: actualData,
                                    backgroundColor: this.colors.success[0],
                                    borderColor: this.colors.success[1],
                                    borderWidth: 1,
                                    type: 'bar',
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                return 'Actual Revenue: ₹' + context.parsed.y.toLocaleString();
                                            }
                                        }
                                    }
                                }
                            ]
                        },
                        options: {
                            ...this.baseOptions,
                            plugins: {
                                ...this.baseOptions.plugins,
                                title: {
                                    ...this.baseOptions.plugins.title,
                                    text: 'Fee Collection Analysis by Year'
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
                                                return '₹' + (value / 10000000).toFixed(2) + ' Cr';
                                            } else if (value >= 100000) {
                                                return '₹' + (value / 100000).toFixed(2) + ' L';
                                            } else if (value >= 1000) {
                                                return '₹' + (value / 1000).toFixed(2) + ' K';
                                            }
                                            return '₹' + value.toLocaleString('en-IN');
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

                // 5. Fill Rate Gauge Chart
                updateFillRateBarChart(data) {
                    const ctx = document.getElementById('fillRateChart');
                    if (!ctx) return;

                    if (this.charts.fillRateBar) {
                        this.charts.fillRateBar.destroy();
                    }

                    const courseData = {};
                    data.forEach(row => {
                        const course = row[3];
                        const admitted = parseInt(row[7]) || 0;
                        const intake = parseInt(row[6]) || 0;
                        const fillRate = intake > 0 ? (admitted / intake * 100) : 0;
                        
                        if (!courseData[course] || courseData[course].fillRate < fillRate) {
                            courseData[course] = {
                                fillRate,
                                admitted,
                                intake
                            };
                        }
                    });

                    // Get top 8 courses by fill rate for better visualization
                    const sortedCourses = Object.entries(courseData)
                        .sort((a, b) => b[1].fillRate - a[1].fillRate)
                        .slice(0, 8);

                    const labels = sortedCourses.map(([course]) => course);
                    const fillRates = sortedCourses.map(([, data]) => data.fillRate);
                    const admitted = sortedCourses.map(([, data]) => data.admitted);
                    const intake = sortedCourses.map(([, data]) => data.intake);

                    this.charts.fillRateBar = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [
                                {
                                    label: 'Fill Rate',
                                    data: fillRates,
                                    backgroundColor: fillRates.map(rate => {
                                        const alpha = Math.min(rate / 100, 1); // Opacity based on fill rate
                                        return rate >= 90 ? `rgba(40, 167, 69, ${alpha})` :
                                               rate >= 70 ? `rgba(255, 159, 64, ${alpha})` :
                                               `rgba(220, 53, 69, ${alpha})`;
                                    }),
                                    borderColor: fillRates.map(rate =>
                                        rate >= 90 ? this.colors.success[1] :
                                        rate >= 70 ? this.colors.warning[1] :
                                        this.colors.danger[1]
                                    ),
                                    borderWidth: 2,
                                    barPercentage: 0.8,
                                    categoryPercentage: 0.9
                                }
                            ]
                        },
                        options: {
                            ...this.baseOptions,
                            indexAxis: 'y',
                            plugins: {
                                ...this.baseOptions.plugins,
                                title: {
                                    ...this.baseOptions.plugins.title,
                                    text: 'Course Fill Rate Analysis',
                                    color: '#333'
                                },
                                datalabels: {
                                    align: 'end',
                                    anchor: 'end',
                                    offset: 4,
                                    color: '#333',
                                    font: {
                                        weight: 'bold',
                                        size: 11
                                    },
                                    formatter: (value, ctx) => {
                                        const index = ctx.dataIndex;
                                        return `${value.toFixed(1)}% (${admitted[index]}/${intake[index]})`;
                                    }
                                },
                                tooltip: {
                                    callbacks: {
                                        label: (context) => {
                                            const index = context.dataIndex;
                                            return [
                                                `Fill Rate: ${context.parsed.x.toFixed(1)}%`,
                                                `Admitted: ${admitted[index]}`,
                                                `Total Seats: ${intake[index]}`
                                            ];
                                        }
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    beginAtZero: true,
                                    max: 100,
                                    grid: {
                                        color: '#e0e0e0'
                                    },
                                    ticks: {
                                        color: '#333',
                                        callback: value => value + '%'
                                    },
                                    title: {
                                        display: true,
                                        text: 'Fill Rate',
                                        color: '#333'
                                    }
                                },
                                y: {
                                    grid: {
                                        display: false
                                    },
                                    ticks: {
                                        color: '#333',
                                        font: {
                                            weight: '500'
                                        }
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
            window.addEventListener('error', function (e) {
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

        // Debug information
        $(document).ready(function() {
            // Test database connection
            $.ajax({
                url: 'check_connection.php',
                type: 'GET',
                success: function(response) {
                    console.log('Database connection test:', response);
                },
                error: function(xhr, status, error) {
                    console.error('Database connection test failed:', error);
                }
            });

            // Log DataTables version
            console.log('DataTables version:', $.fn.dataTable.version);
            
            // Monitor AJAX requests
            $(document).ajaxSend(function(event, xhr, settings) {
                console.log('AJAX request sent:', settings.url);
            });
            
            $(document).ajaxComplete(function(event, xhr, settings) {
                console.log('AJAX request completed:', settings.url, xhr.status);
                console.log('Response:', xhr.responseText);
            });
            
            $(document).ajaxError(function(event, xhr, settings, error) {
                console.error('AJAX error:', settings.url, error);
                console.error('Response:', xhr.responseText);
            });
        });

        // Add this debugging section before closing body tag
        $(document).ready(function() {
            // Log DataTables version
            console.log('DataTables version:', $.fn.dataTable.version);
            
            // Test data fetching
            $.ajax({
                url: 'fetch_table.php',
                type: 'POST',
                success: function(response) {
                    console.log('Direct fetch test response:', response);
                    if (response.error) {
                        console.error('Fetch error:', response.message);
                    } else if (!response.data || !Array.isArray(response.data)) {
                        console.error('Invalid data format:', response);
                    } else {
                        console.log('Data fetch successful, records:', response.data.length);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Fetch test failed:', error);
                    console.error('Status:', status);
                    console.error('Response:', xhr.responseText);
                }
            });
            
            // Monitor all AJAX requests
            $(document).ajaxSend(function(event, xhr, settings) {
                console.log('AJAX request sent:', settings.url);
            });
            
            $(document).ajaxComplete(function(event, xhr, settings) {
                console.log('AJAX request completed:', settings.url);
                try {
                    const response = JSON.parse(xhr.responseText);
                    console.log('Response data structure:', {
                        hasError: 'error' in response,
                        hasData: 'data' in response,
                        dataLength: response.data ? response.data.length : 0,
                        firstRecord: response.data && response.data.length > 0 ? response.data[0] : null
                    });
                } catch (e) {
                    console.error('Failed to parse response:', xhr.responseText);
                }
            });
            
            $(document).ajaxError(function(event, xhr, settings, error) {
                console.error('AJAX error:', settings.url, error);
                console.error('Response:', xhr.responseText);
            });
        });

        $(document).ready(function () {
            $('#example').DataTable({
                dom: 'Pfrtip', // Enables Search Panes
                searchPanes: {
                    cascadePanes: true,
                    viewTotal: true
                }
            });
        });
    </script>
</body>

</html>