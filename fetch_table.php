<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/php_errors.log');

try {
    require_once 'db_connection.php';

    // Log the start of the request
    error_log("Processing fetch_table.php request");

    // Check if table exists
    $table_check = $conn->query("SHOW TABLES LIKE '1_student_fee'");
    if ($table_check->num_rows == 0) {
        throw new Exception("Table '1_student_fee' does not exist");
    }

    // Get the total count
    $total_result = $conn->query("SELECT COUNT(*) as total FROM 1_student_fee");
    if (!$total_result) {
        throw new Exception("Error getting total count: " . $conn->error);
    }
    $total_count = $total_result->fetch_assoc()['total'];

    error_log("Total records found: " . $total_count);

    // Main query for data
    $query = "SELECT 
        ACADEMIC_YEAR,
        COLLEGE,
        PROGRAMME,
        COURSE,
        DISCIPLINE,
        QUOTA,
        COUNT(*) as total_seats,
        SUM(CASE WHEN REGULAR = 1 THEN 1 ELSE 0 END) as admitted_count,
        MAX(TUITION_FEE + UNIVERSITY_FEE) as total_fees,
        (COUNT(*) * MAX(TUITION_FEE + UNIVERSITY_FEE)) as expected_revenue,
        SUM(CASE WHEN REGULAR = 1 THEN (TUITION_FEE + UNIVERSITY_FEE) ELSE 0 END) as actual_revenue,
        SUM(CASE WHEN REGULAR = 1 THEN total_payable ELSE 0 END) as total_payable,
        (SUM(CASE WHEN REGULAR = 1 THEN 1 ELSE 0 END) * 100.0 / COUNT(*)) as fill_rate,
        REGULAR as regular_status
    FROM 1_student_fee 
    GROUP BY 
        ACADEMIC_YEAR,
        COLLEGE,
        PROGRAMME,
        COURSE,
        DISCIPLINE,
        QUOTA,
        REGULAR
    ORDER BY ACADEMIC_YEAR DESC, COLLEGE ASC";

    error_log("Executing main query: " . $query);

    $result = $conn->query($query);
    if (!$result) {
        throw new Exception("Query failed: " . $conn->error);
    }

    $data = array();
    while ($row = $result->fetch_assoc()) {
        // Format numbers
        $data[] = array(
            $row['ACADEMIC_YEAR'],
            $row['COLLEGE'],
            $row['PROGRAMME'],
            $row['COURSE'],
            $row['DISCIPLINE'],
            $row['QUOTA'],
            intval($row['total_seats']),
            intval($row['admitted_count']),
            floatval($row['total_fees']),
            floatval($row['expected_revenue']),
            floatval($row['actual_revenue']),
            round(floatval($row['fill_rate']), 2),
            intval($row['regular_status'])
        );
    }

    error_log("Processed " . count($data) . " rows of data");

    // Return success response
    $response = array(
        "draw" => isset($_POST['draw']) ? intval($_POST['draw']) : 1,
        "recordsTotal" => $total_count,
        "recordsFiltered" => $total_count,
        "data" => $data,
        "error" => null
    );

    error_log("Sending response with " . count($data) . " records");
    echo json_encode($response);

} catch (Exception $e) {
    error_log("Error in fetch_table.php: " . $e->getMessage());
    
    // Return error response
    echo json_encode(array(
        "error" => true,
        "message" => $e->getMessage(),
        "debug" => array(
            "error_details" => $e->getTraceAsString(),
            "query" => isset($query) ? $query : null,
            "connection_status" => isset($conn) ? ($conn->ping() ? "Connected" : "Disconnected") : "No connection"
        )
    ));
}

if (isset($conn)) {
    $conn->close();
}
?>