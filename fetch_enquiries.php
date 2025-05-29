<?php
/**
 * Professional Admission Enquiry Data Handler
 * Handles DataTables server-side processing with SearchPanes
 */

// Set error reporting for development (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set content type and CORS headers
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

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
    
    private $searchableColumns = [1, 2, 3, 5, 6, 7, 8, 12]; // Indices for SearchPanes
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
        $this->initializeDatabase();
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
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
            ];

            $this->conn = new PDO($dsn, DatabaseConfig::USERNAME, DatabaseConfig::PASSWORD, $options);
            
        } catch (PDOException $e) {
            $this->sendErrorResponse("Database connection failed: " . $e->getMessage());
        }
    }

    public function processRequest() {
        try {
            // Validate request method
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception("Only POST requests are allowed");
            }

            // Get request parameters
            $draw = $this->getIntParam('draw', 1);
            $start = $this->getIntParam('start', 0);
            $length = $this->getIntParam('length', 10);
            $searchValue = $this->getStringParam('search.value', '');
            $orderColumn = $this->getIntParam('order.0.column', 0);
            $orderDir = $this->getStringParam('order.0.dir', 'desc');
            
            // Validate order direction
            $orderDir = in_array(strtolower($orderDir), ['asc', 'desc']) ? $orderDir : 'desc';
            
            // Validate order column
            if ($orderColumn < 0 || $orderColumn >= count($this->columns)) {
                $orderColumn = 0;
            }

            // Build base query
            $baseQuery = "SELECT " . implode(", ", $this->columns) . " FROM ad_enquiry";
            $whereClause = " WHERE 1=1";
            $params = [];

            // Handle SearchPane filters
            $searchPaneFilters = $this->processSearchPanes();
            if (!empty($searchPaneFilters['clause'])) {
                $whereClause .= $searchPaneFilters['clause'];
                $params = array_merge($params, $searchPaneFilters['params']);
            }

            // Handle global search
            $globalSearchFilter = $this->processGlobalSearch($searchValue);
            if (!empty($globalSearchFilter['clause'])) {
                $whereClause .= $globalSearchFilter['clause'];
                $params = array_merge($params, $globalSearchFilter['params']);
            }

            // Get total records count
            $totalRecords = $this->getTotalRecords();

            // Get filtered records count
            $filteredRecords = $this->getFilteredRecords($baseQuery . $whereClause, $params);

            // Get SearchPanes data
            $searchPanesData = $this->getSearchPanesData();

            // Build final query with ordering and pagination
            $orderColumnName = $this->columns[$orderColumn];
            $finalQuery = $baseQuery . $whereClause . " ORDER BY {$orderColumnName} {$orderDir}";
            
            if ($length != -1) {
                $finalQuery .= " LIMIT :start, :length";
                $params['start'] = $start;
                $params['length'] = $length;
            }

            // Execute final query
            $data = $this->executeDataQuery($finalQuery, $params);

            // Send response
            $this->sendSuccessResponse([
                'draw' => $draw,
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'data' => $data,
                'searchPanes' => $searchPanesData
            ]);

        } catch (Exception $e) {
            $this->sendErrorResponse($e->getMessage());
        }
    }

    private function processSearchPanes() {
        $clause = "";
        $params = [];
        
        if (isset($_POST['searchPanes']) && !empty($_POST['searchPanes'])) {
            $searchPanes = json_decode($_POST['searchPanes'], true);
            
            if (is_array($searchPanes) && !empty($searchPanes)) {
                $conditions = [];
                
                foreach ($searchPanes as $columnIndex => $selectedValues) {
                    if (isset($this->filterableColumns[$columnIndex]) && !empty($selectedValues)) {
                        $columnName = $this->filterableColumns[$columnIndex];
                        $placeholders = [];
                        
                        foreach ($selectedValues as $i => $value) {
                            $paramKey = "sp_{$columnIndex}_{$i}";
                            $placeholders[] = ":{$paramKey}";
                            $params[$paramKey] = $value;
                        }
                        
                        if (!empty($placeholders)) {
                            $conditions[] = "{$columnName} IN (" . implode(", ", $placeholders) . ")";
                        }
                    }
                }
                
                if (!empty($conditions)) {
                    $clause = " AND (" . implode(" OR ", $conditions) . ")";
                }
            }
        }
        
        return ['clause' => $clause, 'params' => $params];
    }

    private function processGlobalSearch($searchValue) {
        $clause = "";
        $params = [];
        
        if (!empty($searchValue)) {
            $searchConditions = [];
            
            foreach ($this->columns as $i => $column) {
                $paramKey = "search_{$i}";
                $searchConditions[] = "{$column} LIKE :{$paramKey}";
                $params[$paramKey] = "%{$searchValue}%";
            }
            
            if (!empty($searchConditions)) {
                $clause = " AND (" . implode(" OR ", $searchConditions) . ")";
            }
        }
        
        return ['clause' => $clause, 'params' => $params];
    }

    private function getTotalRecords() {
        try {
            $stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM ad_enquiry");
            $stmt->execute();
            $result = $stmt->fetch();
            return (int)$result['count'];
        } catch (PDOException $e) {
            throw new Exception("Error getting total records: " . $e->getMessage());
        }
    }

    private function getFilteredRecords($query, $params) {
        try {
            $countQuery = "SELECT COUNT(*) as count FROM (" . $query . ") as filtered_table";
            $stmt = $this->conn->prepare($countQuery);
            
            foreach ($params as $key => $value) {
                if ($key !== 'start' && $key !== 'length') {
                    $stmt->bindValue(":{$key}", $value);
                }
            }
            
            $stmt->execute();
            $result = $stmt->fetch();
            return (int)$result['count'];
        } catch (PDOException $e) {
            throw new Exception("Error getting filtered records: " . $e->getMessage());
        }
    }

    private function executeDataQuery($query, $params) {
        try {
            $stmt = $this->conn->prepare($query);
            
            foreach ($params as $key => $value) {
                if ($key === 'start' || $key === 'length') {
                    $stmt->bindValue(":{$key}", (int)$value, PDO::PARAM_INT);
                } else {
                    $stmt->bindValue(":{$key}", $value);
                }
            }
            
            $stmt->execute();
            $data = [];
            
            while ($row = $stmt->fetch()) {
                // Format data for display
                $formattedRow = [];
                foreach ($this->columns as $column) {
                    $value = $row[$column] ?? '';
                    
                    // Special formatting for specific columns
                    switch ($column) {
                        case 'enquiry_date':
                            $formattedRow[] = $value ? date('Y-m-d', strtotime($value)) : '';
                            break;
                        case 'mobile_no':
                            $formattedRow[] = $value ? preg_replace('/(\d{3})(\d{3})(\d{4})/', '$1-$2-$3', $value) : '';
                            break;
                        case 'email':
                            $formattedRow[] = strtolower($value);
                            break;
                        case 'status':
                            $formattedRow[] = ucfirst(strtolower($value));
                            break;
                        default:
                            $formattedRow[] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
                    }
                }
                $data[] = $formattedRow;
            }
            
            return $data;
        } catch (PDOException $e) {
            throw new Exception("Error executing data query: " . $e->getMessage());
        }
    }

    private function getSearchPanesData() {
        $searchPanesData = [];
        
        foreach ($this->filterableColumns as $index => $column) {
            try {
                $query = "SELECT DISTINCT {$column} as value, COUNT(*) as total 
                         FROM ad_enquiry 
                         WHERE {$column} IS NOT NULL AND TRIM({$column}) != '' 
                         GROUP BY {$column} 
                         ORDER BY total DESC, {$column} ASC 
                         LIMIT 100";
                
                $stmt = $this->conn->prepare($query);
                $stmt->execute();
                
                $options = [];
                while ($row = $stmt->fetch()) {
                    if (!empty(trim($row['value']))) {
                        $options[] = [
                            'label' => htmlspecialchars($row['value'], ENT_QUOTES, 'UTF-8'),
                            'value' => $row['value'],
                            'total' => (int)$row['total']
                        ];
                    }
                }
                
                $searchPanesData[$index] = [
                    'options' => $options
                ];
                
            } catch (PDOException $e) {
                // Log error but continue with other columns
                error_log("SearchPane error for column {$column}: " . $e->getMessage());
                $searchPanesData[$index] = ['options' => []];
            }
        }
        
        return $searchPanesData;
    }

    private function getIntParam($key, $default = 0) {
        $keys = explode('.', $key);
        $value = $_POST;
        
        foreach ($keys as $k) {
            if (isset($value[$k])) {
                $value = $value[$k];
            } else {
                return $default;
            }
        }
        
        return is_numeric($value) ? (int)$value : $default;
    }

    private function getStringParam($key, $default = '') {
        $keys = explode('.', $key);
        $value = $_POST;
        
        foreach ($keys as $k) {
            if (isset($value[$k])) {
                $value = $value[$k];
            } else {
                return $default;
            }
        }
        
        return is_string($value) ? trim($value) : $default;
    }

    private function sendSuccessResponse($data) {
        echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        exit;
    }

    private function sendErrorResponse($message) {
        $response = [
            'error' => $message,
            'draw' => $this->getIntParam('draw', 1),
            'recordsTotal' => 0,
            'recordsFiltered' => 0,
            'data' => [],
            'searchPanes' => []
        ];
        
        http_response_code(500);
        echo json_encode($response, JSON_PRETTY_PRINT);
        exit;
    }

    public function __destruct() {
        $this->conn = null;
    }
}

// Handle the request
try {
    $handler = new EnquiryDataHandler();
    $handler->processRequest();
} catch (Exception $e) {
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode([
        'error' => 'System error: ' . $e->getMessage(),
        'draw' => isset($_POST['draw']) ? (int)$_POST['draw'] : 1,
        'recordsTotal' => 0,
        'recordsFiltered' => 0,
        'data' => []
    ]);
}
?>