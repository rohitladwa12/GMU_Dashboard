<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Create database if not exists
    $conn_init = new mysqli('localhost', 'root', '');
    if ($conn_init->connect_error) {
        throw new Exception("Initial connection failed: " . $conn_init->connect_error);
    }
    
    $create_db = "CREATE DATABASE IF NOT EXISTS gmu";
    if (!$conn_init->query($create_db)) {
        throw new Exception("Failed to create database: " . $conn_init->error);
    }
    $conn_init->close();

    // Now connect to the database
    require_once 'db_connection.php';

    // First, let's check if the table exists
    $table_check = "SHOW TABLES LIKE '1_student_fee'";
    $table_result = $conn->query($table_check);
    
    // First get the total count
    $total_query = "SELECT COUNT(*) as total FROM 1_student_fee";
    $total_result = $conn->query($total_query);
    $total_count = $total_result->fetch_assoc()['total'];

    // Then get the detailed data
    $query = "SELECT 
        academic_year,
        college,
        programme,
        course,
        discipline,
        quota,
        COUNT(*) as total_seats,
        SUM(CASE WHEN REGULAR = 1 THEN 1 ELSE 0 END) as admitted_count,
        MAX(fees) as fees,
        (COUNT(*) * MAX(fees)) as expected_revenue,
        (SUM(CASE WHEN REGULAR = 1 THEN fees ELSE 0 END)) as actual_revenue,
        REGULAR as regular_status
    FROM 1_student_fee 
    GROUP BY 
        academic_year,
        college,
        programme,
        course,
        discipline,
        quota,
        REGULAR
    ORDER BY academic_year DESC, college ASC";

    $result = $conn->query($query);

    if (!$result) {
        throw new Exception("Query failed: " . $conn->error);
    }

    $data = array();
    while ($row = $result->fetch_assoc()) {
        // Ensure we have numeric values
        $total_seats = intval($row['total_seats']);
        $admitted_count = intval($row['admitted_count']);
        $fees = floatval($row['fees']);
        $expected_revenue = floatval($row['expected_revenue']);
        $actual_revenue = floatval($row['actual_revenue']);
        
        // Calculate fill rate
        $fill_rate = $total_seats > 0 ? ($admitted_count / $total_seats) * 100 : 0;
        
        $data[] = array(
            $row['academic_year'],
            $row['college'],
            $row['programme'],
            $row['course'],
            $row['discipline'],
            $row['quota'],
            $total_seats,
            $admitted_count,
            $fees,
            $expected_revenue,
            $actual_revenue,
            round($fill_rate, 2),
            intval($row['regular_status'])
        );
    }

    // Return the data in DataTables format with total count
    echo json_encode(array(
        "draw" => isset($_POST['draw']) ? intval($_POST['draw']) : 1,
        "recordsTotal" => count($data),
        "recordsFiltered" => count($data),
        "data" => $data,
        "totalStudents" => $total_count
    ));

} catch (Exception $e) {
    // Return error with debug information
    echo json_encode(array(
        "error" => true,
        "message" => $e->getMessage(),
        "debug" => [
            "mysql_error" => isset($conn) ? $conn->error : 'No connection',
            "connection_status" => isset($conn) && $conn->ping() ? 'Connected' : 'Disconnected',
            "query" => isset($query) ? $query : 'No query executed'
        ]
    ));
}

if (isset($conn)) {
    $conn->close();
}
?>