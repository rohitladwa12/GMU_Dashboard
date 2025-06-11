<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admission Enquiry List - GMU Dashboard</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- jQuery FIRST -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/searchpanes/2.2.0/css/searchPanes.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.7.0/css/select.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

    <!-- DataTables JS -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/searchpanes/2.2.0/js/dataTables.searchPanes.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/select/1.7.0/js/dataTables.select.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #5B1F1F;
            --primary-hover: #8B3232;
            --secondary-color: #f8f9fa;
            --border-color: #e0e0e0;
            --text-color: #333;
            --shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            --border-radius: 8px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            background: #5B1F1F;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            color: var(--text-color);
            min-height: 100vh;
        }

        .content {
            padding: 30px;
            margin-left: 280px;
            margin-top: 60px;
            min-height: calc(100vh - 60px);
        }

        .page-header {
            background: var(--primary-color);
            padding: 30px;
            margin-bottom: 30px;
            border-left: 5px solid var(--primary-color);
        }

        .page-header h1 {
            background: linear-gradient(to left, #ecc35c, #f7f3b7, #ecc35c);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 10px 0;
            display: flex;
            align-items: center;
        }

        .page-header h1 i {
            margin-right: 15px;
            font-size: 24px;
            background: linear-gradient(to left, #ecc35c, #f7f3b7, #ecc35c);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .page-header p {
            background: linear-gradient(to left, #ecc35c, #f7f3b7, #ecc35c);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 0;
            font-size: 16px;
        }

        .table-container {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .table-header {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            color: white;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-header h3 {
            margin: 0;
            font-weight: 600;
            font-size: 18px;
        }

        .table-stats {
            display: flex;
            gap: 20px;
            font-size: 14px;
            opacity: 0.9;
        }

        .dataTables_wrapper {
            padding: 30px;
            background: white;
        }

        /* Search Panes Styling */
        .dtsp-searchPanes {
            background: var(--secondary-color);
            border-radius: var(--border-radius);
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid var(--border-color);
        }

        .dtsp-searchPane {
            background: white !important;
            border: 1px solid var(--border-color) !important;
            border-radius: var(--border-radius) !important;
            margin: 10px !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05) !important;
            min-width: 200px !important;
        }

        .dtsp-title {
            color: var(--primary-color) !important;
            font-weight: 700 !important;
            font-size: 14px !important;
            padding: 15px !important;
            background: var(--secondary-color) !important;
            border-bottom: 1px solid var(--border-color) !important;
        }

        .dtsp-clearAll,
        .dtsp-showAll {
            background: var(--primary-color) !important;
            color: white !important;
            border: none !important;
            border-radius: 4px !important;
            padding: 8px 16px !important;
            font-weight: 500 !important;
            transition: all 0.3s ease !important;
            margin: 5px !important;
        }

        .dtsp-clearAll:hover,
        .dtsp-showAll:hover {
            background: var(--primary-hover) !important;
            transform: translateY(-1px);
        }

        /* Button Styling */
        .dt-buttons {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .dt-button {
            background: var(--primary-color) !important;
            color: white !important;
            border: none !important;
            border-radius: 6px !important;
            padding: 10px 20px !important;
            font-weight: 500 !important;
            font-size: 14px !important;
            transition: all 0.3s ease !important;
            cursor: pointer !important;
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
        }

        .dt-button:hover {
            background: var(--primary-hover) !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(91, 31, 31, 0.3) !important;
        }

        .dt-button:before {
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
        }

        .buttons-copy:before {
            content: "\f0c5";
        }

        .buttons-csv:before {
            content: "\f1c3";
        }

        .buttons-excel:before {
            content: "\f1c3";
        }

        .buttons-print:before {
            content: "\f02f";
        }

        /* Search Box Styling */
        .dataTables_filter {
            margin-bottom: 20px;
        }

        .dataTables_filter label {
            font-weight: 500;
            color: var(--text-color);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .dataTables_filter input {
            border: 2px solid var(--border-color) !important;
            border-radius: 6px !important;
            padding: 10px 15px !important;
            font-size: 14px !important;
            transition: all 0.3s ease !important;
            width: 300px !important;
        }

        .dataTables_filter input:focus {
            border-color: var(--primary-color) !important;
            outline: none !important;
            box-shadow: 0 0 0 3px rgba(91, 31, 31, 0.1) !important;
        }

        /* Table Styling */
        table.dataTable {
            border-collapse: separate;
            border-spacing: 0;
            width: 100% !important;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        table.dataTable thead th {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            color: white;
            padding: 15px 12px !important;
            font-weight: 600 !important;
            font-size: 14px !important;
            border: none !important;
            text-align: left;
            position: relative;
        }

        table.dataTable thead th:first-child {
            border-top-left-radius: var(--border-radius);
        }

        table.dataTable thead th:last-child {
            border-top-right-radius: var(--border-radius);
        }

        table.dataTable tbody tr {
            transition: all 0.2s ease;
        }

        table.dataTable tbody tr:nth-child(even) {
            background: #fafbfc;
        }

        table.dataTable tbody tr:hover {
            background: #e8f4fd !important;
            transform: scale(1.01);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        table.dataTable tbody td {
            padding: 12px !important;
            border-bottom: 1px solid var(--border-color) !important;
            font-size: 14px;
            vertical-align: middle;
        }

        /* Pagination Styling */
        .dataTables_paginate {
            margin-top: 25px;
        }

        .dataTables_paginate .paginate_button {
            background: white !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-color) !important;
            border-radius: 6px !important;
            padding: 8px 12px !important;
            margin: 0 2px !important;
            transition: all 0.3s ease !important;
            font-weight: 500 !important;
        }

        .dataTables_paginate .paginate_button:hover {
            background: var(--primary-color) !important;
            color: white !important;
            border-color: var(--primary-color) !important;
            transform: translateY(-1px);
        }

        .dataTables_paginate .paginate_button.current {
            background: var(--primary-color) !important;
            color: white !important;
            border-color: var(--primary-color) !important;
        }

        /* Info and Length Styling */
        .dataTables_info,
        .dataTables_length {
            color: var(--text-color);
            font-weight: 500;
        }

        .dataTables_length select {
            border: 1px solid var(--border-color);
            border-radius: 4px;
            padding: 5px 10px;
            margin: 0 5px;
        }

        /* Loading Indicator */
        .dataTables_processing {
            background: white !important;
            border: 1px solid var(--border-color) !important;
            border-radius: var(--border-radius) !important;
            color: var(--primary-color) !important;
            font-weight: 600 !important;
            padding: 20px !important;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .content {
                margin-left: 0 !important;
                padding: 16px !important;
            }

            .sidebar {
                left: -250px;
                transition: left 0.3s cubic-bezier(.4, 0, .2, 1);
            }

            .sidebar.active {
                left: 0;
                box-shadow: 0 0 0 100vw rgba(0, 0, 0, 0.25);
            }

            .sidebar.collapsed {
                left: -90px;
            }

            .page-header {
                padding: 18px 10px;
            }

            .dataTables_wrapper {
                padding: 10px;
            }

            .dt-buttons {
                justify-content: center;
                flex-wrap: wrap;
                gap: 8px;
                width: 100%;
            }

            .dt-button {
                min-width: 110px;
                width: 45%;
                margin: 2px 0;
                font-size: 13px !important;
                padding: 10px 0 !important;
            }

            .dataTables_filter {
                width: 100%;
                margin-bottom: 14px;
            }

            .dataTables_filter label {
                flex-direction: column;
                align-items: stretch;
                gap: 4px;
            }

            .dataTables_filter input {
                width: 100% !important;
                min-width: 0 !important;
                font-size: 13px !important;
                padding: 8px 10px !important;
            }
        }

        @media (max-width: 600px) {
            .content {
                padding: 8px !important;
            }

            .table-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
                padding: 12px 8px;
            }

            .table-stats {
                gap: 8px;
                font-size: 12px;
            }

            .dataTables_wrapper {
                padding: 2px;
            }

            .dt-buttons {
                display: flex !important;
                flex-direction: row !important;
                flex-wrap: nowrap !important;
                gap: 8px !important;
                justify-content: center !important;
                align-items: center !important;
                margin-bottom: 14px !important;
            }

            .dt-button {
                width: 24% !important;
                min-width: 0 !important;
                max-width: 25% !important;
                font-size: 13px !important;
                padding: 10px 0 !important;
                margin: 0 !important;
                border-radius: 7px !important;
                background: #5B1F1F !important;
                color: #fff !important;
                box-shadow: 0 2px 8px rgba(91, 31, 31, 0.13) !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                gap: 6px !important;
                text-align: center !important;
            }

            .dt-button:before {
                font-size: 1em !important;
                margin-right: 6px !important;
            }

            .dataTables_filter label {
                font-size: 13px;
            }

            table.dataTable thead th,
            table.dataTable tbody td {
                padding: 8px 4px !important;
                font-size: 12px !important;
            }

            .dtsp-clearAll,
            .dtsp-showAll {
                display: inline-block !important;
                width: 48% !important;
                min-width: 0 !important;
                margin: 0 1% 0 0 !important;
                font-size: 13px !important;
                padding: 10px 0 !important;
                border-radius: 7px !important;
                background: #5B1F1F !important;
                color: #fff !important;
                text-align: center !important;
                box-shadow: 0 2px 8px rgba(91, 31, 31, 0.13) !important;
            }

            .dtsp-clearAll:last-child,
            .dtsp-showAll:last-child {
                margin-right: 0 !important;
            }

            .dataTables_paginate {
                margin-top: 12px !important;
                display: flex !important;
                justify-content: center !important;
                align-items: center !important;
                flex-wrap: wrap !important;
                gap: 0 !important;
            }

            .dataTables_paginate .paginate_button {
                min-width: 32px !important;
                height: 32px !important;
                padding: 0 !important;
                font-size: 13px !important;
                border-radius: 6px !important;
                margin: 0 2px 4px 2px !important;
                background: #fff !important;
                color: var(--primary-color) !important;
                border: 1px solid var(--border-color) !important;
                box-shadow: none !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                transition: background 0.2s, color 0.2s;
            }

            .dataTables_paginate .paginate_button.current {
                background: var(--primary-color) !important;
                color: #fff !important;
                border-color: var(--primary-color) !important;
            }

            .dataTables_paginate .paginate_button:hover {
                background: var(--primary-hover) !important;
                color: #fff !important;
                border-color: var(--primary-hover) !important;
            }

            .dataTables_paginate .ellipsis {
                min-width: 24px !important;
                font-size: 13px !important;
                color: #888 !important;
                background: transparent !important;
                border: none !important;
                box-shadow: none !important;
                padding: 0 2px !important;
            }
        }

        @media (max-width: 1024px) {
            .navbar-toggle {
                display: flex;
            }
        }

        /* Status Badges */
        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-active {
            background: #d4edda;
            color: #155724;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-inactive {
            background: #f8d7da;
            color: #721c24;
        }
    </style>
</head>

<body>
    <button class="navbar-toggle" aria-label="Toggle Sidebar">
        <i class="fas fa-bars"></i>
    </button>
    <?php include 'sidebar.php'; ?>
    <?php include 'navbar.php'; ?>

    <div class="content">
        <div class="page-header">
            <h1>
                <i class="fas fa-list-alt"></i>
                Admission Enquiry Management
            </h1>
            <p>Manage and track all admission enquiries with advanced filtering and export capabilities</p>
        </div>

        <div class="table-container">
            <div class="table-header">
                <h3><i class="fas fa-table"></i> Enquiry Records</h3>
                <div class="table-stats">
                    <span id="totalRecords">Total: 0</span>
                    <span id="filteredRecords">Showing: 0</span>
                </div>
            </div>

            <div class="dataTables_wrapper">
                <table id="enquiryTable" class="display responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Enquiry No</th>
                            <th>Source</th>
                            <th>Status</th>
                            <th>Admission Year</th>
                            <th>Enquiry Date</th>
                            <th>College</th>
                            <th>Programme</th>
                            <th>Course</th>
                            <th>Discipline</th>
                            <th>Name</th>
                            <th>Mobile No</th>
                            <th>Email</th>
                            <th>State</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be loaded via AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Initialize DataTable with professional configuration
            const table = $('#enquiryTable').DataTable({
                dom: 'PBfrtip',
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: 'fetch_enquiries.php',
                    type: 'POST',
                    dataType: 'json',
                    dataSrc: function (json) {
                        // Update stats
                        $('#totalRecords').text('Total: ' + (json.recordsTotal || 0));
                        $('#filteredRecords').text('Showing: ' + (json.recordsFiltered || 0));

                        // Ensure the response is properly structured
                        return Array.isArray(json.data) ? json.data : [];
                    },
                    error: function (xhr, error, code) {
                        console.error('AJAX Error:', error, code);
                        console.error('Response:', xhr.responseText);
                    }
                },
                searchPanes: {
                    layout: 'columns-2',
                    initCollapsed: true,
                    cascadePanes: false,
                    clear: true,
                    viewTotal: true,
                    threshold: 0.1, // Only show options appearing in 0.1% of records (200+ times)
                    emptyMessage: 'No data available for filtering',
                    columns: [1, 2, 3, 5, 6, 7, 8, 12], // All your columns
                    dtOpts: {
                        dom: 'tp',
                        searching: false,
                        paging: true,
                        pageLength: 50,
                        lengthChange: false,
                        info: false,
                        ordering: false,
                        deferRender: true, // Improve performance
                        scroller: true // Virtual scrolling for large lists
                    },
                    orthogonal: {
                        display: 'display',
                        sort: 'sort',
                        search: 'filter',
                        type: 'type'
                    }
                },
                buttons: [
                    {
                        extend: 'copy',
                        text: 'Copy',
                        className: 'btn-copy'
                    },
                    {
                        extend: 'csv',
                        text: 'CSV',
                        className: 'btn-csv'
                    },
                    {
                        extend: 'excel',
                        text: 'Excel',
                        className: 'btn-excel',
                        title: 'Admission Enquiries - ' + new Date().toLocaleDateString()
                    },
                    {
                        extend: 'print',
                        text: 'Print',
                        className: 'btn-print',
                        title: 'GMU - Admission Enquiries'
                    }
                ],
                columns: [
                    {
                        data: 'enquiry_no',
                        title: 'Enquiry No',
                        className: 'font-weight-bold'
                    },
                    {
                        data: 'source',
                        title: 'Source',
                        render: function (data, type, row) {
                            // Optimize for SearchPanes
                            if (type === 'filter' || type === 'sort') {
                                return data ? data.toString().trim() : '';
                            }
                            return data;
                        }
                    },
                    {
                        data: 'status',
                        title: 'Status',
                        render: function (data, type, row) {
                            if (type === 'filter' || type === 'sort') {
                                return data ? data.toString().trim() : '';
                            }
                            if (type === 'display') {
                                const statusClass = data && data.toLowerCase() === 'active' ? 'status-active' :
                                    data && data.toLowerCase() === 'pending' ? 'status-pending' : 'status-inactive';
                                return `<span class="status-badge ${statusClass}">${data || ''}</span>`;
                            }
                            return data;
                        }
                    },
                    {
                        data: 'admission_year',
                        title: 'Admission Year',
                        render: function (data, type, row) {
                            if (type === 'filter' || type === 'sort') {
                                return data ? data.toString() : '';
                            }
                            return data;
                        }
                    },
                    {
                        data: 'enquiry_date',
                        title: 'Enquiry Date',
                        render: function (data, type, row) {
                            if (type === 'display' && data) {
                                return new Date(data).toLocaleDateString('en-IN');
                            }
                            return data;
                        }
                    },
                    {
                        data: 'college',
                        title: 'College',
                        render: function (data, type, row) {
                            if (type === 'filter' || type === 'sort') {
                                return data ? data.toString().trim() : '';
                            }
                            return data;
                        }
                    },
                    {
                        data: 'programme',
                        title: 'Programme',
                        render: function (data, type, row) {
                            if (type === 'filter' || type === 'sort') {
                                return data ? data.toString().trim() : '';
                            }
                            return data;
                        }
                    },
                    {
                        data: 'course',
                        title: 'Course',
                        render: function (data, type, row) {
                            if (type === 'filter' || type === 'sort') {
                                return data ? data.toString().trim() : '';
                            }
                            return data;
                        }
                    },
                    {
                        data: 'discipline',
                        title: 'Discipline',
                        render: function (data, type, row) {
                            if (type === 'filter' || type === 'sort') {
                                return data ? data.toString().trim() : '';
                            }
                            return data;
                        }
                    },
                    { data: 'name', title: 'Name' },
                    {
                        data: 'mobile_no',
                        title: 'Mobile No',
                        render: function (data, type, row) {
                            if (type === 'display' && data) {
                                return `<a href="tel:${data}" style="color: var(--primary-color); text-decoration: none;">${data}</a>`;
                            }
                            return data;
                        }
                    },
                    {
                        data: 'email',
                        title: 'Email',
                        render: function (data, type, row) {
                            if (type === 'display' && data) {
                                return `<a href="mailto:${data}" style="color: var(--primary-color); text-decoration: none;">${data}</a>`;
                            }
                            return data;
                        }
                    },
                    {
                        data: 'state',
                        title: 'State',
                        render: function (data, type, row) {
                            if (type === 'filter' || type === 'sort') {
                                return data ? data.toString().trim() : '';
                            }
                            return data;
                        }
                    }
                ],
                columnDefs: [
                    {
                        searchPanes: {
                            show: true,
                            initCollapsed: true,
                            threshold: 0.1, // Individual column threshold
                            emptyMessage: 'No options available'
                        },
                        targets: [1, 2, 3, 5, 6, 7, 8, 12] // Source, Status, Admission Year, College, Programme, Course, Discipline, State
                    },
                    {
                        searchPanes: {
                            show: false
                        },
                        targets: [0, 4, 9, 10, 11] // Enquiry No, Date, Name, Mobile, Email
                    }
                ],
                pageLength: 25,
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                order: [[0, 'desc']],
                language: {
                    processing: '<i class="fas fa-spinner fa-spin"></i> Loading data...',
                    emptyTable: 'No enquiries found',
                    info: 'Showing _START_ to _END_ of _TOTAL_ enquiries',
                    infoEmpty: 'No enquiries to show',
                    infoFiltered: '(filtered from _MAX_ total enquiries)',
                    lengthMenu: 'Show _MENU_ enquiries per page',
                    search: '<i class="fas fa-search"></i> Search:',
                    paginate: {
                        first: '<i class="fas fa-angle-double-left"></i>',
                        last: '<i class="fas fa-angle-double-right"></i>',
                        next: '<i class="fas fa-angle-right"></i>',
                        previous: '<i class="fas fa-angle-left"></i>'
                    },
                    searchPanes: {
                        clearMessage: 'Clear All',
                        collapse: { 0: 'SearchPanes', _: 'SearchPanes (%d)' },
                        count: '{total}',
                        countFiltered: '{shown} ({total})',
                        emptyPanes: 'Loading filters...',
                        loadMessage: 'Loading SearchPanes...',
                        title: 'Filters Active - %d'
                    }
                },
                stateSave: true,
                stateDuration: 60 * 60 * 24, // 24 hours
                deferRender: true, // Improve performance with large datasets
                initComplete: function (settings, json) {
                    console.log('DataTables initialized successfully');
                    // Initialize stats if data is available
                    if (json) {
                        $('#totalRecords').text('Total: ' + (json.recordsTotal || 0));
                        $('#filteredRecords').text('Showing: ' + (json.recordsFiltered || 0));
                    }
                }
            });

            // Update stats on each draw
            table.on('draw', function (e, settings) {
                const info = table.page.info();
                $('#filteredRecords').text('Showing: ' + info.recordsDisplay);
                console.log('Table redrawn - showing', info.recordsDisplay, 'of', info.recordsTotal, 'records');
            });

            // Handle responsive menu toggle (for mobile)
            $(document).on('click', '.navbar-toggle', function () {
                $('.sidebar').toggleClass('active');
            });
            // Close sidebar when clicking outside on mobile
            $(document).on('click touchstart', function (e) {
                if ($(window).width() <= 1024) {
                    if (!$(e.target).closest('.sidebar, .navbar-toggle').length && $('.sidebar').hasClass('active')) {
                        $('.sidebar').removeClass('active');
                    }
                }
            });
        });
    </script>
</body>

</html>