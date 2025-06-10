<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $conn = new PDO(
        "mysql:host=localhost;dbname=gmu;charset=utf8mb4",
        "root",
        "",
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    echo "Database connection successful!\n";
    
    // Test if table exists
    $stmt = $conn->query("SHOW TABLES LIKE 'ad_enquiry'");
    if ($stmt->rowCount() > 0) {
        echo "Table 'ad_enquiry' exists!\n";
        
        // Get column information
        $stmt = $conn->query("DESCRIBE ad_enquiry");
        echo "\nTable structure:\n";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo $row['Field'] . " - " . $row['Type'] . "\n";
        }
    } else {
        echo "Table 'ad_enquiry' does not exist!";
    }
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?> 