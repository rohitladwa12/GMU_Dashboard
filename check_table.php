<?php
require_once 'db_connection.php';

// Get table structure
$structure_query = "DESCRIBE 1_student_fee";
$structure_result = $conn->query($structure_query);

echo "<h2>Table Structure:</h2>";
if ($structure_result) {
    echo "<pre>";
    while ($row = $structure_result->fetch_assoc()) {
        print_r($row);
    }
    echo "</pre>";
} else {
    echo "Error getting table structure: " . $conn->error;
}

// Get sample data
$sample_query = "SELECT * FROM 1_student_fee LIMIT 1";
$sample_result = $conn->query($sample_query);

echo "<h2>Sample Data:</h2>";
if ($sample_result) {
    echo "<pre>";
    while ($row = $sample_result->fetch_assoc()) {
        print_r($row);
    }
    echo "</pre>";
} else {
    echo "Error getting sample data: " . $conn->error;
}

// Get count of records
$count_query = "SELECT COUNT(*) as total FROM 1_student_fee";
$count_result = $conn->query($count_query);

echo "<h2>Total Records:</h2>";
if ($count_result) {
    $count = $count_result->fetch_assoc();
    echo "<pre>";
    echo "Total records: " . $count['total'];
    echo "</pre>";
} else {
    echo "Error getting record count: " . $conn->error;
}

$conn->close();
?> 