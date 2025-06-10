<?php
require_once 'db_connection.php';

// Create table if not exists
$create_table = "CREATE TABLE IF NOT EXISTS 1_student_fee (
    id INT AUTO_INCREMENT PRIMARY KEY,
    academic_year VARCHAR(10) NOT NULL,
    college VARCHAR(100) NOT NULL,
    programme VARCHAR(100) NOT NULL,
    course VARCHAR(100) NOT NULL,
    discipline VARCHAR(100) NOT NULL,
    quota VARCHAR(50) NOT NULL,
    fees DECIMAL(10,2) NOT NULL,
    REGULAR BOOLEAN DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($create_table)) {
    echo "Table created or already exists successfully<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

// Check if table is empty
$count_query = "SELECT COUNT(*) as count FROM 1_student_fee";
$count_result = $conn->query($count_query);
$count = $count_result->fetch_assoc()['count'];

// Insert sample data if table is empty
if ($count == 0) {
    $sample_data = "INSERT INTO 1_student_fee (academic_year, college, programme, course, discipline, quota, fees, REGULAR) VALUES
    ('2023-24', 'Engineering College', 'B.Tech', 'Computer Science', 'Engineering', 'General', 150000.00, 1),
    ('2023-24', 'Engineering College', 'B.Tech', 'Mechanical', 'Engineering', 'SC/ST', 100000.00, 1),
    ('2023-24', 'Medical College', 'MBBS', 'Medicine', 'Medical', 'General', 200000.00, 1),
    ('2023-24', 'Arts College', 'BA', 'English', 'Arts', 'General', 50000.00, 1),
    ('2022-23', 'Engineering College', 'B.Tech', 'Computer Science', 'Engineering', 'General', 140000.00, 1)";
    
    if ($conn->query($sample_data)) {
        echo "Sample data inserted successfully<br>";
    } else {
        echo "Error inserting sample data: " . $conn->error . "<br>";
    }
}

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
$sample_query = "SELECT * FROM 1_student_fee LIMIT 5";
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