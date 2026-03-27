<?php
/**
 * Secure Database Connection
 * Uses mysqli with prepared statements to prevent SQL injection
 */

// Database configuration
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'a');
define('DB_PASS', ''); // No password as specified
define('DB_NAME', 'bank');

/* $host = '127.0.0.1'; */
/* $user = 'a'; */
/* $pass = ''; */
/* $db   = 'bank'; */

/**
 * Create secure database connection
 * @return mysqli|false Returns mysqli object or false on failure
 */
function getDBConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // Check connection
    if ($conn->connect_error) {
        error_log("Database connection failed: " . $conn->connect_error);
        return false;
    }
    
    // Set charset to prevent character encoding attacks
    $conn->set_charset("utf8mb4");
    
    return $conn;
}

/**
 * Helper function to execute prepared statements securely
 * @param string $sql SQL query with placeholders (?)
 * @param string $types Types of parameters (s=string, i=integer, d=double, b=blob)
 * @param array $params Array of parameters to bind
 * @return mysqli_stmt|false Returns statement object or false on failure
 */
function executeSecureQuery($sql, $types = "", $params = []) {
    $conn = getDBConnection();
    if (!$conn) return false;
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error);
        $conn->close();
        return false;
    }
    
    // Bind parameters if provided
    if (!empty($types) && !empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    
    if (!$stmt->execute()) {
        error_log("Execute failed: " . $stmt->error);
        $stmt->close();
        $conn->close();
        return false;
    }
    
    return $stmt;
}
?>
