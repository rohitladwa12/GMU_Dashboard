<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GMU Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DataTables JS -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
        }

        .dashboard-title h1 {
            font-size: 34px;
            font-weight: 600;
            margin-bottom: 40px;
            margin-top: 60px;
        }

        .card h2 {
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 15px;
        }

        .card p {
            font-size: 14px;
            font-weight: 400;
            margin: 10px 0;
        }

        .chart-text h3 {
            font-size: 14px;
            font-weight: 500;
            margin: 10px 0;
        }

        /* DataTables customization */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_processing,
        .dataTables_wrapper .dataTables_paginate {
            font-size: 14px;
        }

        .dataTables_wrapper .dt-buttons button {
            font-size: 14px;
        }

        table.dataTable thead th,
        table.dataTable tbody td {
            font-size: 14px;
        }

        /* Chart.js tooltip customization */
        Chart.defaults.font.size=14;
        Chart.defaults.font.family="'Poppins', sans-serif";
    </style>
</head>

<body>
    <!-- Include Navbar -->
    <?php include 'navbar.php'; ?>

    <!-- Include Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <div class="content">
        <div class="dashboard-title">
            <h1>Dashboard Overview</h1>
        </div>

        <!-- Dashboard Cards -->
        <div class="dashboard-cards">
            <div class="card">
                <h2>Total Students</h2>
                <div class="progress-container">
                    <div class="progress-bar" data-progress="75">
                        <div class="progress-indicator"></div>
                    </div>
                </div>
                <p>1,500</p>
            </div>
            <div class="card">
                <h2>Total Teachers</h2>
                <div class="progress-container">
                    <div class="progress-bar" data-progress="85">
                        <div class="progress-indicator"></div>
                    </div>
                </div>
                <p>120</p>
            </div>
            <div class="card">
                <h2>Departments</h2>
                <div class="progress-container">
                    <div class="progress-bar" data-progress="60">
                        <div class="progress-indicator"></div>
                    </div>
                </div>
                <p>8</p>
            </div>
            <div class="card">
                <h2>Revenue</h2>
                <div class="progress-container">
                    <div class="progress-bar" data-progress="90">
                        <div class="progress-indicator"></div>
                    </div>
                </div>
                <p>$250,000</p>
            </div>
        </div>

        <!-- Charts Section with Data Tables -->
        <div class="charts-container">
            <!-- University Survey Chart -->
            <div class="chart-container">
                <canvas id="universitysurveyChart"></canvas>
                <div class="chart-text">
                    <h3>University Survey</h3>
                </div>
            </div>

            <!-- New Admissions Chart -->
            <div class="chart-container">
                <canvas id="newadmissionsChart"></canvas>
                <div class="chart-text">
                    <h3>New Admissions</h3>
                </div>
            </div>

            <!-- Student Results Chart -->
            <div class="chart-container">
                <canvas id="studentresultChart"></canvas>
                <div class="chart-text">
                    <h3>Student Results</h3>
                </div>
            </div>

            <!-- Student Performance Chart -->
            <div class="chart-container">
                <canvas id="studentperformanceChart"></canvas>
                <div class="chart-text">
                    <h3>Student Performance</h3>
                </div>
            </div>

            <!-- Research Publications Chart -->
            <div class="chart-container">
                <canvas id="newChart"></canvas>
                <div class="chart-text">
                    <h3>Research Publications</h3>
                </div>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>