<?php
/**
 * Professional Admission Enquiry Data Handler
 * Handles DataTables server-side processing with SearchPanes
 * Fixed version for proper JSON handling
 */

// Error handling
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set proper headers
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Database configuration
class DatabaseConfig {
    const HOST = "localhost";
    const USERNAME = "root";
    const PASSWORD = "";
    const DATABASE = "gmu";
    const CHARSET = "utf8mb4";
}

class EnquiryDataHandler {
    private $conn;
    private $input = [];
    
    private $columns = [
        'enquiry_no',
        'source', 
        'status',
        'admission_year',
        'enquiry_date',
        'college',
        'programme',
        'course',
        'discipline',
        'name',
        'mobile_no',
        'email',
        'state'
    ];
    
    private $searchableColumns = [1, 2, 3, 5, 6, 7, 8, 12];
    
    private $filterableColumns = [
        1 => 'source',
        2 => 'status', 
        3 => 'admission_year',
        5 => 'college',
        6 => 'programme',
        7 => 'course',
        8 => 'discipline',
        12 => 'state'
    ];

    public function __construct() {
        $this->parseInput();
        $this->initializeDatabase();
    }

    private function parseInput() {
        // Handle different input methods
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
            
            if (strpos($contentType, 'application/json') !== false) {
                // Handle JSON input
                $rawInput = file_get_contents('php://input');
                $this->input = json_decode($rawInput, true);
                
                if (json_last_error() !== JSON_ERROR_NONE) {
                    $this->sendErrorResponse("Invalid JSON input");
                }
            } else {
                // Handle form data (standard DataTables POST)
                $this->input = $_POST;
            }
        } else {
            // Handle GET parameters
            $this->input = $_GET;
        }
        
        // Ensure input is array
        if (!is_array($this->input)) {
            $this->input = [];
        }
    }

    private function initializeDatabase() {
        try {
            $dsn = sprintf(
                "mysql:host=%s;dbname=%s;charset=%s",
                DatabaseConfig::HOST,
                DatabaseConfig::DATABASE,
                DatabaseConfig::CHARSET
            );
            
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ];

            $this->conn = new PDO($dsn, DatabaseConfig::USERNAME, DatabaseConfig::PASSWORD, $options);
            
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            $this->sendErrorResponse("Database connection failed");
        }
    }

    public function processRequest() {
        try {
            // Extract and validate parameters
            $draw = isset($this->input['draw']) ? (int)$this->input['draw'] : 1;
            $start = isset($this->input['start']) ? max(0, (int)$this->input['start']) : 0;
            $length = isset($this->input['length']) ? min(1000, max(1, (int)$this->input['length'])) : 25;
            
            // Search value
            $searchValue = '';
            if (isset($this->input['search'])) {
                if (is_array($this->input['search']) && isset($this->input['search']['value'])) {
                    $searchValue = trim($this->input['search']['value']);
                } elseif (is_string($this->input['search'])) {
                    $searchValue = trim($this->input['search']);
                }
            }
            
            // Order parameters
            $orderColumn = 0;
            $orderDir = 'DESC';
            if (isset($this->input['order']) && is_array($this->input['order']) && count($this->input['order']) > 0) {
                $orderColumn = max(0, min(count($this->columns) - 1, (int)($this->input['order'][0]['column'] ?? 0)));
                $orderDir = strtoupper($this->input['order'][0]['dir'] ?? 'DESC');
                $orderDir = in_array($orderDir, ['ASC', 'DESC']) ? $orderDir : 'DESC';
            }

            // Build base query
            $baseQuery = "SELECT " . implode(", ", $this->columns) . " FROM ad_enquiry";
            
            // Build WHERE clause and parameters
            $whereConditions = [];
            $params = [];
            
            // Add search condition
            if (!empty($searchValue)) {
                $searchConditions = [];
                foreach ($this->searchableColumns as $colIndex) {
                    if (isset($this->columns[$colIndex])) {
                        $searchConditions[] = $this->columns[$colIndex] . " LIKE :search";
                    }
                }
                if (!empty($searchConditions)) {
                    $whereConditions[] = "(" . implode(" OR ", $searchConditions) . ")";
                    $params['search'] = "%" . $searchValue . "%";
                }
            }

            // Handle SearchPanes filters
            if (isset($this->input['searchPanes']) && is_array($this->input['searchPanes'])) {
                foreach ($this->input['searchPanes'] as $columnIndex => $selectedValues) {
                    if (!empty($selectedValues) && is_array($selectedValues) && isset($this->filterableColumns[$columnIndex])) {
                        $column = $this->filterableColumns[$columnIndex];
                        $placeholders = [];
                        foreach ($selectedValues as $i => $value) {
                            $paramKey = "filter_{$columnIndex}_{$i}";
                            $placeholders[] = ":" . $paramKey;
                            $params[$paramKey] = $value;
                        }
                        if (!empty($placeholders)) {
                            $whereConditions[] = "$column IN (" . implode(", ", $placeholders) . ")";
                        }
                    }
                }
            }

            // Combine WHERE conditions
            $whereClause = empty($whereConditions) ? "" : " WHERE " . implode(" AND ", $whereConditions);

            // Get total count
            $totalStmt = $this->conn->query("SELECT COUNT(*) FROM ad_enquiry");
            $recordsTotal = (int)$totalStmt->fetchColumn();

            // Get filtered count
            $filteredQuery = "SELECT COUNT(*) FROM ad_enquiry" . $whereClause;
            $filteredStmt = $this->conn->prepare($filteredQuery);
            foreach ($params as $key => $value) {
                $filteredStmt->bindValue(":$key", $value);
            }
            $filteredStmt->execute();
            $recordsFiltered = (int)$filteredStmt->fetchColumn();

            // Get data
            $orderColumnName = $this->columns[$orderColumn];
            $dataQuery = $baseQuery . $whereClause . " ORDER BY $orderColumnName $orderDir LIMIT :start, :length";
            
            $dataStmt = $this->conn->prepare($dataQuery);
            foreach ($params as $key => $value) {
                $dataStmt->bindValue(":$key", $value);
            }
            $dataStmt->bindValue(':start', $start, PDO::PARAM_INT);
            $dataStmt->bindValue(':length', $length, PDO::PARAM_INT);
            $dataStmt->execute();
            
            $data = $dataStmt->fetchAll();

            // Get SearchPanes data
            $searchPanes = $this->getSearchPanesData();

            // Prepare response
            $response = [
                'draw' => $draw,
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $data,
                'searchPanes' => [
                    'options' => $searchPanes
                ]
            ];

            // Output JSON response
            echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
            exit;

        } catch (Exception $e) {
            error_log("Error processing request: " . $e->getMessage());
            $this->sendErrorResponse($e->getMessage());
        }
    }

    private function getSearchPanesData() {
        $searchPanes = [];
        
        foreach ($this->filterableColumns as $index => $column) {
            try {
                $stmt = $this->conn->prepare(
                    "SELECT $column as value, COUNT(*) as total, COUNT(*) as count
                     FROM ad_enquiry 
                     WHERE $column IS NOT NULL AND TRIM($column) != '' 
                     GROUP BY $column 
                     ORDER BY total DESC, $column ASC
                     LIMIT 200"
                );
                $stmt->execute();
                
                $options = [];
                while ($row = $stmt->fetch()) {
                    $value = trim($row['value']);
                    if (!empty($value)) {
                        $options[] = [
                            'label' => $value,
                            'value' => $value,
                            'total' => (int)$row['total'],
                            'count' => (int)$row['count']
                        ];
                    }
                }
                
                $searchPanes[$index] = $options;
                
            } catch (Exception $e) {
                error_log("SearchPanes error for column $column: " . $e->getMessage());
                $searchPanes[$index] = [];
            }
        }
        
        return $searchPanes;
    }

    private function sendErrorResponse($message) {
        http_response_code(500);
        echo json_encode([
            'error' => $message,
            'draw' => $this->input['draw'] ?? 1,
            'recordsTotal' => 0,
            'recordsFiltered' => 0,
            'data' => [],
            'searchPanes' => [
                'options' => []
            ]
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
}

// Initialize and process request
try {
    $handler = new EnquiryDataHandler();
    $handler->processRequest();
} catch (Exception $e) {
    error_log("Fatal error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'error' => 'System error occurred',
        'draw' => 1,
        'recordsTotal' => 0,
        'recordsFiltered' => 0,
        'data' => [],
        'searchPanes' => [
            'options' => []
        ]
    ]);
}
?>