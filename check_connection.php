<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    require_once 'db_connection.php';
    
    // Test the connection
    if ($conn->ping()) {
        $result = array(
            'status' => 'success',
            'message' => 'Database connection successful',
            'database' => 'gmu',
            'server_info' => $conn->server_info,
            'charset' => $conn->character_set_name()
        );
    } else {
        throw new Exception("Database connection lost");
    }
    
    // Check if table exists
    $table_check = $conn->query("SHOW TABLES LIKE '1_student_fee'");
    $result['table_exists'] = $table_check->num_rows > 0;
    
    // Get record count if table exists
    if ($result['table_exists']) {
        $count_query = $conn->query("SELECT COUNT(*) as count FROM 1_student_fee");
        $count = $count_query->fetch_assoc();
        $result['record_count'] = $count['count'];
    }
    
    echo json_encode($result);
    
} catch (Exception $e) {
    echo json_encode(array(
        'status' => 'error',
        'message' => $e->getMessage(),
        'error_details' => error_get_last()
    ));
}

if (isset($conn)) {
    $conn->close();
}
?> 